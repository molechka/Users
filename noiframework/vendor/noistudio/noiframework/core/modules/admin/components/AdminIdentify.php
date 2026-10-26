<?php
namespace noicms\admin\components;
/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class AdminIdentify extends \yii\base\Object implements \yii\web\IdentityInterface
{
	private $_id;
        public $id_house;
        public $result;
        public $username;
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */

        public function authenticate(){
        if(isset($this->result['_id']) and isset($this->result['username'])){
         $this->username=  $this->result['username'];


         $this->_id=  $this->result['_id'];


      $this->authenticate();
      //   $this->setState("loogedInUser",$this->result);
         return self::ERROR_NONE;
        }else {
            return self::ERROR_UNKNOWN_IDENTITY;
        }
        }


	/**
	 * @return integer the ID of the user record
	 */
	public function getId()
	{
		return $this->_id;
	}

    public function getAuthKey() {
        
    }

    public function validateAuthKey($authKey) {

    }

    public static function findIdentity($id) {
        
    }

    public static function findIdentityByAccessToken($token, $type = null) {

    }

}
