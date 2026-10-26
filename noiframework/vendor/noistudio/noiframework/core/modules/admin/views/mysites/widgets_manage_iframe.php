

<?
if(isset($render)){
 echo $render;
}
?>
<script>

if (typeof jQuery == 'undefined') {
    alert('not jquery loaded');
    var script = document.createElement('script');
    script.type = "text/javascript";
    script.src = "http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js";
    document.getElementsByTagName('head')[0].appendChild(script);

}
var $=jQuery;


</script>
<style>
    .widget_view{
     border: 4px double black; /* Параметры границы */
    }
</style>
	<div class="box-modal" style='display:none;' id="exampleModal4">
					<div class="box-modal_close arcticmodal-close">закрыть</div>
					<div class="modal_data"></div>
				</div>
<script src="/js/arcticmodal/jquery.arcticmodal.js"></script>
<link rel="stylesheet" href="/js/arcticmodal/jquery.arcticmodal.css">
<link rel="stylesheet" href="/js/arcticmodal/themes/simple.css">
<script>
    function dump(obj) {
    var out = "";
    if(obj && typeof(obj) == "object"){
        for (var i in obj) {
            out += i + ": " + obj[i] + "\n";
        }
    } else {
        out = obj;
    }
    alert(out);
}
var current_path="<?php echo $current_path;?>";
var current_position;
var current_number;
var iswidget=1;
var nameplugin="";

$(".setup_plugin").on("click",function(){
 nameplugin=$(this).attr("data-nameplugin");
 iswidget=0;
$.get( "<?php echo   ShoutPlugin::getRoute2();?>widget/mysites_components/plugins/<?php echo $site['_id']->__toString();?>?ui=1&name_plugin="+nameplugin, function( data ) {
$(".modal_data").html(data);

$('#exampleModal4').show();
$('#exampleModal4').arcticmodal({
						openEffect: { speed: 1000 },
						closeEffect: { speed: 1000 },
						closeOnEsc: false,
						closeOnOverlayClick: false,
						beforeOpen: function(data, el) {

						},
						afterOpen: function(data, el) {

						},
						beforeClose: function(data, el) {
 $.get( "<?php echo   ShoutPlugin::getRoute2();?>widget/mysites_components/plugins/<?php echo $site['_id']->__toString();?>?ui=1&preview=1&path="+current_path, function( data ) {

      $("#plugin_"+nameplugin).html(data);
    }
    );
						},
						afterClose: function(data, el) {
$('#exampleModal4').hide();
						}
					});


  });


 return false;

  return false;
})
$(".setup_widget").on("click",function(){
 var position=$(this).attr("data-position");
 var number=$(this).attr("data-number");
$.get( "<?php echo   ShoutPlugin::getRoute2();?>widget/mysites_components/widgets/<?php echo $site['_id']->__toString();?>?manage=4&position="+position+"&number="+number, function( data ) {
$(".modal_data").html(data);
iswidget=1;
current_position=position;
current_number=number;
$('#exampleModal4').show();
$('#exampleModal4').arcticmodal({
						openEffect: { speed: 1000 },
						closeEffect: { speed: 1000 },
						closeOnEsc: false,
						closeOnOverlayClick: false,
						beforeOpen: function(data, el) {

						},
						afterOpen: function(data, el) {

						},
						beforeClose: function(data, el) {
$.get( "<?php echo   ShoutPlugin::getRoute2();?>widget/mysites_components/widgets/<?php echo $site['_id']->__toString();?>?manage=5&position="+current_position+"&number="+current_number, function( data ) {
      $("#widget_"+current_position+"_"+current_number).html(data);
    }
    );
						},
						afterClose: function(data, el) {
$('#exampleModal4').hide();
						}
					});


  });


 return false;
});
$(".op_move").on("click",function(){


 var curkey=$(this).attr("data-curkey");
 var op=$(this).attr("data-op");
  $.get( "<?php echo   ShoutPlugin::getRoute2();?>widget/mysites_components/widgets/<?php echo $site['_id']->__toString();?>?manage=4&position="+current_position+"&number="+current_number+"&cur_key="+curkey+"&op_row="+op, function( data ) {
      $(".modal_data").html(data);
    }
    );
   return false;
});
function movekey(curkey,op){
     $.get( "<?php echo   ShoutPlugin::getRoute2();?>widget/mysites_components/widgets/<?php echo $site['_id']->__toString();?>?manage=4&position="+current_position+"&number="+current_number+"&cur_key="+curkey+"&op_row="+op, function( data ) {
      $(".modal_data").html(data);
    }
    );
    return false;
}
function update_row(main_field,key){
  $.get( "<?php echo   ShoutPlugin::getRoute2();?>widget/mysites_components/widgets/<?php echo $site['_id']->__toString();?>?manage=4&position="+current_position+"&number="+current_number+"&config_field="+main_field+"&update="+key, function( data ) {
      $(".modal_data").html(data);
    }
    );
return false;

}
function update_row_plugin(main_field,key){
 if(iswidget==0){
  $.get( "<?php echo   ShoutPlugin::getRoute2();?>widget/mysites_components/plugins/<?php echo $site['_id']->__toString();?>?ui=1&name_plugin="+nameplugin+"&config_field="+main_field+"&update="+key, function( data ) {
      $(".modal_data").html(data);
    }
    );
return false;

}
}
function delete_row(main_field,key){
 $.get( "<?php echo   ShoutPlugin::getRoute2();?>widget/mysites_components/widgets/<?php echo $site['_id']->__toString();?>?manage=4&position="+current_position+"&number="+current_number+"&config_field="+main_field+"&delete="+key, function( data ) {
      $(".modal_data").html(data);
    }
    );
return false;
}
function delete_row_plugin(main_field,key){
 if(iswidget==0){
  $.get( "<?php echo   ShoutPlugin::getRoute2();?>widget/mysites_components/plugins/<?php echo $site['_id']->__toString();?>?ui=1&name_plugin="+nameplugin+"&config_field="+main_field+"&delete="+key, function( data ) {
      $(".modal_data").html(data);
    }
    );
return false;

}
}
$("#multiform").submit(function(e)
{


});
 function getDoc(frame) {
     var doc = null;

     // IE8 cascading access check
     try {
         if (frame.contentWindow) {
             doc = frame.contentWindow.document;
         }
     } catch(err) {
     }

     if (doc) { // successful getting content
         return doc;
     }

     try { // simply checking may throw in ie8 under ssl or mismatched protocol
         doc = frame.contentDocument ? frame.contentDocument : frame.document;
     } catch(err) {
         // last attempt
         doc = frame.document;
     }
     return doc;
 }
function addrow(){

    var formObj = $("#update_form");
    var formURL = formObj.attr("action");
 
    if(window.FormData !== undefined)  // for HTML5 browsers
    {
       var  form = document.getElementById("update_form");
        var formData = new FormData(form);
        $.ajax({
            url: formURL,
            type: 'POST',
            data:  formData,
            mimeType:"multipart/form-data",
            contentType: false,
            cache: false,
            processData:false,
            success: function(data, textStatus, jqXHR)
            {
             $(".modal_data").html(data);

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
 
            }          
       });
        e.preventDefault();
        e.unbind();
   }
   else  //for olden browsers
    {
        //generate a random id
        var  iframeId = 'unique' + (new Date().getTime());
 
        //create an empty iframe
        var iframe = $('<iframe src="javascript:false;" name="'+iframeId+'" />');
 
        //hide it
        iframe.hide();
 
        //set form target to iframe
        formObj.attr('target',iframeId);
 
        //Add iframe to body
        iframe.appendTo('body');
        iframe.load(function(e)
        {
            var doc = getDoc(iframe[0]);
            var docRoot = doc.body ? doc.body : doc.documentElement;
            var data = docRoot.innerHTML;
            //data is returned from server.
 
        });
 
    }    
}

function click_one(obj){
 $.get( obj, function( data ) {
      $(".modal_data").html(data);
    }
    );
return false;


}

$(document).on('click', '.ajax_w_link', function() {
  var cur_href=$(this).attr("href");
 $.get( cur_href, function( data ) {
  parent.location.reload();

});
 return false;
});
$(document).on('submit', 'form', function(e) {
    var formObj = $(this);
    var classt=$(this).prop("class");


    var formURL = $(this).attr("action")
    var superdata=$(this).serializeArray();
    var result_op=formURL.indexOf("?") > -1;
if(result_op==true){
formURL=formURL+"&type_run=ajax";
}else {
formURL=formURL+"?type_run=ajax";

}

    if(window.FormData !== undefined)  // for HTML5 browsers
    {
       var  form = document.getElementById("update_form");
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: formURL,
            type: 'POST',
            data:  formData,
            mimeType:"multipart/form-data",
            contentType: false,
            cache: false,
            processData:false,
            success: function(data, textStatus, jqXHR)
            {
    if(classt=="no_jajax"){
     parent.location.reload();
    }else {
             $(".modal_data").html(data);
           }

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
 
            }          
       });
        e.preventDefault();
        //e.unbind();
   }
   else  //for olden browsers
    {
        //generate a random id
        var  iframeId = 'unique' + (new Date().getTime());
 
        //create an empty iframe
        var iframe = $('<iframe src="javascript:false;" name="'+iframeId+'" />');
 
        //hide it
        iframe.hide();
 
        //set form target to iframe
        formObj.attr('target',iframeId);
 
        //Add iframe to body
        iframe.appendTo('body');
        iframe.load(function(e)
        {
            var doc = getDoc(iframe[0]);
            var docRoot = doc.body ? doc.body : doc.documentElement;
            var data = docRoot.innerHTML;
            //data is returned from server.
 
        });
 
    }  
    e.preventDefault();
});

</script>
