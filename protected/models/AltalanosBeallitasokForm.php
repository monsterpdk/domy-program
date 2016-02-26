<?php

/**
 * AltalanosBeallitasok class.
 */
class AltalanosBeallitasokForm extends CFormModel
{
        public $IndexViewPagination;
		
        /**
         * Declares the validation rules.
         */
        public function rules()
        {
                return array(
					array('IndexViewPagination', 'numerical'),
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
					'IndexViewPagination' => 'A nézetekben egyszerre megjelenő sorok száma (egyelőre csak az index oldalakon érvényes ez a beállítás):',
                );
        }
        public function save() {
				Yii::app()->config->set('IndexViewPagination', $this->IndexViewPagination);

                return true;
        }
}