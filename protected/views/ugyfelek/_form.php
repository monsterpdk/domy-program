<?php
/* @var $this UgyfelekController */
/* @var $model Ugyfelek */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ugyfelek-form',
	'enableClientValidation' => true,
    'enableAjaxValidation' => true,
	//'clientOptions'=>array('validateOnSubmit'=>true,),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Cégadatok #1</strong>",
		));
	?>

	<?php echo CHtml::hiddenField('Hidden_ugyel_archiv' , $model->archiv, array('id' => 'Hidden_ugyel_archiv')); ?>
	
	<!--
	<div class="row">
		<?php //echo $form->labelEx($model,'ugyfel_tipus'); ?>
		<?php //echo DHtml::enumDropDownList($model, 'ugyfel_tipus'); ?>
		<?php //echo $form->error($model,'ugyfel_tipus'); ?>
	</div>
	-->
	
	<div class="row">
		<?php echo $form->labelEx($model,'cegnev'); ?>
		<?php echo $form->textField($model,'cegnev',array('size'=>60,'maxlength'=>127)); ?>
		<?php echo $form->error($model,'cegnev'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cegnev_teljes'); ?>
		<?php echo $form->textField($model,'cegnev_teljes',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'cegnev_teljes'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cegforma'); ?>
		
			<?php echo CHtml::activeDropDownList($model, 'cegforma',
				CHtml::listData(Cegformak::model()->findAll(array("condition"=>"torolt=0")), 'id', 'cegforma')
			); ?>
			
		<?php echo $form->error($model,'cegforma'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szekhely_irsz'); ?>
		
		<?php
			$this->widget('ext.typeahead.TbTypeAhead',array(
				 'model' => $model,
				 'attribute' => 'szekhely_irsz',
				 'enableHogan' => true,
				 'options' => array(
					 array(
						 'name' => 'szekhely_irsz',
						 'valueKey' => 'iranyitoszam',
						 'minLength' => 2,
						 'remote' => array(
							 'url' => Yii::app()->createUrl('/varosok/autoCompleteZipCode') . '?term=%QUERY',
							 'filter' => new CJavaScriptExpression('function(parsedResponse) {
								  var dataset = [];
									for(i = 0; i < parsedResponse.length; i++) {
										if (i == 0) {
											$("#Ugyfelek_szekhely_varos").val(parsedResponse[i].varosnev).off("blur");
										}
										
										dataset.push({
											iranyitoszam: parsedResponse[i].iranyitoszam,
											varosnev: parsedResponse[i].varosnev,
										});
									}
									return dataset;
							 }'),
						 ),
						 'template' => '<p>{{iranyitoszam}}</p>',
						 'engine' => new CJavaScriptExpression('Hogan'),
					 )
				 ),
				'events' => array(
					   'selected' => new CJavascriptExpression("function(evt,data) {
						   $('#Ugyfelek_szekhely_varos').val (data.varosnev).off('blur');
					   }"),
					   'autocompleted' => new CJavascriptExpression("function(evt,data) {
						   $('#Ugyfelek_szekhely_varos').val (data.varosnev).off('blur');
					   }"),
				),
			));
		?>			
		
		<?php echo $form->error($model,'szekhely_irsz'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szekhely_orszag'); ?>
		
			<?php echo CHtml::activeDropDownList($model, 'szekhely_orszag',
				CHtml::listData(Orszagok::model()->findAll(array("condition"=>"torolt=0")), 'id', 'nev')
			); ?>
			
		<?php echo $form->error($model,'szekhely_orszag'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szekhely_varos'); ?>
		<?php
			$this->widget('ext.typeahead.TbTypeAhead',array(
				 'model' => $model,
				 'attribute' => 'szekhely_varos',
				 'enableHogan' => true,
				 'options' => array(
					 array(
						 'name' => 'countries',
						 'valueKey' => 'varosnev',
						 'remote' => array(
							 'url' => Yii::app()->createUrl('/ugyfelek/autocomplete') . '?term=%QUERY',
						 ),
						 'template' => '<p>{{varosnev}}</p>',
						 'engine' => new CJavaScriptExpression('Hogan'),
					 )
				 ),
			));
		?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'szekhely_cim'); ?>
		<?php echo $form->textField($model,'szekhely_cim',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'szekhely_cim'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'arkategoria'); ?>
		
			<?php echo CHtml::activeDropDownList($model, 'arkategoria',
				CHtml::listData(Arkategoriak::model()->findAll(array("condition"=>"torolt=0")), 'id', 'displayArkategoria')
			); ?>
			
		<?php echo $form->error($model,'arkategoria'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'adoszam'); ?>
		<?php
			//echo $form->textField($model,'adoszam',array('size'=>15,'maxlength'=>15));
			$this->widget('CMaskedTextField', array(
			'model' => $model,
			'attribute' => 'adoszam',
			'mask' => '99999999-9-99',
			'htmlOptions' => array('size' => 15)
			));
		?>
		<?php echo $form->error($model,'adoszam'); ?>
	</div>
	
	<?php $this->endWidget(); ?>
	
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Cégadatok #2</strong>",
		));
	?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'posta_irsz'); ?>

		<?php
			$this->widget('ext.typeahead.TbTypeAhead',array(
				 'model' => $model,
				 'attribute' => 'posta_irsz',
				 'enableHogan' => true,
				 'options' => array(
					 array(
						 'name' => 'posta_irsz',
						 'valueKey' => 'iranyitoszam',
						 'minLength' => 2,
						 'remote' => array(
							 'url' => Yii::app()->createUrl('/varosok/autoCompleteZipCode') . '?term=%QUERY',
							 'filter' => new CJavaScriptExpression('function(parsedResponse) {
								  var dataset = [];
									for(i = 0; i < parsedResponse.length; i++) {
										if (i == 0) {
											$("#Ugyfelek_posta_varos").val(parsedResponse[i].varosnev).off("blur");
										}
										
										dataset.push({
											iranyitoszam: parsedResponse[i].iranyitoszam,
											varosnev: parsedResponse[i].varosnev,
										});
									}
									return dataset;
							 }'),
						 ),
						 'template' => '<p>{{iranyitoszam}}</p>',
						 'engine' => new CJavaScriptExpression('Hogan'),
					 )
				 ),
				'events' => array(
					   'selected' => new CJavascriptExpression("function(evt,data) {
						   $('#Ugyfelek_posta_varos').val (data.varosnev).off('blur');
					   }"),
					   'autocompleted' => new CJavascriptExpression("function(evt,data) {
						   $('#Ugyfelek_posta_varos').val (data.varosnev).off('blur');
					   }"),
				),
			));
		?>		
		
		<?php echo $form->error($model,'posta_irsz'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'posta_orszag'); ?>
		
			<?php echo CHtml::activeDropDownList($model, 'posta_orszag',
				CHtml::listData(Orszagok::model()->findAll(array("condition"=>"torolt=0")), 'id', 'nev')
			); ?>
			
		<?php echo $form->error($model,'posta_orszag'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'posta_varos'); ?>
		<?php
			$this->widget('ext.typeahead.TbTypeAhead',array(
				 'model' => $model,
				 'attribute' => 'posta_varos',
				 'enableHogan' => true,
				 'options' => array(
					 array(
						 'name' => 'posta_varos',
						 'valueKey' => 'varosnev',
						 'remote' => array(
							 'url' => Yii::app()->createUrl('/ugyfelek/autocomplete') . '?term=%QUERY',
						 ),
						 'template' => '<p>{{varosnev}}</p>',
						 'engine' => new CJavaScriptExpression('Hogan'),
					 )
				 ),
			));
		?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'posta_cim'); ?>
		<?php echo $form->textField($model,'posta_cim',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'posta_cim'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'szallitasi_irsz'); ?>

		<?php
			$this->widget('ext.typeahead.TbTypeAhead',array(
				 'model' => $model,
				 'attribute' => 'szallitasi_irsz',
				 'enableHogan' => true,
				 'options' => array(
					 array(
						 'name' => 'szallitasi_irsz',
						 'valueKey' => 'iranyitoszam',
						 'minLength' => 2,
						 'remote' => array(
							 'url' => Yii::app()->createUrl('/varosok/autoCompleteZipCode') . '?term=%QUERY',
							 'filter' => new CJavaScriptExpression('function(parsedResponse) {
								  var dataset = [];
									for(i = 0; i < parsedResponse.length; i++) {
										if (i == 0) {
											$("#Ugyfelek_szallitasi_varos").val(parsedResponse[i].varosnev).off("blur");
										}
										
										dataset.push({
											iranyitoszam: parsedResponse[i].iranyitoszam,
											varosnev: parsedResponse[i].varosnev,
										});
									}
									return dataset;
							 }'),
						 ),
						 'template' => '<p>{{iranyitoszam}}</p>',
						 'engine' => new CJavaScriptExpression('Hogan'),
					 )
				 ),
				'events' => array(
					   'selected' => new CJavascriptExpression("function(evt,data) {
						   $('#Ugyfelek_szallitasi_varos').val (data.varosnev).off('blur');
					   }"),
					   'autocompleted' => new CJavascriptExpression("function(evt,data) {
						   $('#Ugyfelek_szallitasi_varos').val (data.varosnev).off('blur');
					   }"),
				),
			));
		?>		
		
		<?php echo $form->error($model,'szallitasi_irsz'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szallitasi_orszag'); ?>
		
			<?php echo CHtml::activeDropDownList($model, 'szallitasi_orszag',
				CHtml::listData(Orszagok::model()->findAll(array("condition"=>"torolt=0")), 'id', 'nev')
			); ?>
			
		<?php echo $form->error($model,'szallitasi_orszag'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szallitasi_varos'); ?>
		<?php
			$this->widget('ext.typeahead.TbTypeAhead',array(
				 'model' => $model,
				 'attribute' => 'szallitasi_varos',
				 'enableHogan' => true,
				 'options' => array(
					 array(
						 'name' => 'szallitasi_varos',
						 'valueKey' => 'varosnev',
						 'remote' => array(
							 'url' => Yii::app()->createUrl('/ugyfelek/autocomplete') . '?term=%QUERY',
						 ),
						 'template' => '<p>{{varosnev}}</p>',
						 'engine' => new CJavaScriptExpression('Hogan'),
					 )
				 ),
			));
		?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szallitasi_cim'); ?>
		<?php echo $form->textField($model,'szallitasi_cim',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'szallitasi_cim'); ?>
	</div>	

	<div class="row">
		<?php echo $form->labelEx($model,'ugyvezeto_nev'); ?>
		<?php echo $form->textField($model,'ugyvezeto_nev',array('size'=>60,'maxlength'=>127)); ?>
		<?php echo $form->error($model,'ugyvezeto_nev'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ugyvezeto_telefon'); ?>
		
		<?php $this->widget("ext.maskedInput.MaskedInput", array(
                "model" => $model,
                "attribute" => "ugyvezeto_telefon",
                "mask" => '(99) 99-999-9999'                
            ));
		?>
		
		<?php echo $form->error($model,'ugyvezeto_telefon'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ugyvezeto_email'); ?>
		<?php echo $form->textField($model,'ugyvezeto_email',array('size'=>60,'maxlength'=>127)); ?>
		<?php echo $form->error($model,'ugyvezeto_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'kapcsolattarto_nev'); ?>
		<?php echo $form->textField($model,'kapcsolattarto_nev',array('size'=>60,'maxlength'=>127, 'readonly'=>true)); ?>
		<?php echo $form->error($model,'kapcsolattarto_nev'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'kapcsolattarto_telefon'); ?>
		<?php echo $form->textField($model,'kapcsolattarto_telefon',array('size'=>60,'maxlength'=>127, 'readonly'=>true)); ?>
		
		<?php 
/*			$this->widget("ext.maskedInput.MaskedInput", array(
                "model" => $model,
                "attribute" => "kapcsolattarto_telefon",
                "mask" => '(99) 99-999-9999',
            ));*/
		?>

		<?php echo $form->error($model,'kapcsolattarto_telefon'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'kapcsolattarto_email'); ?>
		<?php echo $form->textField($model,'kapcsolattarto_email',array('size'=>60,'maxlength'=>127, 'readonly'=>true)); ?>
		<?php echo $form->error($model,'kapcsolattarto_email'); ?>
	</div>
	
	<?php $this->endWidget(); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Cégadatok #3</strong>",
		));
	?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'ceg_telefon'); ?>
		
		<?php $this->widget("ext.maskedInput.MaskedInput", array(
                "model" => $model,
                "attribute" => "ceg_telefon",
                "mask" => '(99) 99-999-9999'                
            ));
		?>

		<?php echo $form->error($model,'ceg_telefon'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ceg_fax'); ?>
		
		<?php $this->widget("ext.maskedInput.MaskedInput", array(
                "model" => $model,
                "attribute" => "ceg_fax",
                "mask" => '(99) 99-999-9999'                
            ));
		?>
		
		<?php echo $form->error($model,'ceg_fax'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ceg_email'); ?>
		<?php echo $form->textField($model,'ceg_email',array('size'=>60,'maxlength'=>127)); ?>
		<?php echo $form->error($model,'ceg_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ceg_honlap'); ?>
		<?php echo $form->textField($model,'ceg_honlap',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'ceg_honlap'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szamlaszam1'); ?>
		<?php echo $form->textField($model,'szamlaszam1',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'szamlaszam1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szamlaszam2'); ?>
		<?php echo $form->textField($model,'szamlaszam2',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'szamlaszam2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'eu_adoszam'); ?>
		<?php echo $form->textField($model,'eu_adoszam',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'eu_adoszam'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'teaor'); ?>
		<?php echo $form->textField($model,'teaor',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'teaor'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tevekenysegi_kor'); ?>
		<?php echo $form->textField($model,'tevekenysegi_kor',array('size'=>60,'maxlength'=>127)); ?>
		<?php echo $form->error($model,'tevekenysegi_kor'); ?>
	</div>

	<?php $this->endWidget(); ?>
	
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Cégadatok #4</strong>",
		));
	?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'arbevetel'); ?>
		<?php echo $form->textField($model,'arbevetel',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'arbevetel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'foglalkoztatottak_szama'); ?>
		<?php echo $form->textField($model,'foglalkoztatottak_szama',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'foglalkoztatottak_szama'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'adatforras'); ?>
		
			<?php echo CHtml::activeDropDownList($model, 'adatforras',
				CHtml::listData(Adatforrasok::model()->findAll(array("condition"=>"torolt=0")), 'id', 'adatforras')
			); ?>
			
		<?php echo $form->error($model,'adatforras'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'besorolas'); ?>
		
			<?php echo CHtml::activeDropDownList($model, 'besorolas',
				CHtml::listData(Besorolasok::model()->findAll(array("condition"=>"torolt=0")), 'id', 'besorolas')
			); ?>
			
		<?php echo $form->error($model,'besorolas'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'megjegyzes'); ?>
		<?php echo $form->textArea($model,'megjegyzes',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'megjegyzes'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fontos_megjegyzes'); ?>
		<?php echo $form->textArea($model,'fontos_megjegyzes',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'fontos_megjegyzes'); ?>
	</div>
	<?php $this->endWidget(); ?>
	
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Kapcsolók</strong>",
		));
	?>
	
	<div class="row active">
		<?php echo $form->checkBox($model,'fizetesi_felszolitas_volt'); ?>
		<?php echo $form->labelEx($model,'fizetesi_felszolitas_volt'); ?>
		<?php echo $form->error($model,'fizetesi_felszolitas_volt'); ?>
	</div>

	<div class="row active">
		<?php echo $form->checkBox($model,'ugyvedi_felszolitas_volt'); ?>
		<?php echo $form->labelEx($model,'ugyvedi_felszolitas_volt'); ?>
		<?php echo $form->error($model,'ugyvedi_felszolitas_volt'); ?>
	</div>

	<div class="row active">
		<?php echo $form->checkBox($model,'levelezes_engedelyezett'); ?>
		<?php echo $form->labelEx($model,'levelezes_engedelyezett'); ?>
		<?php echo $form->error($model,'levelezes_engedelyezett'); ?>
	</div>

	<div class="row active">
		<?php echo $form->checkBox($model,'email_engedelyezett'); ?>
		<?php echo $form->labelEx($model,'email_engedelyezett'); ?>
		<?php echo $form->error($model,'email_engedelyezett'); ?>
	</div>

	<div class="row active">
		<?php echo $form->checkBox($model,'kupon_engedelyezett'); ?>
		<?php echo $form->labelEx($model,'kupon_engedelyezett'); ?>
		<?php echo $form->error($model,'kupon_engedelyezett'); ?>
	</div>

	<div class="row active">
		<?php echo $form->checkBox($model,'egyedi_kuponkedvezmeny'); ?>
		<?php echo $form->labelEx($model,'egyedi_kuponkedvezmeny'); ?>
		<?php echo $form->error($model,'egyedi_kuponkedvezmeny'); ?>
	</div>

	<div class="row active">
		<?php echo $form->checkBox($model,'archiv'); ?>
		<?php echo $form->labelEx($model,'archiv'); ?>
		<?php echo $form->error($model,'archiv'); ?>
	</div>

	<?php $this->endWidget(); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Fizetési adatok</strong>",
		));
	?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'elso_vasarlas_datum'); ?>
		<?php echo $form->textField($model,'elso_vasarlas_datum',array('size'=>10, 'maxlength'=>10, 'readonly'=>true)); ?>
		<?php echo $form->error($model,'elso_vasarlas_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'utolso_vasarlas_datum'); ?>
		<?php echo $form->textField($model,'utolso_vasarlas_datum',array('size'=>10, 'maxlength'=>10, 'readonly'=>true)); ?>
		<?php echo $form->error($model,'utolso_vasarlas_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fizetesi_hatarido'); ?>
		<?php echo $form->textField($model,'fizetesi_hatarido',array('size'=>60,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'fizetesi_hatarido'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'max_fizetesi_keses'); ?>
		<?php echo $form->textField($model,'max_fizetesi_keses'); ?>
		<?php echo $form->error($model,'max_fizetesi_keses'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'atlagos_fizetesi_keses'); ?>
		<?php echo $form->textField($model,'atlagos_fizetesi_keses'); ?>
		<?php echo $form->error($model,'atlagos_fizetesi_keses'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rendelesi_tartozasi_limit'); ?>
		<?php echo $form->textField($model,'rendelesi_tartozasi_limit',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'rendelesi_tartozasi_limit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fizetesi_moral'); ?>
		
		<?php //echo $form->dropDownList($model, 'fizetesi_moral',array("0"=>"0","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5"), array());
		?>
		
		<?php echo $form->textField($model,'fizetesi_moral',array('size'=>10,'maxlength'=>10, 'readonly'=>false)); ?>
		
		<?php echo $form->error($model,'fizetesi_moral'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'adatok_egyeztetve_datum'); ?>
			
			<?php
				$this->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$model,
					'attribute'=>'adatok_egyeztetve_datum',
					'options'=>array('dateFormat'=>'yy-mm-dd',),
					'htmlOptions'=>array('style' => 'width:123px'),
				));
			?>
			
			<?php
				$this->widget('zii.widgets.jui.CJuiButton', array(
					'name'=>'button_set_now_adatok_egyeztetve_datum',
					'caption'=>'Most',
					'buttonType'=>'link',
					'onclick'=>new CJavaScriptExpression('function() {  
						$("#Ugyfelek_adatok_egyeztetve_datum").datepicker("setDate", new Date());
					}'),
					'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'margin-left:10px; height:32px', 'target' => '_blank'),
				));
			?>
		
		<?php echo $form->error($model,'adatok_egyeztetve_datum'); ?>
	</div>	
	
	<div class="row">
		<?php echo $form->labelEx($model,'archivbol_vissza_datum'); ?>
		<?php echo $form->textField($model,'archivbol_vissza_datum',array('size'=>10, 'maxlength'=>10, 'readonly'=>true)); ?>
		<?php echo $form->error($model,'archivbol_vissza_datum'); ?>
	</div>

	<?php if (Yii::app()->user->checkAccess('Admin')): ?>
		<div class="row active">
			<?php echo $form->checkBox($model,'torolt'); ?>
			<?php echo $form->label($model,'torolt'); ?>
			<?php echo $form->error($model,'torolt'); ?>
		</div>
	<?php endif; ?>

	<div class="row buttons">
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
					 array(
						'name'=>'submitForm',
						'caption'=>'Mentés',
						'htmlOptions' => array ('class' => 'btn btn-primary btn-lg', 'onclick'=>'js: return checkFlags();'),
					 )); ?>
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
					 array(
						'name'=>'back',
						'caption'=>'Vissza',
						'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'submit' => Yii::app()->request->urlReferrer),
					 )); ?>
	</div>
	
	<?php $this->endWidget(); ?>

	<?php
		echo CHtml::link('Ügyfélügyintéző hozzáadása', '#', array('id' => 'loadUgyfelUgyintezoByAjax', 'class' => 'btn', 'style' => 'margin-bottom: 20px'));
	?>
    <div id="ugyfelUgyintezok">
        <?php
        $index = 0;
        foreach ($model->ugyfelUgyintezo as $id => $uu):
            $this->renderPartial('ugyfelUgyintezok/_form', array(
                'model' => $uu,
                'index' => $id,
                'display' => 'block'
            ));
            $index++;
        endforeach;
        ?>
    </div>	
	
<?php $this->endWidget(); ?>

</div><!-- form -->

<?php
	// archiváláskor meg kell adni az archiválás okáta
	// inicializáljuk a dialog-ot hozzá
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id'=>'dialogArchiveReason',
		'options'=>array(
			'title'=>'Archiválás oka',
			'autoOpen'=>false,
			'modal'=>true,
			'width'=>450,
			'height'=>270,
		),
	));?>
	
	<div class="divForForm buttons">
		<?php echo CHtml::label('Archiválás oka:', 'editTextArchiveReason'); ?>
		<?php echo CHtml::textArea('editTextArchiveReason', '', array('style' => "width: 405px; height: 103px;")); ?>
		
		<div align = 'right'>
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
					 array(
						'name'=>'submitDialog',
						'caption'=>'Ok',
						'htmlOptions' => array ('class' => 'btn btn-primary btn-lg', 'onclick'=>'js: saveArchiveReason();',),
					 )); ?>
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
					 array(
						'name'=>'cancelDialog',
						'caption'=>'Mégse',
						'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'onclick'=>'js: $("#dialogArchiveReason").dialog("close"); return false;',),
					 )); ?>
		</div>
	</div>
	 
<?php $this->endWidget();?>
	
<script language = 'JavaScript'>
	function checkFlags() {
		// ha bepipáltuk az archiv flag-et (és eddig nem volt archiv az ügyfél),
		// akkor feldobunk egy dialog-ot, amiben meg kell adni az archiválás okát
		var checkedArchive = $("#Ugyfelek_archiv").is(':checked');
		var oldArchive = $("#Hidden_ugyel_archiv").val() == '1' ? true : false;
		
		if (checkedArchive && !oldArchive)
			$('#dialogArchiveReason').dialog('open');
		else if (!checkedArchive && oldArchive) {
			var today = new Date();
			// archive-ból veszük vissza, ki kell tölteni az archive-ból visszavett dátumot
			$("#Ugyfelek_archivbol_vissza_datum").val(today.toISOString().substring(0, 10));
			
			return true;
		}
		else 
			return true;
		
		return false;
	}
	
	function saveArchiveReason() {
		$("#dialogArchiveReason").dialog("close");

		// hozzáfűzzük a 'fontos megjegyzés' mezőhöz az archiválás okát
		var sFontosMegjegyzes = $("#Ugyfelek_fontos_megjegyzes").val();
		var sArchivReason = $("#editTextArchiveReason").val();

		$("#Ugyfelek_fontos_megjegyzes").val( (( sFontosMegjegyzes.length > 0) ? sFontosMegjegyzes + ' ' :  '') + 'Archiválás oka: ' + sArchivReason );

		$("#ugyfelek-form").submit();
	}
</script>

<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('ugyfelugyintezo', '
	var _index = ' . $index . ';
	$("#loadUgyfelUgyintezoByAjax").click(function(e){
		e.preventDefault();
		var _url = "' . Yii::app()->controller->createUrl("loadUgyfelUgyintezoByAjax", array("load_for" => $this->action->id)) . '&index="+_index;
		$.ajax({
			url: _url,
			success:function(response){
				$("#ugyfelUgyintezok").append(response);
				$("#ugyfelUgyintezok .crow").last().animate({
					opacity : 1,
					left: "+50",
					height: "toggle"
				});
			}
		});
		_index++;
	});
', CClientScript::POS_END);
?>