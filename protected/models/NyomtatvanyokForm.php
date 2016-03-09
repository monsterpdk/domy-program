<?php

/**
 * NyomtatvanyokForm class.
 */
class NyomtatvanyokForm extends CFormModel
{
        public $AnyagBeszallitasokAtveteli;
		public $AnyagBeszallitasokRaktar;
		public $AnyagrendelesekArNelkul;
		public $AnyagrendelesekArral;
		public $Arajanlat;
		public $MegrendelesekProforma;
		public $MegrendelesekVisszaigazolas;
		public $NyomdakonyvCtp;
		public $NyomdakonyvMunkataska;
		public $NyomdakonyvUtemezes;
		public $Szallitolevel;
		
        /**
         * Egyelőre nem validálunk semmit. Ha nem töltik ki a lábléc szöveget, akkor üres marad a nyomtatvány lábléce.
         */
        public function rules()
        {
                return array(
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
					'AnyagBeszallitasokAtveteli' => 'Anyagbeszállítások átvételi:',
					'AnyagBeszallitasokRaktar' => 'Anyagbeszállítások raktár:',
					'AnyagrendelesekArNelkul' => 'Anyagrendelések ár nélkül:',
					'AnyagrendelesekArral' => 'Anyagrendelések árral:',
					'Arajanlat' => 'Árajánlat',
					'MegrendelesekProforma' => 'Megrendelések proforma:',
					'MegrendelesekVisszaigazolas' => 'Megrendelések visszaigazolás',
					'NyomdakonyvCtp' => 'Nyomdakönyv CTP',
					'NyomdakonyvMunkataska' => 'Nyomdakönyv munkatáska',
					'NyomdakonyvUtemezes' => 'Nyomdakönyv ütemezés',
					'Szallitolevel' => 'Szállítólevél',
                );
        }
        public function save() {
				Yii::app()->config->set('AnyagBeszallitasokAtveteli', $this->AnyagBeszallitasokAtveteli);
				Yii::app()->config->set('AnyagBeszallitasokRaktar', $this->AnyagBeszallitasokRaktar);
				Yii::app()->config->set('AnyagrendelesekArNelkul', $this->AnyagrendelesekArNelkul);
				Yii::app()->config->set('AnyagrendelesekArral', $this->AnyagrendelesekArral);
				Yii::app()->config->set('Arajanlat', $this->Arajanlat);
				Yii::app()->config->set('MegrendelesekProforma', $this->MegrendelesekProforma);
				Yii::app()->config->set('MegrendelesekVisszaigazolas', $this->MegrendelesekVisszaigazolas);
				Yii::app()->config->set('NyomdakonyvCtp', $this->NyomdakonyvCtp);
				Yii::app()->config->set('NyomdakonyvMunkataska', $this->NyomdakonyvMunkataska);
				Yii::app()->config->set('NyomdakonyvUtemezes', $this->NyomdakonyvUtemezes);
				Yii::app()->config->set('Szallitolevel', $this->Szallitolevel);

                return true;
        }
}