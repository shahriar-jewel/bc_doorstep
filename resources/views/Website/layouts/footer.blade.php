 <style type="text/css">
  #Div2, #Div4 {
    display: none;
  }

  #Div1,#Div3{
    background-image: url('WebsiteCSSJS/img/plus.png')
  }

  #Div2,#Div4{
    background-image: url('WebsiteCSSJS/img/minus.png')
  }


  @media screen and (max-width: 768px) {
   .img-small{
     border-bottom: 3px solid white; 

   }  

 /* .img-small:after{
     content:" ";
     display:block;
     width:100%;
     height: 20px;
     background-image:url('../img/bg/line-med-horz.png');
     position:absolute;
     bottom:-10px;
     left:0px;
 }
 */
}
</style> 

<div id="node-111" class="node node-node-blocks clearfix" style="">

  
<div class="" style="border-top: 4px solid #ED7901">
    <footer class="container-fluid">
      <div class="footerBg">
        <div class="row ">
          <div class="col-sm-4 " style="">
            <ul class="footerLinks footerlinks-right" style="">
              <li  style="">
                <h4 class="img-small">BK INFO 
                               <!--  <i class="icon icon_plus-white"></i>
                                 <i class="icon icon_minus-white"></i> -->
                                <!-- <i class="icon icon_plus-orange" style="border: 1px solid red; float: right; background-repeat: no-repeat;background-image: url('img/plus.png'); margin-top: 10px;">
                                  
                                </i>
                                <i class="icon icon_minus-orange"></i> -->
                                <i class="icon icon_plus-orange pull-right"  id="Div1" onclick="switchVisible()" ></i>
                                <i class="icon icon_plus-orange pull-right"  id="Div2"  onclick="switchVisible()"></i>
                                <!--  <i class="icon icon_plus-orange" style="border: 1px solid red; float: right; background-repeat: no-repeat;background-image: url('img/minus.png'); margin-top: 10px;"></i> -->

                              </h4>
                              <ul class="subList clearfix ">
                                <li>PRESS RELEASE</li>
                              </ul>
                            </li>
                          </ul>
                        </div>

                        <div class="col-sm-4 " >
                          <ul class="footerLinks"  >
                            <li><h4 class="share-web" >SOCIAL MEDIA</h4>

                            </li>

                            <li style="" class="share-icon ">
                              <div class="socialLinks" >
                                <a href="https://www.facebook.com/burgerking/" target="_blank">
                                  <img src="{{ asset('WebsiteCSSJS/img/sm_icon-01-modified.png') }}" style="width: 50px; height: 50px;margin-right: 10px;
                                  ">
                                </a>

                              </div>
                            </li>
                            <li>  

                              <div class="col-xs-12 bk-logo " style="">
                                <i class="icon icon_logo-word-modified" 
                                class="bk-logo-footer">

                              </i>  <br/>
                              <p>TM &amp; Copyright 2019 Burger King Corporation. All rights reserved.</p>
                            </div>
                          </li>
                          </ul>
                        </div>

                       <!--  <div class="col-sm-4" style="">
                          <ul class="footerLinks">
                            <li >
                              <h4 class="img-small">BK CARES
                                <i class="icon icon_plus-orange pull-right"  id="Div3" onclick="switchVisibleanother()" ></i>
                                <i class="icon icon_plus-orange pull-right"  id="Div4"  onclick="switchVisibleanother()"></i>
                              </h4>
                              <ul class="subList clearfix">
                                <li>PRIVACY</li>

                              </ul>
                            </li>
                          </ul>
                        </div> -->
                      </div>


                      <div class="row content">

                        <div class="toTopHolder" style="margin-top: 20px">
                          <a href="#backTotop" >

                            <img src="{{ asset('WebsiteCSSJS/img/b2t.png') }}" class="" style="width: auto; margin-bottom: 20px;" />

                          </a>

                        </div>
                      </div>


                    </div>
                  </footer>
                </div>
              </div>



              <script type="text/javascript">
               function switchVisible() {
                if (document.getElementById('Div1')) {

                  if (document.getElementById('Div1').style.display == 'none') {
                    document.getElementById('Div1').style.display = 'block';
                    document.getElementById('Div2').style.display = 'none';
                  }
                  else {
                    document.getElementById('Div1').style.display = 'none';
                    document.getElementById('Div2').style.display = 'block';
                  }
                }
              }              

              function switchVisibleanother() {
                if (document.getElementById('Div3')) {

                  if (document.getElementById('Div3').style.display == 'none') {
                    document.getElementById('Div3').style.display = 'block';
                    document.getElementById('Div4').style.display = 'none';
                  }
                  else {
                    document.getElementById('Div3').style.display = 'none';
                    document.getElementById('Div4').style.display = 'block';
                  }
                }
              }              

            </script>

