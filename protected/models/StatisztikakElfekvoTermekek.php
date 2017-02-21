<?php

/**
 * Elfekvő termék statisztika 'kereső' modelje.
 */
class StatisztikakElfekvoTermekek extends CFormModel
{
        public $nap_filter;

        /**
         * Declares the validation rules.
         */
        public function rules()
        {
                return array(
					array('nap_filter', 'checkDays'),
                );
        }

		// 30, 60, vagy 90 lehet ez az érték, a többi nem valid
		public function checkDays($attribute,$params)
		{
			if ($this->nap_filter == null || !($this->nap_filter == 30 || $this->nap_filter == 60 || $this->nap_filter == 90))
				$this->addError('nap_filter', 'A szűrőfeltétel 30, 60 vagy 90 nap kell legyen.');
		}
		
        /**
         * Declares customized attribute labels.
         * If not declared here, an attribute would have a label that is
         * the same as its name with the first letter in upper case.
         */
        public function attributeLabels()
        {
                return array(
					'nap_filter' => 'Raktáron van legalább ennyi napja:',
                );
        }
        public function save() {
                return true;
        }
}