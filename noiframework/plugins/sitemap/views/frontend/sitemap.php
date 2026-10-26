
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?
if(count($collections)>0){
foreach($collections as $coll){
if(isset($coll['list'])){
?>
<url>

      <loc>http://<?php echo $_SERVER['HTTP_HOST'];?>/mg/<?php echo $coll['last_id'];?>.html</loc>

      <lastmod><?php echo date('Y-m-d');?></lastmod>

      <changefreq>monthly</changefreq>

      <priority>0.8</priority>

   </url>    
<?    
}
if($coll['one'] and $coll['one']==1){
 if(isset($results[$coll['name']]) and is_array($results[$coll['name']]) and count($results[$coll['name']])>0){
 foreach($results[$coll['name']] as $one){
 

 ?>
<url>

      <loc>http://<?php echo $_SERVER['HTTP_HOST'];?>/mg/<?php echo $coll['last_id'];?>/<?=$one['last_id'];?>.html</loc>

      <lastmod><?php echo date('Y-m-d');?></lastmod>

      <changefreq>monthly</changefreq>

      <priority>0.8</priority>

   </url>       
 <?   
 }    
 }   
}
}    
}
?>
<?
if(count($forms)>0){
foreach($forms as $form){    
?>
<url>

      <loc>http://<?php echo $_SERVER['HTTP_HOST'];?>/form/<?php echo $form['_id']->__toString();?>.html</loc>

      <lastmod><?php echo date('Y-m-d');?></lastmod>

      <changefreq>monthly</changefreq>

      <priority>0.8</priority>

   </url>     
<?    
}
}
?>
 
 

</urlset> 

