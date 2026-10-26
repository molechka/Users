$(function() {
   $(".checkform").on("click",function(){
     $(".formresponse").hide();   
    var name=$(".form_name").val();
    var dr=$(".form_dr").val();
    $.post( "/bugs/ajax/request", { name: name,date: dr })
  .done(function( data ) {
   var obj=JSON.parse(data);
   if(obj.type=="error"){
   $(".formresponse").html('<div class="alert alert-danger"><p>'+obj.message+'</p></div>');    
   }else {
     $(".formresponse").html('<div class="alert alert-success"><p>'+obj.message+'</p></div>');    
     
   }
   $(".formresponse").show();
  });
   }); 
});