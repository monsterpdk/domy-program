<?php

/**
 * TermekAthelyezForm class.
 */
class TermekAthelyezForm extends CFormModel
{
		public $raktarTermekId;
        public $termekId;
		public $termekNevDsp;
        public $forrasRaktarHelyId;
        public $forrasElerhetoDb;
        public $forrasFoglaltDb;
        public $celRaktarHelyId;
        public $celElerhetoDb;
        public $celFoglaltDb;
		
        /**
         * Declares the validation rules.
         */
        public function rules()
        {
                return array(
					array('celRaktarHelyId, celElerhetoDb, celFoglaltDb', 'required'),
					array('celElerhetoDb, celFoglaltDb', 'numerical', 'integerOnly'=>true),
					
					array('celElerhetoDb', 'isElerhetoGreaterThanAthelyezendo'),
					array('celFoglaltDb', 'isFoglaltGreaterThanAthelyezendoFoglalt'),
					array('celRaktarHelyId', 'isRaktarhelyMatch'),
                );
        }

		// leellenőrizzük, hogy az áthelyezendő mennyiségek kisebbek-e, mint a raktárban jelenleg elérhető mennyiségek
		public function isElerhetoGreaterThanAthelyezendo ($attribute)
		{
			if ($this->celElerhetoDb != null && $this->celElerhetoDb > $this->forrasElerhetoDb) {
				$this->addError($attribute, 'Az áthelyezni kívánt darabszám nagyobb, mint amennyi a raktárban jelenleg elérhető!');
				
				return false;
			}
			
			if ($this->celElerhetoDb != null && $this->celElerhetoDb < 0) {
				$this->addError($attribute, 'Az áthelyezni kívánt darabszám nem lehet 0-nál kisebb!');
				
				return false;
			}
			
			return true;
		}

		// leellenőrizzük, hogy az áthelyezendő foglalt mennyiségek kisebbek-e, mint a raktárban jelenleg elérhető foglalt mennyiségek
		public function isFoglaltGreaterThanAthelyezendoFoglalt ($attribute)
		{
			if ($this -> celFoglaltDb != null && $this -> celFoglaltDb > $this -> forrasFoglaltDb) {
				$this->addError($attribute, 'Az áthelyezni kívánt foglalt darabszám nagyobb, mint amennyi a raktárban jelenleg elérhető!');
				
				return false;
			}
			
			if ($this->celFoglaltDb != null && $this->celFoglaltDb < 0) {
				$this->addError($attribute, 'Az áthelyezni kívánt foglalt darabszám nem lehet 0-nál kisebb!');
				
				return false;
			}
			
			return true;
		}
		
			// leellenőrizzük, hogy a forrás és cél raktárhelyek nem egyeznek-e
		public function isRaktarhelyMatch ($attribute)
		{
			if ($this -> forrasRaktarHelyId != null && $this -> celRaktarHelyId && $this -> forrasRaktarHelyId == $this -> celRaktarHelyId) {
				$this->addError($attribute, 'A forrás és cél raktárhelyeknek különbözniük kell!');
				
				return false;
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
					'termekId' => '',
					'termekNevDsp' => 'Áthelyezendő termék neve',
					'forrasRaktarHelyId' => 'Forrás raktárhely',
					'forrasElerhetoDb' => 'Elérhető db',
					'forrasFoglaltDb' => 'Foglalt db',
					'celRaktarHelyId' => 'Cél raktárhely',
					'celElerhetoDb' => 'Áthelyezendő db',
					'celFoglaltDb' => 'Áthelyezendő foglalt db',
                );
        }
        public function save() {
				
                return true;
        }
}