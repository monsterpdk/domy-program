<?php
	class Formatter extends CFormatter {
		public function formatBoolean($value){
				return $value ? Yii::t('yii', $this->booleanFormat[1]) : Yii::t('yii', $this->booleanFormat[0]);
		}
	 
		public function formatHeadline($value) {
			return '<b>' . $value . '</b>';
		}
	}
?>