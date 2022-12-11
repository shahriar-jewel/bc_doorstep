// function checkWidth(){
// 	if(window.innerWidth > 800) {
// 	$(window).scroll(function(e){
// 	  var $el = $('.letMenuInner'); 
// 	  var isPositionFixed = ($el.css('position') == 'fixed');
// 	  if ($(this).scrollTop() > 200 && !isPositionFixed){ 
// 		$('.letMenuInner').css({'position': 'fixed', 'top': '0px'}); 
// 	  }
// 	  if ($(this).scrollTop() < 200 && isPositionFixed)
// 	  {
// 		$('.letMenuInner').css({'position': 'static', 'top': '0px'}); 
// 	  }
// 	});
// 	}

// 	if(window.innerWidth > 800) {
// 	$(window).scroll(function(e){
// 	  var $el = $('.cartInnerArea'); 
// 	  var isPositionFixed = ($el.css('position') == 'fixed');
// 	  if ($(this).scrollTop() > 200 && !isPositionFixed){ 
// 		$('.cartInnerArea').css({'position': 'fixed', 'top': '0px'}); 
// 	  }
// 	  if ($(this).scrollTop() < 200 && isPositionFixed)
// 	  {
// 		$('.cartInnerArea').css({'position': 'static', 'top': '0px'}); 
// 	  }
// 	});
// 	}
// }



// function updateCart(id,  add = "add"){
// 	var x = $("input[name='drink']:checked").val();
// 	var opt =0;
// 	if(x === 'undifined'){
// 		opt = 0;
// 	}
// 	else {
// 		opt = x; 
// 	}
// 	add = add;
// 		$.ajax({
// 			url:"basket2.php",  
// 			type:"GET",
// 			data:"add="+"add"+"&id="+id+"&opt="+opt,
// 			success:function(content) {
// 			 $("#cartDetail").html(content);
			 
// 		}
// 	});
// }

// function loadData(){
// 	$("#cartDetail").html('<option>Loading...</option>');
// 	var add = "update";
// 	$.ajax({
// 			url:"basket2.php",  
// 			data:"add="+add,
// 			type:"GET",
// 			success:function(content) {
// 			   $("#cartDetail").html(content);
// 			}
// 		});
// } 


// function loginCheck(){
// 	$("#loginMessag").html('<option>Loading...</option>');
// 	var username = $('#emailaddress').val();
// 	var pass = $('#password').val();
	
// 	$.ajax({
// 			url:"login.php",  
// 			data:"username="+username+"&pass="+pass,
// 			type:"POST",
// 			success:function(content) {
// 			    $("#loginMessag").html(content);
			 
// 			   $("#noLogin").hide();
			   
// 			}
// 		});
// } 




// window.onload = function() {
// 	loadData(0);
// }

// function removeItem(id){
// 	$.ajax({
// 			url:"removeItem.php",  
// 			data:"id="+id,
// 			type:"GET",
// 			success:function(content) {
// 		loadData(0);		

// 			}
// 		});	
// 	}





// function updateCartDeal(id){

// var r = document.getElementById("#DealForm"+id).submit();

// oSelectOne = oForm.elements["select_one_element_name"];

// 		$.ajax({
// 			url:"basket2.php",  
// 			type:"GET",
// 			data:"id="+id,

// 			success:function(content) {
// 			 $("#cartDetail").html(content);
			 
// 		}
// 	});
// }







