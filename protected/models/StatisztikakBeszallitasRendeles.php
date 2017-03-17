<?php

/**
 * Beszállítás - rendelés statisztika 'kereső' modelje.
 */
class StatisztikakBeszallitasRendeles extends CFormModel
{
        public $ev;
        public $statisztika_mettol;
        public $statisztika_meddig;

        /**
         * Declares the validation rules.
         */
        public function rules()
        {
                return array(
                    array('ev', 'required'),
                    array('ev', 'numerical', 'integerOnly'=>true),
                );
        }

        /**
         * Az ev-et konvertálja tól-ig időintervallumre (január 1-től december 31-ig), hogy lehessen használni a statisztikák controllerben korábban létrehozott lekérdező függvényt, annak tól-ig attribútumok kellenek a modelben
         * Ha sikertelen a konvertálás, false lesz a return
         */
        public function evIdointervallumConvert() {
                $return = false ;
                $minusz_tiz_ev = date("Y", mktime(0, 0, 0, date("m"), date("d"), date("Y")-10));
                if ($this->ev >= $minusz_tiz_ev && $this->ev <= date("Y")) {
                       $this->statisztika_mettol = $this->ev . "-01-01" ;
                       $this->statisztika_meddig = $this->ev . "-12-31" ;
                        $return = true ;
                }
                return $return ;
        }

        /**
         * Declares customized attribute labels.
         * If not declared here, an attribute would have a label that is
         * the same as its name with the first letter in upper case.
         */
        public function attributeLabels()
        {
                return array(
					'ev' => 'Év:',
                );
        }
        public function save() {
                return true;
        }
}