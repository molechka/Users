<?php

class NoiCoreSet{
    /**
     * How to use
     *
     *
     * NoiCoreSet::add($site_data);
     *
     * @param array $site_data is array of site data
     * @return void
     *
     */
    public static function add($site_data){

   \Yii::$app->params['noi_site_data']=$site_data;
   require DOCUMENT_ROOT."/conf/config.php";
   if(isset($config['default_lang'])){
   NoiCore::lang()->setDefault($config['default_lang']);   
   }
   NoiCore::app()->setLang();

    }
    /**
     *
     * How to use
     *
     * NoiCoreSet::isExists();
     * @return  bool if site loaded return true ; if site not loaded return false;
     *
     *
     */
    public static function isExists(){
   if(isset(\Yii::$app->params['noi_site_data'])){
     return true;
   }else {
       return false;
   }
    }
}
