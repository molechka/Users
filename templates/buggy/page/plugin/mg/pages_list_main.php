<?
if(count($all)){
 $max=count($all);
 
foreach($all as $key=>$d){
 $next=$key+1;  
 
 if(!isset($all[$next])){
 
  echo NoiCore::p("BugsFCP")->renderForm();
 }
?>
<div class="row">
 <?=$d['content'];?>   
</div>
 <?
}    
}
?>


