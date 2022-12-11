@extends('Website.layouts.manage')
@section('extra_css')
<style>

  @media only screen and (max-width: 768px) {

    .row-sm-details{
      padding-left: 15px;
      padding-right: 15px;
      text-align: justify;
      padding-top: 0px !important;
    }
    .next1{
      display: none;
    }
    .content-modified{margin-top: 0px !important;

    }
  }

  @media only screen and (min-width: 768px) {
    .img-cover{
      background-size: cover;
      width:100% ;
    }
  }


  /* On smaller screens, decrease text size */
  @media only screen and (max-width: 300px) {
    .text {font-size: 11px}
  }
</style>

<style type="text/css">
  .content-modified{
    margin-top: 135px;
    font-family: 'BlockBeCnPro', Arial, Helvetica, sans-serif;
    
  }

  @media only screen and (max-width: 1280px) {
   .content-modified{margin-top: 55px;

   }
 }
</style>
<style type="text/css">
  .order__details{background: #FFEBD7; margin-top: 100px !important}


  /*body{font-family: 'BlockBeCnPro', Arial, Helvetica, sans-serif;}*/
  .menu__title{font-size: 35px; padding-top: 40px;padding-bottom: 0px;color: #323231}
  .register{color: #323231;font-size: 32px !important;}
  .search {
    width: 100%;
    position: relative;
    display: flex;
    padding-top: 45px;
    padding-bottom: 45px;
  }




  .menu__name{
    padding-top: 40px; font-size: 30px; padding-left: 10px
  }

  .menu__price{
    text-align: right;
    font-size: 25px;
    padding-top: 20px;
  }

  .menu__btn{
    background-color: #ed7800 !important; color:white !important;
  }

  .order__bag{
    margin-top: -50px;
    margin-bottom: 20px;
  }

  .order__details__title, .order__details__price{
   color: #fff;
   padding-top: 35px;
   font-size: 30px;
   font-family: 'BlockBeCnPro', Arial, Helvetica, sans-serif;
 }

 .row-container{
  background: #FFEBD7;
}
.order__details__img{
  margin-top: 40px; 
  margin-bottom: 20px;
}

.menu__details{

  font-size: 23px;

}

.right__margin{
  padding-right: 30px;
}

.content__body{
  background: #FCF1EB !important;
}
</style>

@endsection
@section('content')
<div id="fooddetails">
<section class="container-fluid">
 <div class="row content">
  <h1 class="sectionTitle menuTitle" style="margin-top: 30px;margin-bottom: 50px;">
    <img src="{{ asset('WebsiteCSSJS/img/menu.png') }}" class="img-responsive center-block" />
  </h1>
</div>
<div class="row content" id="generalCategory">
  @if(!empty($gnrl_categories))
  @foreach($gnrl_categories as $gnrl_category)
  <div class="col-xs-6 col-sm-4 food-category chicken">
    <a class="inner">
      <div class="imgWrap">
        <img data-g_categoryid="{{ $gnrl_category['id'] }}" src="{{ asset('upload/menu/thumbnail_images/'. $gnrl_category['picture']) }}" class="gnrl-cat-img" />
      </div>
      <div class="title">
        <span style="color:{{ $gnrl_category['namecolor'] }};text-transform: uppercase;"> {{ $gnrl_category['name'] }}  </span>
      </div>
    </a>
  </div>
  @endforeach
  @endif
</div>
</section> 
</div> 
@endsection
@section('extra_js')
<script src="{{ asset('sweetalert.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#generalCategory').on('click','.gnrl-cat-img',function(){
            // $.ajaxSetup({
            //     headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
            // });
            var button = $(this);
            var g_categoryid = button.attr("data-g_categoryid");
            var url = '{{ url('general-foodd') }}';
            $.ajax({
              url: url,
              method:'get',
              data:{g_categoryid : g_categoryid},
              dataType : "json",
              success:function(data){
                console.log(data);
                if(data == 'nodata')
                {
                  swal({
                    title: "Food Not Found !",
                    icon: "info",
                    button: "Cancel !",
                    className: "myClass",
                  })
                }
                else
                {
                  $('#generalCategory').html(data['HTML']);
                }
              },
              error:function(error){
                console.log(error);

                swal({
                  title: "Something went wrong !",
                  icon: "error",
                  button: "Cancel !",
                  className: "myClass",
                });
              }
            })
          })
  })
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#generalCategory').on('click','.food-img',function(){
            // $.ajaxSetup({
            //     headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
            // });
            var button = $(this);
            var foodid = button.attr("data-foodid");
            var url = '{{ url('fooddetails') }}';
            $.ajax({
              url: url,
              method:'GET',
              data:{foodid : foodid},
              dataType : "json",
              success:function(data){
                console.log(data);
                if(data == 'nodata')
                {
                  swal({
                    title: "Details Not Found !",
                    icon: "info",
                    button: "Cancel !",
                    className: "myClass",
                  })
                }
                else
                {
                  $('#fooddetails').html(data);
                }
              },
              error:function(error){
                console.log(error);

                swal({
                  title: "Something went wrong !",
                  icon: "error",
                  button: "Cancel !",
                  className: "myClass",
                });
              }
            })
          })
  })
</script>
@endsection