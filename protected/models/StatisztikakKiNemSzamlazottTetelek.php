<?php

/**
 * Ki nem számlázott tételek statisztika 'kereső' modelje.
 */
class StatisztikakKiNemSzamlazottTetelek extends CFormModel
{
        public $statisztika_mettol;
        public $statisztika_meddig;
		public $stat_type_filter;
		public $ugyfel_id;
        public $autocomplete_ugyfel_name;

        /**
         * Declares the validation rules.
         */
        public function rules()
        {
                return array(
                	array('statisztika_mettol, statisztika_meddig, stat_type_filter', 'required'),
					array('statisztika_meddig', 'checkDates'),
					array('ugyfel_id', 'numerical', 'integerOnly'=>true),
                );
        }

		// a végdátum nagyobb kell legyen, mint a kezdődátum
		public function checkDates($attribute,$params)
		{
			if ($this->statisztika_mettol != null && $this->statisztika_meddig != null) {
				if (!($this->statisztika_mettol <= $this->statisztika_meddig))
					$this->addError('statisztika_mettol', 'A végdátum nagyobb kell legyen, mint a kezdődátum.');
			}
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
					'stat_type_filter' => 'Statisztika típusa:',
					'ugyfel_id' => 'Ügyfél',
                );
        }
        public function save() {
                return true;
        }

    protected function afterFind(){
        parent::afterFind();

        // autocomplete mező esetén az ügyfél ID van csak meg, így a beszédes
        // cégnevet, címet kézzel kell kitöltenünk
        if ($this -> ugyfel != null) {
            $this -> autocomplete_ugyfel_name = $this -> ugyfel -> cegnev;
        }
    }
}