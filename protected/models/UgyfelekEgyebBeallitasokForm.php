<?php

/**
 * UgyfelekEgyebBeallitasok class.
 */
class UgyfelekEgyebBeallitasokForm extends CFormModel
{
        public $alapertelmezettRendelesTartozasLimit;

        /**
         * Declares the validation rules.
         */
        public function rules()
        {
                return array(
					array('alapertelmezettRendelesTartozasLimit', 'required'),
					array('alapertelmezettRendelesTartozasLimit', 'numerical'),
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
					'alapertelmezettRendelesTartozasLimit' => 'Alapértelmezett rendelés tartozás limit',
                );
        }
        public function save() {
                Yii::app()->config->set('alapertelmezettRendelesTartozasLimit', $this->alapertelmezettRendelesTartozasLimit);

                return true;
        }
}