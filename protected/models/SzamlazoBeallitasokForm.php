<?php

/**
 * SzamlazoBeallitasok class.
 */
class SzamlazoBeallitasokForm extends CFormModel
{
        public $SzamlaImportPath;
        public $SzamlaImportVisszaigazolasPath;

        /**
         * Declares the validation rules.
         */
        public function rules()
        {
                return array(
//					array('SzamlaImportPath', 'required'),
//					array('SzamlaImportVisszaigazolasPath', 'required'),
					
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
					'SzamlaImportPath' => 'Számla létrehozás kérő XML-ek könyvtárának elérési útja',
					'SzamlaImportVisszaigazolasPath' => 'Számla létrehozás visszaigazolás XML-ek könyvtárának elérési útja',
                );
        }
        public function save() {
                Yii::app()->config->set('SzamlaImportPath', $this->SzamlaImportPath);
                Yii::app()->config->set('SzamlaImportVisszaigazolasPath', $this->SzamlaImportVisszaigazolasPath);

                return true;
        }
}