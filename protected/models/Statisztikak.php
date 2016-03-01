<?php

/**
 * Statisztikak class.
 */
class Statisztikak extends CFormModel
{
        public $statisztika_mettol;
        public $statisztika_meddig;
		
        /**
         * Declares the validation rules.
         */
        public function rules()
        {
                return array(
                	array('statisztika_mettol, statisztika_meddig', 'required'),
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
					'statisztika_mettol' => 'Mettől:',
					'statisztika_meddig' => 'Meddig:',
                );
        }
        public function save() {
                return true;
        }
}