@extends('Frontend.layouts.manage')
@section('content')

<div id="mainFoodSection" class="FoodDetails">
    <div class="container-fluid menuBox">
        <div id="nameWrapper">
            <div class="menuButtonHolder"> 
                <h1> MENU </h1> <br> <br>
            </div>
        </div>
        <div class="row menu-container" id="FoodCategory">
            @if(!empty($categories))
            @foreach($categories as $category)

            <div class="col-xs-12 col-sm-6 col-md-3 flamegrilled right-side-border-1">
                <div class="for-right-border flamegrilled right-side-border-1">
                    <a href="#" class="mainCatName {{ $category->CategoryNameColor }}"style="border:none;">
                        <div class="img-responsive" style="display:block;">
                            <div class="proImg">
                                <img data-categoryid="{{ $category->CategoryID }}" src="{{ asset('public/imageFolder/'.$category->Picture) }}" class="img-responsive cat-img zoom" style="width: 200px;height: 170px;">     
                            </div>
                            <div class="proName">
                                <h1 style="text-align:center; border:none" class="cat-name"> {{ strtoupper($category->CategoryName) }} </h1>
                            </div>
                        </div>
                    </a>
                </div>
            </div>          

            @endforeach
            @endif
            <div class="left-img" style="margin-top:60px"> <img src="public/FrontendCSSJS/img/img-for-other-pltfrm/burger-right-side-menu.png" class="img img-responsive"> </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $('#FoodCategory').on('click','.cat-img',function(){
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
            });
            var button = $(this);
            var categoryid = button.attr("data-categoryid");
            var url = '{{ url('categorywiseFood') }}';
            $.ajax({
                url: url,
                method:'POST',
                data:{categoryid : categoryid},
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
                        $('#mainFoodSection').html(data['HTML']);
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
        $('.FoodDetails').on('click','.food-img',function(){
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
            });
            var button = $(this);
            var foodid = button.attr("data-foodid");
            var url = '{{ url('fooddetails') }}';
            $.ajax({
                url: url,
                method:'POST',
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
                        $('.FoodDetails').html(data);
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