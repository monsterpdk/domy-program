<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{

    private $_id;
	
	public function authenticate()
	{
		$user = User::model() -> findByAttributes( array('username'=>$this->username) );
		
		if ($user===null) {
			// nem találtunk ilyen user-t
			$this -> errorCode=self::ERROR_USERNAME_INVALID;
			
		} else if ($user->password !== SHA1($this->password) ) {
			$this -> errorCode=self::ERROR_PASSWORD_INVALID;
			
		} else {
			// megtaláltuk a user-t
			$this -> errorCode = self::ERROR_NONE;
			$this -> _id = $user->id;
		}

		return !$this->errorCode;
	}
	
	public function getId()
	{
		return $this->_id;
	}
	
}