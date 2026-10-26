<?php
use noicms\paginator\Pagination;

use noicms\paginator\Linkable;
use noicms\paginator\LinkPager;
class Ppaginator{
    public function show($count,$count_on_page,$url="",$prefix="page_admin"){
    if(!isset($count) or !isset($count_on_page) or !isset($url)){

      return "";
    }
    if($url==""){


     $result_url=\Yii::$app->getRequest()->getUrl();



     $pos = strpos($result_url, "?".$prefix);
     $pos2=strpos($result_url, "&".$prefix);
     if($pos===false and $pos2===false){
     $url=$result_url;
     }else {
      $array_get=$_GET;
      $path_info=\Yii::$app->getRequest()->getPathInfo();

      if(count($array_get)>0){
      foreach($array_get as $kv=>$v){

      $vpos = strpos($result_url, "?".$kv."=");
     $vpos2=strpos($result_url, "&".$kv."=");
      if($vpos===false and $vpos2===false){

     unset($array_get[$kv]);
     }
      }
      }

      $count_get=count($_GET);
      if(isset($array_get[$prefix])){
      unset($array_get[$prefix]);
      }
      if($count_get>1){

      }else {
      $array_get=array();
      }
      $tmp_explod=explode("?",$result_url);
      if(isset($tmp_explod[0])){
      $result_url=$tmp_explod[0];
      }
      if(count($array_get)>0){

      $result_url.="?".http_build_query($array_get);

      }
      $url=$result_url;


     }


    }

    $pages = new Pagination(['totalCount' => $count, 'pageSize' => $count_on_page]);
     $pages->pageSizeParam = true;

   $result=LinkPager::widget([
    'pagination' => $pages,
    'registerLinkTags' => true,
     'new_url'=>$url,
     'prefix_url'=>$prefix
]);
   return $result;
    }
    public function getOffset($count_on_page,$prefix="page_admin"){
         if(!isset($count_on_page)){
             return 0;
         }
     $offset=0;
    
     if(isset($_GET[$prefix])){
         
        if($_GET[$prefix]>0){
         $tmp_prefix=(int)$_GET[$prefix]+1;    
         
$_GET['page']=$tmp_prefix;
        }

        

       }
             if(isset($_GET['page'])){
                  $tmp_page=(int)$_GET['page'];
                  if($tmp_page>0){
                  $tmp_page--;
                  $tmp_page=$count_on_page*$tmp_page;
                   $offset=(int)$tmp_page;
                  }


                 }

                 return $offset;
    }
}

