<?php

/**
 * NyomdakonyvBeallitasok class.
 */
class NyomdakonyvBeallitasokForm extends CFormModel
{
        public $NyomDbfPath;
        public $WorkflowDbfPath;
        public $MunkataskaXmlExportPath;
		
        /**
         * Declares the validation rules.
         */
        public function rules()
        {
                return array(
//					array('SzamlaImportPath', 'required'),
//					array('SzamlaImportVisszaigazolasPath', 'required'),
					
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
					'NyomDbfPath' => 'NYOM.dbf elérési út (géptermi programhoz)',
					'WorkflowDbfPath' => 'WORKFLOW.dbf elérési út (géptermi programhoz)',
					'MunkataskaXmlExportPath' => 'Munkatáskák XML exportjának elérési útja (másik géptermi programhoz)',
                );
        }
        public function save() {
				Yii::app()->config->set('NyomDbfPath', $this->NyomDbfPath);
				
                Yii::app()->config->set('WorkflowDbfPath', $this->WorkflowDbfPath);

                Yii::app()->config->set('MunkataskaXmlExportPath', $this->MunkataskaXmlExportPath);
                
                return true;
        }
}