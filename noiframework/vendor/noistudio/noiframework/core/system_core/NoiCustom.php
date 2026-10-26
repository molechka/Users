<?php
/*
 *  
 * @package NoiCore
 *
 *
 */
namespace noicms\core;
use noicms\mongogrid\system_core\MGQuery;
use noicms\minify;
use NoiCore;
use Yii;


class NoiCustom{
     /**
     *
     * @var array of site_data
     */
     public $site_data=false;
       /**
      * @var string id site in string mongoId
      *
      */
     public $site_id=false;
     function str_lreplace($search, $replace, $subject)
{
    $pos = strrpos($subject, $search);

    if($pos !== false)
    {
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }

    return $subject;
}
      public function __construct($site_data) {
     if(isset($site_data) and is_array($site_data) and isset($site_data['_id'])){
     $this->site_id=$site_data['_id']->__toString();
     $this->site_data=$site_data;
     }
     }
     public function getUrl(){
    $url="/";
    if(isset($_SERVER['REQUEST_URI'])){
     $url=$_SERVER['REQUEST_URI'];
     }
     return $url;
     }
     /**
      * NoiCore::custom()->getAllStats
      * @param  string ("views" or "hosts") $field
      * @return return (int)
      *
      */

     public function getAllStats($field="views"){
  
        $db=MGQuery::getCollection('stats_plugin');
 $result = $db->aggregate(array(array('$group'=>array(
    '_id'=>null,
   'total'=>array( '$sum'=> array( '$multiply'=> array('$'.$field) ) ),
   'count'=> array( '$sum'=> 1 )
 )))


);

 if(isset($result[0]['total'])){
  return $result[0]['total'];
 }else {
     return 0;
 }
     
     }
    /**
     * NoiCore::app()->doReplace($string);
     * @param string $string
     * this method is replace {THEME_PATH} to /templates/name_theme/
     * @return   string
     *
     */
     public function doReplace($string){

   $replace_str="";
 $this->site_data=NoiCore::app()->get();
  if(strlen($this->site_data['type_site'])>0){
   $replace_str=THEMES_PATH."".$this->site_data['type_site']."/".$this->site_data['theme_site']."/";
  }else {
 $replace_str=THEMES_PATH."".$this->site_data['theme_site']."/";
  }
  $string=  str_replace("{THEME_PATH}", $replace_str, $string);
 
 if(!NoiCore::app()->isAdmin()){
   if(file_exists(DOCUMENT_ROOT."/conf/compress.php")){
  require(DOCUMENT_ROOT."/conf/compress.php");
   if(isset($config['minify_css']) and $config['minify_css']==true){
   $string=NoiCore::custom()->minifyCss($string);
  }
 if(isset($config['minify_js']) and $config['minify_js']==true){
$array_tmp=array();
if(isset($config['js_exceptions']) and is_array($config['js_exceptions'])){
$array_tmp=$config['js_exceptions'];
}
 
   $string=NoiCore::custom()->minifyJs($string,$array_tmp);
  }else if(isset($config['lazy_img']) and $config['lazy_img']==true){
  $string=NoiCore::custom()->addLazy($string);
  }
 

   

 }
 }
  return $string;
     }
     function replacePost($text){
       $output = preg_replace('/(^|\s)#(\w*[0-9]+\w*)/', '\1<a href="/proj/view/\2/all.html">#\2</a>',$text);  
       return $text;
       }
     function addLazy($string){
     $string.=' <script src="/tmp/lazy.js"></script>
    <script>
        ;(function() {
            // Initialize
           var bLazy = new Blazy({
        selector: "img" // all images
    });
        })();
    </script>' ;
return $string;
     }
function memory_usage($decimals = 2)
{
$mem=memory_get_peak_usage(true);
 $mb=round($mem / 1024 / 10124, 2);
 return $mb;
}
function minifyJs($string,$exception=array()){
 $site=NoiCore::app()->get();
 $url=$this->getUrl();
 $array_of_not=$exception;
 if(!file_exists(DOCUMENT_ROOT.'/tmp/files/minify_'.$site['_id']->__toString().'_'.$url.'.js')){
 //if(true){
 $str = $string;

preg_match_all('/(?<=src=")[^"]+(?=")/', $str, $srcs, PREG_PATTERN_ORDER);
$js_array=array();
 
if(isset($srcs[0])  and is_array($srcs[0]) and count($srcs[0])>0){

    foreach($srcs[0] as $js){
 $tmp=str_replace(".js","",$js);
 $tmp2=str_replace($array_of_not,"",$tmp);
       if($tmp!=$js){
        if($tmp2==$tmp){
        $js_array[]=$js;
        }
        }
    }
    if(count($js_array)>0){
    $minifier = new minify\JS();
     foreach($js_array as $key=>$js){
     
   $tmp2=str_replace($array_of_not,"",$js);
 if($tmp2==$js){
if(DOCUMENT_ROOT.$js!=DOCUMENT_ROOT){
if(file_exists(DOCUMENT_ROOT.$js)){
$minifier->add(DOCUMENT_ROOT.$js);
}
}
 }
}

 


$url=str_replace("/","_",$url);
$minifiedPath = DOCUMENT_ROOT.'/tmp/files/minify_'.$site['_id']->__toString().'_'.$url.'.js';
$minifier->minify($minifiedPath);
$current_js='/tmp/files/minify_'.$site['_id']->__toString().'_'.$url.'.js';;

     }
    }
}else {
 $current_js='/tmp/files/minify_'.$site['_id']->__toString().'_'.$url.'.js';;
}
 $html_text = $string;

$d = new DOMDocument();
@$d->loadHTML($html_text);
$xpath = new DOMXPath($d);
$result = $xpath->query("//script");

foreach ($result as $link)
{
    $href = $link->getattribute("src");
$tmp=str_replace(".js","",$href);
$tmp2=str_replace($array_of_not,"",$tmp);
     if($tmp!=$href and $link->hasAttribute("src") and $tmp==$tmp2 )
    {

   

         $link->parentNode->removeChild($link);
    }

}


$output= $d->saveHTML();
$pos = strpos($output, "<script");
 
if($pos===false){
 $output=str_replace("</body>",'</body><script src="'.$current_js.'"></script>',$output);
}else {
  $output=$this->str_lreplace("<script",'<script src="'.$current_js.'"></script><script',$output);
}

return $output;
}


function minifyCss($string){
 
 $site=NoiCore::app()->get();
 $url=$this->getUrl();
 if(!file_exists(DOCUMENT_ROOT.'/tmp/files/minify_'.$site['_id']->__toString().'_'.$url.'.css')){
 //if(true){

   $array_css=array();
   $array_js=array();
     preg_match_all('/(<link\b.+href=")(?!http)([^"]*)(".*>)/', $string, $matches) ;
    if(isset($matches[2])){
        foreach ($matches[2] as $row){
        $tmp=str_replace(".css","",$row);
        
        if($tmp!=$row){
        $array_css[]=$row;
        }
        }
    }
 $minifier = new minify\CSS();
 
 if(count($array_css)>0){
foreach($array_css as $key=>$css){
$minifier->add(DOCUMENT_ROOT.$css);
}




$url=str_replace("/","_",$url);
$minifiedPath = DOCUMENT_ROOT.'/tmp/files/minify_'.$site['_id']->__toString().'_'.$url.'.css';
$minifier->minify($minifiedPath);
$current_css='/tmp/files/minify_'.$site['_id']->__toString().'_'.$url.'.css';;
 }
 }else {
 $current_css='/tmp/files/minify_'.$site['_id']->__toString().'_'.$url.'.css';
 }
 $html_text = $string;

$d = new DOMDocument();
@$d->loadHTML($html_text);
$xpath = new DOMXPath($d);
$result = $xpath->query("//link");

foreach ($result as $link)
{
    $href = $link->getattribute("href");
$tmp=str_replace(".css","",$href);
 
     if($tmp!=$href)
    {
        
         $link->parentNode->removeChild($link);
    }

}

 
$output= $d->saveHTML();
$output=str_replace("</title>",'</title><link href="'.$current_css.'" rel="stylesheet">',$output);
return $output;
} 
}

