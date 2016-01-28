<?php

/**
 * NyomtatoBeallitasok class.
 */
class NyomtatoBeallitasokForm extends CFormModel
{
        public $PdfBoxUrl;
		
        /**
         * Declares the validation rules.
         */
        public function rules()
        {
                return array(
					array('PdfBoxUrl', 'required'),
					
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
					'PdfBoxUrl' => 'PDFBox library elérési útja',
                );
        }
        public function save() {
				Yii::app()->config->set('PdfBoxUrl', $this->PdfBoxUrl);
				
                return true;
        }
}