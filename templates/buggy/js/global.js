$(".formsend").submit(function(){
 var iframe;
var $form=$(this);
 

$form.attr("action",$form.data("action"));
    if (!$form.attr('target'))
    {
        //create a unique iframe for the form
        iframe = $("<iframe></iframe>").attr('name', 'ajax_form_' + Math.floor(Math.random() * 999999)).hide().appendTo($('body'));
       $form.attr('target', iframe.attr('name'));
 
    }
  

   
        iframe = iframe || $('iframe[name=" ' + $form.attr('target') + ' "]');
        iframe.on("load",function ()
        {
            //get the server response
            var response = iframe.contents().find('body').text();
            var obj=JSON.parse(response);
                    
                    if(obj.type=="success"){
                     if(obj.link){
                      document.location.href=obj.link;   
                     } 
                      $form.trigger( 'reset' );
                    }else {
                    $('.bottom-right').notify({

                    timer: 30000000,
                    delay: 8000000000000,
                    z_index: 9999999,
                    message: {text: obj.message},
                    type: 'success',
                    newest_on_top: true
                }).show()
    
                    }
                    
        });
        
       
});

$(".clear_field").on("click",function(){
   
    var target=$(this).data("target");
    $(target).val(' '); // Select the option with a value of '1'
$(target).trigger('change');
    return false;
});