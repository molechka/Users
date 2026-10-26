<?php
//основной класс для построения взаимодействия.

namespace noicms\mongogrid;

$system_core=scandir(PATH_TO_ENGINE."/vendor/noistudio/noiframework/mongogrid/system_core");
if (count($system_core)>0) {
    foreach ($system_core as $score) {
        if ($score!="." and $score!="..") {
            require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/mongogrid/system_core/".$score;
        }
    }
}
$core=scandir(PATH_TO_ENGINE."/vendor/noistudio/noiframework/mongogrid/core");

if (count($core)>0) {
    foreach ($core as $cc) {
        if ($cc!="." and $cc!="..") {
            require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/mongogrid/core/".$cc;
        }
    }
}

$load_fields=scandir(PATH_TO_ENGINE."/vendor/noistudio/noiframework/mongogrid/plugins/type/fields");
if (count($load_fields)>0) {
    foreach ($load_fields as $lf) {
        if ($lf!="." and $lf!=".." and !is_dir(PATH_TO_ENGINE."/vendor/noistudio/noiframework/mongogrid/plugins/type/fields/".$lf)) {
            require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/mongogrid/plugins/type/fields/".$lf;
        }
    }
}


use noicms\mongogrid\system_core\GridBackground;

use noicms\mongogrid\system_core\GridField;

use noicms\mongogrid\system_core\GridImage;
use noicms\mongogrid\system_core\GridOperation;
use noicms\mongogrid\system_core\GridStatic;
use noicms\mongogrid\system_core\GridStr;
use noicms\mongogrid\system_core\GridView;
use noicms\mongogrid\system_core\GridStatus;
use noicms\mongogrid\system_core\MGQuery;
use noicms\mongogrid\system_core\MongoQuery;

class MongoGrid
{
    public $fields=null;
    public $view=null;
    public $status=null;
    public $xss=null;
    public $operations=null;
    public $name_short;
    public $get_name_short="path_grid_";
    public $collection;
    public $page_item;
    public $offset;
    public $condition=array();
    public $url="";
    public $title;
    public $result;
    public $sort=array('_id'=>-1);
    public $tmp_data=array();

    public function __construct($collection, $page_item=25, $offset=0, $name_short="default", $title="", $url="")
    {
        $this->collection=$collection;
        $this->page_item=$page_item;
        $this->offset=$offset;
        $this->name_short=$name_short;
        $this->view=new GridView();
        $this->title=$title;
        $this->view->mg=&$this;
        $this->status=new GridStatus();
        $this->status->mg=&$this;

//    $this->xss->options = array('URI.AllowedSchemes'=>array(
//  'http' => true,
//  'https' => true,
//),array('HTML.Allowed'=>"code,span,div,label,a,br,p,b,i,del,strike,u,img,video,audio,object,embed,param,blockquote,mark,cite,small,ul,ol,li,hr,dl,dt,dd,sup,sub,big,pre,code,figure,fig,caption,strong,em,h1,h2,h3,h4,h5,h6"),array('HTML.Nofollow'=>true));



   $this->url=$url;
    }
    public function setFields($fields)
    {
        $this->fields=$fields;

        $this->fields->mg=&$this;
    }
    public function setOperations($operations)
    {
        $this->operations=$operations;
        $this->operations->mg=&$this;
    }
    private function parseRoute($route)
    {
        if (isset($route)) {
            $this->view->route=$route;
            $this->view->tmp_var=explode("/", $this->view->route);
            if (isset($this->view->tmp_var[1])) {
                if (in_array($this->view->tmp_var[1], $this->operations->available)) {
                    $this->operations->default_operation=$this->view->tmp_var[1];
                }
            }
            if (isset($this->view->tmp_var[2])) {
                $this->operations->default_value=$this->view->tmp_var[2];
            }
        }
    }
    public function render()
    {
        $route="/";
        if (isset($_GET['page_mg'])) {
            if ($_GET['page_mg']>0) {
                //$_GET['page_mg']=(int)$_GET['page_mg']+1;
            }

            $_GET['page']=$_GET['page_mg'];
        }
        if (isset($_GET['page'])) {
            $tmp_page=(int)$_GET['page'];
            if ($tmp_page>0) {
                $tmp_page--;
                $tmp_page=$this->page_item*$tmp_page;
                $this->offset=(int)$tmp_page;
            }
            if ((int)$_GET['page']==1) {
                $this->offset=$this->page_item*(int)$_GET['page'];
            }
        }
         
        if (isset($_POST['search_field']) and isset($_POST['search_value'])) {
            if (!isset($this->condition[$_POST['search_field']])) {
                $this->condition[htmlspecialchars($_POST['search_field'])]=array('$options'=>'i','$regex' => $_POST['search_value']);
            }
        }

        if (isset($_GET[$this->get_name_short.''.$this->name_short])) {
            $this->parseRoute($_GET[$this->get_name_short.''.$this->name_short]);
        }





        if ($route=="/") {
            $this->view->tmp_var=array(0=>0,1=>$this->operations->default_operation,2=>$this->operations->default_value);
        }
        if (strlen($this->url)==0) {
            $prefix="page_mg";
            $result_url=\Yii::$app->getRequest()->getUrl();



            $pos = strpos($result_url, "?".$prefix);
            $pos2=strpos($result_url, "&".$prefix);
            if ($pos===false and $pos2===false) {
                $url=$result_url;
            } else {
                $array_get=$_GET;
                $path_info=\Yii::$app->getRequest()->getPathInfo();

                if (count($array_get)>0) {
                    foreach ($array_get as $kv=>$v) {
                        $vpos = strpos($result_url, "?".$kv."=");
                        $vpos2=strpos($result_url, "&".$kv."=");
                        if ($vpos===false and $vpos2===false) {
                            unset($array_get[$kv]);
                        }
                    }
                }

                $count_get=count($_GET);
                if (isset($array_get[$prefix])) {
                    unset($array_get[$prefix]);
                }
                if ($count_get>1) {
                } else {
                    $array_get=array();
                }
                $tmp_explod=explode("?", $result_url);
                if (isset($tmp_explod[0])) {
                    $result_url=$tmp_explod[0];
                }
                if (count($array_get)>0) {
                    $result_url.="?".http_build_query($array_get);
                }
                $url=$result_url;
            }
            $this->url=$url;
        }


        $this->result=$this->operations->executeEvent($this->operations->default_operation);

        if ($this->view->rerender==true) {
            $this->parseRoute($this->view->route);
//         unset($_POST);
//       echo $this->operations->default_operation;
//       exit;
         $this->result=$this->operations->executeEvent($this->operations->default_operation);
        }
        $this->fields->renderInput();

        $this->view->tmp_url=$this->url;

        return   $this->view->render();
    }
    public function setRoute($route)
    {
        return  $this->view->setRoute($route);
    }
}
