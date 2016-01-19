<?php

/**
 * EmailBeallitasok class.
 */
class EmailBeallitasokForm extends CFormModel
{
        public $ArajanlatKuldoEmail;
        public $ArajanlatKuldoHost;
        public $ArajanlatKuldoPort;
        public $ArajanlatKuldoTitkositas;
        public $ArajanlatKuldoSMTP;
        public $ArajanlatKuldoSMTPUser;
        public $ArajanlatKuldoSMTPPassword;
        public $ArajanlatKuldoFromName;
        public $ArajanlatKuldoAlapertelmezettSubject;
		
        /**
         * Declares the validation rules.
         */
        public function rules()
        {
                return array(
//					array('ArajanlatKuldoEmail', 'required'),
//					array('ArajanlatKuldoHost', 'required'),
					
                );
        }

        /**
         * Declares customized attribute labels.
         * If not declared here, an attribute would have a label that is
         * the same as its name with the first letter in upper case.
         */
        public function attributeLabels()
        {
                return array(
					'ArajanlatKuldoEmail' => 'Feladó e-mail cím',
					'ArajanlatKuldoHost' => 'Levelezőszerver címe',
					'ArajanlatKuldoPort' => 'Levelezőszerveren használt port',
					'ArajanlatKuldoTitkositas' => 'Titkosítás',
					'ArajanlatKuldoSMTP' => 'SMTP-t használ',
					'ArajanlatKuldoSMTPUser' => 'SMTP felhasználói név',
					'ArajanlatKuldoSMTPPassword' => 'SMTP jelszó',
					'ArajanlatKuldoFromName' => 'Küldőnél megjelenő név',
					'ArajanlatKuldoAlapertelmezettSubject' => 'Alapértelmezett tárgy',
                );
        }
        public function save() {
				Yii::app()->config->set('ArajanlatKuldoEmail', $this->ArajanlatKuldoEmail);
				Yii::app()->config->set('ArajanlatKuldoHost', $this->ArajanlatKuldoHost);
				Yii::app()->config->set('ArajanlatKuldoPort', $this->ArajanlatKuldoPort);
				Yii::app()->config->set('ArajanlatKuldoTitkositas', $this->ArajanlatKuldoTitkositas);
				Yii::app()->config->set('ArajanlatKuldoSMTP', $this->ArajanlatKuldoSMTP);
				Yii::app()->config->set('ArajanlatKuldoSMTPUser', $this->ArajanlatKuldoSMTPUser);
				Yii::app()->config->set('ArajanlatKuldoSMTPPassword', $this->ArajanlatKuldoSMTPPassword);
				Yii::app()->config->set('ArajanlatKuldoFromName', $this->ArajanlatKuldoFromName);
				Yii::app()->config->set('ArajanlatKuldoAlapertelmezettSubject', $this->ArajanlatKuldoAlapertelmezettSubject);
				
                return true;
        }
}