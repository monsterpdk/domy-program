<?php
class LoggableBehavior extends CActiveRecordBehavior
{
	private $_oldattributes = array();
	private $_notLoggableFields = array ('password');
	
	public function afterSave($event)
	{
		try {
			$username = Yii::app()->user->Name;
			$userid = Yii::app()->user->id;
		} catch(Exception $e) { //If we have no user object, this must be a command line program
			$username = "-";
			$userid = null;
		}
		
		if(empty($username)) {
			$username = "-";
		}
		
		if(empty($userid)) {
			$userid = null;
		}
	
		$newattributes = $this->Owner->getAttributes();
		$oldattributes = $this->getOldAttributes();
		
		if (!$this->Owner->isNewRecord) {
			// compare old and new
			foreach ($newattributes as $name => $value) {
				if (!empty($oldattributes)) {
					$old = $oldattributes[$name];
				} else {
					$old = '';
				}

				if ($value != $old && !in_array($name, $this->_notLoggableFields) ) {
					$log=new AuditTrail();
					$log->old_value = $old;
					$log->new_value = $value;
					$log->action = 'MÓDOSÍTÁS';
					$log->model = $this->Owner->getClassName();
					$log->model_id = $this->Owner->getPrimaryKey();
					$log->field = $this->Owner->getAttributeLabel($name);
					$log->stamp = date('Y-m-d H:i:s');
					$log->username = $username;
					$log->user_id = $userid;
					
					$log->save();
				}
			}
		} else {
			$log=new AuditTrail();
			$log->old_value = '';
			$log->new_value = '';
			$log->action=		'LÉTREHOZÁS';
			$log->model=		$this->Owner->getClassName();
			$log->model_id=		 $this->Owner->getPrimaryKey();
			$log->field=		'-';
			$log->stamp= date('Y-m-d H:i:s');
			$log->username = $username;
			$log->user_id=		 $userid;
			
			$log->save();
			
			foreach ($newattributes as $name => $value) {
				if (!in_array($name, $this->_notLoggableFields)) {
					$log=new AuditTrail();
					$log->old_value = '';
					$log->new_value = $value;
					$log->action=		'MEZŐ LÉTREHOZÁSA';
					$log->model=		$this->Owner->getClassName();
					$log->model_id=		 $this->Owner->getPrimaryKey();
					$log->field=		$this->Owner->getAttributeLabel($name);;
					$log->stamp= date('Y-m-d H:i:s');
					$log->username = $username;
					$log->user_id=		 $userid;
					$log->save();
				}
			}
			
			
			
		}
		return parent::afterSave($event);
	}

	public function afterDelete($event)
	{
	
		try {
			$username = Yii::app()->user->Name;
			$userid = Yii::app()->user->id;
		} catch(Exception $e) {
			$username = "-";
			$userid = null;
		}

		if(empty($username)) {
			$username = "-";
		}
		
		if(empty($userid)) {
			$userid = null;
		}
		
		$log=new AuditTrail();
		$log->old_value = '';
		$log->new_value = '';
		$log->action=		'TÖRLÉS';
		$log->model=		$this->Owner->getClassName();
		$log->model_id=		 $this->Owner->getPrimaryKey();
		$log->field=		'-';
		$log->stamp= date('Y-m-d H:i:s');
		$log->user_id=		 $userid;
		$log->username = $username;
		$log->save();
		return parent::afterDelete($event);
	}

	public function afterFind($event)
	{
		// Save old values
		$this->setOldAttributes($this->Owner->getAttributes());
		
		return parent::afterFind($event);
	}

	public function getOldAttributes()
	{
		return $this->_oldattributes;
	}

	public function setOldAttributes($value)
	{
		$this->_oldattributes=$value;
	}
}
?>