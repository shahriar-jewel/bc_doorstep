<?php

namespace App\Http\Controllers\Api\Bkash;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\BkashApiToken;
use App\Models\OrderPaymentLog;
use App\Models\OrderTransactionLog;
use App\Models\PaymentRequestLog;
use App\Models\PaymentRefundLog;
use App\Models\TempOrder;

use Ramsey\Uuid\Uuid;

use App\Http\Controllers\MicrositeController;

class BkashWebController extends Controller
{
	/**
     * @var string
     */
	private $APP_KEY;
	
	/**
     * @var string
     */
	private $APP_SECRET;
	
	/**
     * @var string
     */
	private $BKASH_USERNAME;
	
	/**
     * @var string
     */
	private $BKASH_PASSWORD;

	/**
     * @var int
     */
	private $API_TIMEOUT;

	/**
     * @var Array
     */
	private $config;

	/**
     * BkashController Constructor
     *
     */
	public function __construct()
	{
		if (env("BKASH_IS_SANDBOX", true)) 
			$this->config = config('bkash.sandbox_web');
		else
			$this->config = config('bkash.production_web');
		
		$this->API_TIMEOUT = 30;
	}

	/**
	 * Load index view
	 *
	 */
    public function index()
    {
    	// return view('pay');
    }

    /**
	 * Create Payment API
	 *
	 * return $result
	 */
    public function createPayment(Request $request)
    {
    	$rules = array(
            'amount'            => 'required',
            'intent'            => 'required',
            'temporderid'       => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            $errors = $validator->messages()->toArray();
            $msg = "Validation Error!" ;
            $data = [
                'errorMessage'  => "Missing required field",
                'errorDetail' => $errors
            ];
            
			$result = json_encode($data);

			return $data;
        }
        else
        {
        
	    	$token = $this->getToken();

	    	if ($token) 
	    	{
		    	$amount = $request->input('amount');
		    	$intent = $request->input('intent');
		    	$temporderid = $request->input('temporderid');
		    	$invoice = 'sandboxweb_'.uniqid();

				$temporderInfo = TempOrder::where('temporderUUID',$temporderid)->first();

				if ($temporderInfo) {
					$temporderid 	= $temporderInfo->temporderid;
					$amount 		= $temporderInfo->ordertotal;
				}else{
					$data = [
		                'errorMessage'  => "Use valid data"
		            ];
					$result = json_encode($data);
					return $data;
				}

		    	$requestData=array(
					'amount'=>$amount,
					'currency'=>'BDT',
					'intent'=>'sale',
					'merchantInvoiceNumber'=>$invoice
				);  

				$url=curl_init($this->config['apiBaseURL'].$this->config['apiUrl']['create_payment']);   
				$requestDataJson=json_encode($requestData);
				$header=array(
					'Content-Type:application/json',
					'authorization: '.$token,
					'x-app-key: '.$this->config['apiCredentials']['app_key']
				);
				curl_setopt($url,CURLOPT_TIMEOUT, $this->API_TIMEOUT);
	        	curl_setopt($url,CURLOPT_CONNECTTIMEOUT, $this->API_TIMEOUT);
				curl_setopt($url,CURLOPT_HTTPHEADER, $header);
				curl_setopt($url,CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
				curl_setopt($url,CURLOPT_POSTFIELDS, $requestDataJson);
				curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
				
				$result = curl_exec($url);

				$allReqData['headers'] = $header;
				$allReqData['body_params'] = $requestData;


			    $log['customerid'] = session()->get('bkash_customerid');
			    $log['temporderid'] = $temporderid;
			    $log['transaction_id'] = $invoice;
			    $log['create_payment_req'] = json_encode($allReqData);
			    $log['create_payment_res'] = $result;
			    PaymentRequestLog::create($log);

	            $code = curl_getinfo($url, CURLINFO_HTTP_CODE);
				$resultArray = json_decode($result,true);

			    if ($code == 200 && !( curl_errno($url)) && isset($resultArray['paymentID']) )
			    {
			        curl_close($url);
			        $tran['tran_log_UUID'] 		= (string) Uuid::uuid4();
			        $tran['customerid'] 		= session()->get('bkash_customerid');
			        $tran['temporderid'] 		= $temporderid;
			        $tran['tran_payment_id'] 	= $resultArray['paymentID'];
			        $tran['tran_status'] 		= $resultArray['transactionStatus'];
			        $tran['tran_id'] 			= $invoice;
			        $tran['tran_amount'] 		= $amount;
			        $tran['created_at'] 		= date('Y-m-d H:i:s');
			        OrderTransactionLog::create($tran);
			    }
			    else
			    {
			    	if ($error_number = curl_errno($url)) {
					    if (in_array($error_number, array(CURLE_OPERATION_TIMEDOUT, CURLE_OPERATION_TIMEOUTED))) {
					        $temp = array('errorMessage'=>'Request Timed Out');
					        $result = json_encode($temp);
					    }
					}
			        curl_close($url);
			    }
		    }
		    else
		    {
		    	$temp = array('errorMessage'=>'Token Not Found');
				$result = json_encode($temp);
		    }

		    echo $result;
		}
    }

    /**
	 * Execute Payment API
	 *
	 * @param request
	 * return json result 
	 */
    public function executePayment(Request $request)
    {
    	$paymentID = $request->input('paymentID');
    	$invoiceNo = $request->input('invoiceNo');
	    $temporderid = $request->input('temporderid');
    	$token = $this->getToken();

		$url = curl_init($this->config['apiBaseURL'].$this->config['apiUrl']['execute_payment'].$paymentID);   
		$header=array(
			'Content-Type:application/json',
			'authorization: '.$token,
			'x-app-key: '.$this->config['apiCredentials']['app_key']
		);

		curl_setopt($url,CURLOPT_TIMEOUT, $this->API_TIMEOUT);
        curl_setopt($url,CURLOPT_CONNECTTIMEOUT, $this->API_TIMEOUT);
		curl_setopt($url,CURLOPT_HTTPHEADER, $header);
		curl_setopt($url,CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
		
		$result = curl_exec($url);

		$this->paymentLog($url,$result,1,$invoiceNo);

		$code = curl_getinfo($url, CURLINFO_HTTP_CODE);
		$resultArray = json_decode($result,true);

	    if ($code == 200 && !( curl_errno($url)))
	    {
	        curl_close($url);
	        $this->updatePayment($resultArray,$temporderid,$invoiceNo);
	    }
	    else
	    {
	    	if ($error_number = curl_errno($url)) {
			    if (in_array($error_number, array(CURLE_OPERATION_TIMEDOUT, CURLE_OPERATION_TIMEOUTED))) {
			        $result = $this->queryPayment($paymentID);
					$this->paymentLog($url,$result,2,$invoiceNo);

					$resultArray = json_decode($result,true);
	        		$this->updatePayment($resultArray,$temporderid,$invoiceNo);
			    }
			}
	        curl_close($url);
	    }

    	echo $result;
    }

    /**
	 * Update Payment Related info and Order data
	 *
	 * @param resultArray
	 * @param temporderid
	 * @param invoiceNo
	 * return boolean 
	 */
    private function updatePayment($resultArray,$temporderid,$invoiceNo)
    {
    	if (isset($resultArray['transactionStatus']) && $resultArray['transactionStatus'] == 'Completed') 
        {
        	try{
	        	TempOrder::where('temporderUUID', $temporderid)->update(['paymentstatus' => 1]);

	        	$microSite = new MicrositeController;
    			$orderID   = $microSite->placeOrderWeb($temporderid);

	        	$searchTransactionResult = array();
	        	if ( isset($resultArray['trxID']) && !is_null($resultArray['trxID']) ) 
	        	{
	        		$searchTransactionResult = $this->searchTransaction($resultArray['trxID']);
	        	}

		        $transactionDetails = OrderTransactionLog::where('tran_id',$invoiceNo)->first();
			    if ($transactionDetails) {
			        // update Transaction Table
			        $transactionDetails->tran_status        = $resultArray['transactionStatus'];
			        // $transactionDetails->tran_date          = $resultArray['createTime'];
			        $transactionDetails->orderid 			= $orderID; 	
			        $transactionDetails->tran_bank_id 		= $resultArray['trxID'];
			        $transactionDetails->tran_amount        = $resultArray['amount'];
			        $transactionDetails->store_amount       = $resultArray['amount'];
			        $transactionDetails->json_data          = $searchTransactionResult;
			        $transactionDetails->save();
			    }

			    $transactionLogID = $transactionDetails->tran_log_id;

			    // insert into Payment Table
			    $paymnt['order_payment_UUID'] = (string) Uuid::uuid4();
			    $paymnt['customerid'] 	= session()->get('bkash_customerid');
			    $paymnt['orderid'] 		= $orderID; 	
			    $paymnt['paid_amount']  = $resultArray['amount'];
			    // $paymnt['paid_date'] = $resultArray['createTime'];
			    $paymnt['payment_type'] = 3; // bKash
			    $paymnt['tran_log_id'] 	= $transactionLogID;
			    $paymnt['created_by'] 	= session()->get('bkash_customerid');
			    $paymnt['created_at'] 	= date('Y-m-d H:i:s');

			    OrderPaymentLog::create($paymnt);

			    return true;
        	}catch (\Exception $e) {
			    return $e;
			}
        }
        else
        {
        	return false;
        }
    }


    /**
	 * Query Payment API
	 *
	 * @param paymentID
	 * return json result 
	 */
    public function queryPayment($paymentID)
    {

    	$token = $this->getToken();

		$url = curl_init($this->config['apiBaseURL'].$this->config['apiUrl']['query_payment'].$paymentID);   
		$header=array(
			'Content-Type:application/json',
			'authorization: '.$token,
			'x-app-key: '.$this->config['apiCredentials']['app_key']
		);

		curl_setopt($url,CURLOPT_TIMEOUT, $this->API_TIMEOUT);
        curl_setopt($url,CURLOPT_CONNECTTIMEOUT, $this->API_TIMEOUT);
		curl_setopt($url,CURLOPT_HTTPHEADER, $header);
		curl_setopt($url,CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
		
		$result = curl_exec($url);
		curl_close($url);

    	return $result;
    }

    /**
	 * Search Transaction API
	 *
	 * @param request
	 * return json result 
	 */
    public function searchTransaction($trxID)
    {
    	// $trxID = $request->input('trxID');
    	$token = $this->getToken();

		$url = curl_init($this->config['apiBaseURL'].$this->config['apiUrl']['search_transaction'].$trxID);   
		$header=array(
			'Content-Type:application/json',
			'authorization: '.$token,
			'x-app-key: '.$this->config['apiCredentials']['app_key']
		);

		curl_setopt($url,CURLOPT_TIMEOUT, $this->API_TIMEOUT);
        curl_setopt($url,CURLOPT_CONNECTTIMEOUT, $this->API_TIMEOUT);
		curl_setopt($url,CURLOPT_HTTPHEADER, $header);
		curl_setopt($url,CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
		
		$result = curl_exec($url);
		curl_close($url);

    	return $result;
    }

    /**
	 * Refund Payment API
	 *
	 * @param request
	 * return json result 
	 */
    public function refundPayment($orderID,$amount,$reason)
    {

    	$orderTranLog = OrderTransactionLog::where('orderid',$orderID)
    										->where('tran_status','Completed')
    										->first();
    	if ($orderTranLog) {
    		if ($orderTranLog->tran_amount < $amount) 
    		{
    			$data = [
		            'errorMessage'     => "Amount cannot be greater than actual amount."
		        ];
    			return $data;
    		}
	    	$requestData=array(
				'paymentID'	=> $orderTranLog->tran_payment_id,
				'amount'	=> $amount,
				'trxID'		=> $orderTranLog->tran_bank_id,
				'sku'		=> $orderTranLog->tran_id,
				'reason'	=> $reason
			);  

	    	$token = $this->getToken();
			$url=curl_init($this->config['apiBaseURL'].$this->config['apiUrl']['refund_payment']);   
			$requestDataJson=json_encode($requestData);
			$header=array(
				'Content-Type:application/json',
				'Accept:application/json',
				'authorization: '.$token,
				'x-app-key: '.$this->config['apiCredentials']['app_key']
			);
			curl_setopt($url,CURLOPT_TIMEOUT, $this->API_TIMEOUT);
	    	curl_setopt($url,CURLOPT_CONNECTTIMEOUT, $this->API_TIMEOUT);
			curl_setopt($url,CURLOPT_HTTPHEADER, $header);
			curl_setopt($url,CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
			curl_setopt($url,CURLOPT_POSTFIELDS, $requestDataJson);
			curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
			
			$result = curl_exec($url);

			// $this->paymentLog($url,$result,1,$invoiceNo);

			$code = curl_getinfo($url, CURLINFO_HTTP_CODE);
			$resultArray = json_decode($result,true);

			$log['orderid'] = $orderID;
		    $log['refund_type'] = $orderTranLog->tran_amount > $amount ? 2 : 1 ; // 2 - partial; 1 - Full
		    $log['original_trxid'] = $orderTranLog->tran_bank_id;
		    $log['refund_trxid'] = isset($resultArray['refundTrxID'])?$resultArray['refundTrxID'] : null ;
		    $log['refund_req'] = $requestDataJson;
		    $log['refund_res'] = $result;
		    $log['created_by'] = session()->get('doorstepuser.userid');
		    PaymentRefundLog::create($log);

		    if ($code == 200 && !( curl_errno($url)))
		    {
		        curl_close($url);
		    }
		    else
		    {
		    	if ($error_number = curl_errno($url)) {
				    if (in_array($error_number, array(CURLE_OPERATION_TIMEDOUT, CURLE_OPERATION_TIMEOUTED))) {
				        //TODO
				    }
				}
		        curl_close($url);
		    }

	    	return $resultArray;
    	}
    }


    /**
	 * Get Token
	 *
	 * return stirng 
	 */
    private function getToken($count=1)
    {
    	if ($count > 2) {
    		return false;
    	}
    	$tokenInfo = BkashApiToken::orderBy('id', 'desc')
    							->where('expire_date', '>', date('Y-m-d H:i:s'))
    							->where('token_for',3)
    							->first();

        if ( $tokenInfo ) 
        {
            $idToken = $tokenInfo->id_token;
        }
        else
        {
    		$token = $this->generateToken();

    		if ($token) {
    			return $this->getToken(++$count);
    		}else{
            	return false;
    		}
        }

        return $idToken;
    }

    /**
	 * Generate Token using grant token api
	 *
	 * return stirng 
	 */
    private function generateToken()
    {
    	$request_data = array(
	    	'app_key'=> $this->config['apiCredentials']['app_key'],
	    	'app_secret'=>$this->config['apiCredentials']['app_secret']
	    );  

		$url = curl_init($this->config['apiBaseURL'].$this->config['apiUrl']['grant_token']);   
		$request_data_json=json_encode($request_data);
		$header = array(
		    'Content-Type:application/json',
		    'username:'.$this->config['apiCredentials']['username'],               
		    'password:'.$this->config['apiCredentials']['password']
		    );              
		curl_setopt($url,CURLOPT_HTTPHEADER, $header);
		curl_setopt($url,CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($url,CURLOPT_POSTFIELDS, $request_data_json);
		curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

		$result = curl_exec($url);
		curl_close($url);

		$resultData = json_decode($result,true);

		if (isset($resultData['id_token']) ) 
        {
            $tokenInfo = new BkashApiToken;
            $tokenInfo->id_token  		= $resultData['id_token'];
            $tokenInfo->token_type      = $resultData['token_type'];
            $tokenInfo->expires_in      = $resultData['expires_in'];
    		$tokenInfo->expire_date 	= date("Y-m-d H:i:s", time() + $resultData['expires_in']);
            $tokenInfo->refresh_token   = $resultData['refresh_token'];
            $tokenInfo->raw_response  	= $result;
            $tokenInfo->created_at    = date('Y-m-d H:i:s');
            $tokenInfo->token_for       = 3 ; // 3-website
            $tokenInfo->save();

            return true;
        }
        else
        {
            return false;
        }

    }


    private function paymentLog($req,$res,$type,$transactionID)
    {
        $paymentLogDetails = PaymentRequestLog::where('transaction_id',$transactionID)->first();
        if ($paymentLogDetails) {
            switch ($type) {
                case '1': // 1 for request info log from gateway
                    // $paymentLogDetails->req_body_from_gateway   = json_encode($req);
                    $paymentLogDetails->execute_payment_res            = $res;
                    break;
                case '2': // 2 for Transaction validation log
                    // $paymentLogDetails->transaction_validate_req = $req;
                    $paymentLogDetails->query_payment_res = $res;
                    break;
                default:
                    # code...
                    break;
            }
            $paymentLogDetails->save();
        }
        return;
    }



}
