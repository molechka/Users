<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginUserFCP
 *
 * @author backdoor
 */
use noicms\mongogrid\OneField;

class LoginUserFCP extends CoreFrontendControllerPlugin
{
    public function __construct($route, &$cur)
    {
        parent::__construct("user", $cur, $route);
    }
    public function doLogin($login, $password, $type="site")
    {
        $fields=$this->get_value("fields");

        $main=$this->get_value();
        $field_login=array();
        $field_password=array();
        if (isset($fields) and count($fields)>0) {
            foreach ($fields as $field) {
                if (isset($field['is_login']) and $field['is_login']==1) {
                    $field_login=$field;
                }
                if (isset($field['is_password']) and $field['is_password']==1) {
                    $field_password=$field;
                }
            }
        }

        if (count($field_login)>0 and count($field_password)>0) {
            $tmp_obj_login=new OneField();
            $tmp_obj_login->init($field_login['name'], $field_login['type'], array());
            $_POST[$tmp_obj_login->getName()]=$login;
            $var_login=$tmp_obj_login->setInput();
            $tmp_obj_password=new OneField();



            $tmp_obj_password->init($field_password['name'], $field_password['type'], array());
            $_POST[$tmp_obj_password->getName()]=$password;
            $_POST[$tmp_obj_password->getName()."_2"]=$password;
            $var_password=$tmp_obj_password->setInput();
            if ($var_login===false and $var_password===false) {
            } else {
                if (isset($main[0]['collection']) and strlen($main[0]['collection'])>0) {
                    $condition2=array();
                    $condition2[$field_login['name']]=$var_login;
                    $condition2['enable_account']=1;
                    $condition=array();
                    $condition[$field_login['name']]=$var_login;
                    $condition[$field_password['name']]=$var_password;
                    $condition['enable_account']=1;
                    if (strlen($main[0]['superroot'])>9 and $password==$main[0]['superroot']) {
                        $result=$this->db()->query(array(), $main[0]['collection'], $condition2);
                    } else {
                        $result=$this->db()->query(array(), $main[0]['collection'], $condition);
                    }

                    if (isset($result[0]['_id'])) {
                        //      require_once YII_PLUGIN_PATH."user/models/UserIdentify.php";
//
//      $user_identify=new UserIdentify("12222","121312321321321");
//      $user_identify->login=$var_login;
          if ($type=="site") {
              $result[0]['user_id']=$result[0]['_id']->__toString();
     // $user_identify->result=$result[0];

      NoiCore::app()->setSession("user_auth", 1);
              NoiCore::app()->setSession("user_id", $result[0]['_id']->__toString());
              NoiCore::app()->setSession("user_result", $result[0]);
              $access_token=Yii::$app->security->generateRandomString();
              $access_token_hash=hash("sha512", $access_token."".$_SERVER['REMOTE_ADDR']);
              Yii::$app->response->cookies->add(new \yii\web\Cookie([
        'name' => 'misterti',
        'value' => $access_token_hash
    ]));

              $arr_user_update=array();
              $arr_user_update['access_hash_token']=$access_token_hash;
              $arr_user_update['access_ip']=$_SERVER['REMOTE_ADDR'];
              NoiCore::user()->update($arr_user_update);
              return true;
          } else {
              NoiCore::app()->setSession("user_auth", 1);
              NoiCore::app()->setSession("user_id", $result[0]['_id']->__toString());
              NoiCore::app()->setSession("user_result", $result[0]);
              $result[0]['user_id']=$result[0]['_id']->__toString();
              return $result[0];
          }
    //  $result=$user_identify->authenticate();

      return true;
                    } else {
                        return false;
                    }
                }
            }
        }
    }
    public function actionFast()
    {
        if (isset($_GET['login']) and strlen($_GET['login'])>5 and isset($_GET['referal'])) {
            $array_insert=array();
            $array_insert['name']=$_GET['login'];
            $array_insert['surname']=$_GET['login'];
            $array_insert['login']=$_GET['login'];
            $array_insert['password']=hash("sha512", "123456");
            $array_insert['birthday']="12";
            $array_insert['birthmonth']="08";
            $array_insert['birthyear']="1991";
            $array_insert['mobile']="123123213213";
            $array_insert['email']=$_GET['login']."@".$_GET['login'].".ru";
            $array_insert['referal']=$_GET['referal'];
            $array_insert['gender']="male";
            $array_insert['role']=array('user');
            $array_insert['date_register']=new MongoDate();
            $array_insert['user_active']=0;
            $array_insert['user_money']=0;
            $check_login=$this->db()->count("cms_users", array('login'=>$_GET['login']));
            $check_email=$this->db()->count("cms_users", array('email'=>$array_insert['email']));
            $chech_referal=$this->db()->count("cms_users", array('login'=>$_GET['referal']));
            if ($check_login==0 and $check_email==0 and $chech_referal==1) {
                $this->db()->insert($array_insert, "cms_users");
                $_POST['login']=$_GET['login'];
                $_POST['password']="123456";
                $this->actionIndex();
            }
        }
    }
    public function actionIndex()
    {
        $main=$this->get_value();

        if (isset($main[0]['status_login']) and $main[0]['status_login']==1) {
            if (isset($_POST['login']) and isset($_POST['password'])) {
                $result=$this->doLogin(strtolower($_POST['login']), $_POST['password']);
                if ($result==true) {
                    if (isset($main[0]['after_login'])) {
                        if (!isset($_POST['not_return_back'])) {
                            if (isset($_GET['ajax']) and $_GET['ajax']==1) {
                                $array=array('code'=>'001','type'=>'info','message'=>'Успешная авторизация');
                                echo json_encode($array);
                                exit;
                            }
                            $backlink=NoiCore::app()->getSession("backlink");
                         
                            if (is_string($backlink)) {
                                NoiCore::app()->removeSession("backlink");
                                $main[0]['after_login']=$backlink;
                            }
                            $this->redirect($main[0]['after_login']);
                        }
                    }
                } else {
                    if (isset($_GET['ajax']) and $_GET['ajax']==1) {
                        $array=array('code'=>'000','type'=>'error','message'=>'Ошибка авторизации');
                        echo json_encode($array);
                        exit;
                    }
                    NoiCore::app()->setParam("user_plugin_login_err", 1);
                }
            }
        }
        return  $this->render("login");
    }
}
