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
		
	<div class="row">
		<?php echo $form->labelEx($model,'ugyfel_tipus'); ?>
		<?php echo DHtml::enumDropDownList($model, 'ugyfel_tipus'); ?>
		<?php echo $form->error($model,'ugyfel_tipus'); ?>
	</div>

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
		<?php echo $form->labelEx($model,'szekhely_irsz'); ?>
		<?php echo $form->textField($model,'szekhely_irsz',array('size'=>6,'maxlength'=>6)); ?>
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
		<?php echo $form->textField($model,'posta_irsz',array('size'=>6,'maxlength'=>6)); ?>
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
		<?php echo $form->labelEx($model,'posta_cim'); ?>
		<?php echo $form->textField($model,'posta_cim',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'posta_cim'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ugyvezeto_nev'); ?>
		<?php echo $form->textField($model,'ugyvezeto_nev',array('size'=>60,'maxlength'=>127)); ?>
		<?php echo $form->error($model,'ugyvezeto_nev'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ugyvezeto_telefon'); ?>
		<?php echo $form->textField($model,'ugyvezeto_telefon',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'ugyvezeto_telefon'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ugyvezeto_email'); ?>
		<?php echo $form->textField($model,'ugyvezeto_email',array('size'=>60,'maxlength'=>127)); ?>
		<?php echo $form->error($model,'ugyvezeto_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'kapcsolattarto_nev'); ?>
		<?php echo $form->textField($model,'kapcsolattarto_nev',array('size'=>60,'maxlength'=>127)); ?>
		<?php echo $form->error($model,'kapcsolattarto_nev'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'kapcsolattarto_telefon'); ?>
		<?php echo $form->textField($model,'kapcsolattarto_telefon',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'kapcsolattarto_telefon'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'kapcsolattarto_email'); ?>
		<?php echo $form->textField($model,'kapcsolattarto_email',array('size'=>60,'maxlength'=>127)); ?>
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
		<?php echo $form->textField($model,'ceg_telefon',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'ceg_telefon'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ceg_fax'); ?>
		<?php echo $form->textField($model,'ceg_fax',array('size'=>30,'maxlength'=>30)); ?>
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
		<?php echo $form->labelEx($model,'cegforma'); ?>
		
			<?php echo CHtml::activeDropDownList($model, 'cegforma',
				CHtml::listData(Cegformak::model()->findAll(array("condition"=>"torolt=0")), 'id', 'cegforma')
			); ?>
			
		<?php echo $form->error($model,'cegforma'); ?>
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
		<?php echo $form->textField($model,'megjegyzes',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'megjegyzes'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fontos_megjegyzes'); ?>
		<?php echo $form->textField($model,'fontos_megjegyzes',array('size'=>60,'maxlength'=>255)); ?>
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
		
			<?php
				$this->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$model,
					'attribute'=>'elso_vasarlas_datum',
					'options'=>array('dateFormat'=>'yy-mm-dd',)
				));
			?>
		
		<?php echo $form->error($model,'elso_vasarlas_datum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'utolso_vasarlas_datum'); ?>
		
			<?php
				$this->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$model,
					'attribute'=>'utolso_vasarlas_datum',
					'options'=>array('dateFormat'=>'yy-mm-dd',)
				));
			?>
		
		<?php echo $form->error($model,'utolso_vasarlas_datum'); ?>
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
		<?php echo $form->dropDownList($model, 'fizetesi_moral',array("0"=>"0","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5"), array()); ?>
		<?php echo $form->error($model,'fizetesi_moral'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'adatok_egyeztetve_datum'); ?>
		
			<?php
				$this->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$model,
					'attribute'=>'adatok_egyeztetve_datum',
					'options'=>array('dateFormat'=>'yy-mm-dd',)
				));
			?>
		
		<?php echo $form->error($model,'adatok_egyeztetve_datum'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'archivbol_vissza_datum'); ?>
		
			<?php
				$this->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$model,
					'attribute'=>'archivbol_vissza_datum',
					'options'=>array('dateFormat'=>'yy-mm-dd',)
				));
			?>
		
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
			<?php echo CHtml::submitButton('Mentés'); ?>
			<?php echo CHtml::button('Vissza', array('submit' => Yii::app()->request->urlReferrer)); ?>
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