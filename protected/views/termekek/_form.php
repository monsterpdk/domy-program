<?php
/* @var $this TermekekController */
/* @var $model Termekek */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'termekek-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>"<strong>Termékadatok #1</strong>",
			));
		?>
		
		<div class="row">
			<?php echo $form->labelEx($model,'nev'); ?>
			<?php echo $form->textField($model,'nev',array('size'=>60,'maxlength'=>127)); ?>
			<?php echo $form->error($model,'nev'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'tipus'); ?>
			<?php echo DHtml::enumDropDownList($model, 'tipus'); ?>
			<?php echo $form->error($model,'tipus'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'kodszam'); ?>
			<?php echo $form->textField($model,'kodszam',array('size'=>15,'maxlength'=>15)); ?>
			<?php echo $form->error($model,'kodszam'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'cikkszam'); ?>
			<?php echo $form->textField($model,'cikkszam',array('size'=>30,'maxlength'=>30)); ?>
			<?php echo $form->error($model,'cikkszam'); ?>
		</div>
		
		
		<div class="row">
			<?php echo $form->labelEx($model,'meret_id'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'meret_id',
					CHtml::listData(TermekMeretek::model()->findAll(array("condition"=>"torolt=0")), 'id', 'nev')
				); ?>
				
			<?php echo $form->error($model,'meret_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'zaras_id'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'zaras_id',
					CHtml::listData(TermekZarasiModok::model()->findAll(array("condition"=>"torolt=0")), 'id', 'nev')
				); ?>
				
			<?php echo $form->error($model,'zaras_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'ablakmeret_id'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'ablakmeret_id',
					CHtml::listData(TermekAblakMeretek::model()->findAll(array("condition"=>"torolt=0")), 'id', 'nev')
				); ?>
				
			<?php echo $form->error($model,'ablakmeret_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'ablakhely_id'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'ablakhely_id',
					CHtml::listData(TermekAblakhelyek::model()->findAll(array("condition"=>"torolt=0")), 'id', 'nev')
				); ?>
				
			<?php echo $form->error($model,'ablakhely_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'papir_id'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'papir_id',
					CHtml::listData(PapirTipusok::model()->findAll(array("condition"=>"torolt=0")), 'id', 'FullName')
				); ?>
				
			<?php echo $form->error($model,'papir_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'afakulcs_id'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'afakulcs_id',
					CHtml::listData(AfaKulcsok::model()->findAll(array("condition"=>"torolt=0")), 'id', 'nev')
				); ?>
				
			<?php echo $form->error($model,'afakulcs_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'gyarto_id'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'gyarto_id',
					CHtml::listData(Gyartok::model()->findAll(array("condition"=>"torolt=0")), 'id', 'cegnev')
				); ?>
				
			<?php echo $form->error($model,'gyarto_id'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'suly'); ?>
			<?php echo $form->textField($model,'suly'); ?>
			<?php echo $form->error($model,'suly'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'redotalp'); ?>
			<?php echo $form->textField($model,'redotalp',array('size'=>50,'maxlength'=>50)); ?>
			<?php echo $form->error($model,'redotalp'); ?>
		</div>

		<div class="row active" style="width:214px;">
			<?php echo $form->checkBox($model,'belesnyomott'); ?>
			<?php echo $form->label($model,'belesnyomott'); ?>
			<?php echo $form->error($model,'belesnyomott'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'kategoria_tipus'); ?>
			<?php echo $form->textField($model,'kategoria_tipus',array('size'=>1,'maxlength'=>1)); ?>
			<?php echo $form->error($model,'kategoria_tipus'); ?>
		</div>

		
	<?php $this->endWidget(); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Termékadatok #2</strong>",
		));
	?>

		<div class="row">
			<?php echo $form->labelEx($model,'ksh_kod'); ?>
			<?php echo $form->textField($model,'ksh_kod',array('size'=>10,'maxlength'=>10)); ?>
			<?php echo $form->error($model,'ksh_kod'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'csom_egys'); ?>
			<?php echo $form->textField($model,'csom_egys',array('size'=>10,'maxlength'=>10)); ?>
			<?php echo $form->error($model,'csom_egys'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'minimum_raktarkeszlet'); ?>
			<?php echo $form->textField($model,'minimum_raktarkeszlet',array('size'=>10,'maxlength'=>10)); ?>
			<?php echo $form->error($model,'minimum_raktarkeszlet'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'maximum_raktarkeszlet'); ?>
			<?php echo $form->textField($model,'maximum_raktarkeszlet',array('size'=>10,'maxlength'=>10)); ?>
			<?php echo $form->error($model,'maximum_raktarkeszlet'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'doboz_suly'); ?>
			<?php echo $form->textField($model,'doboz_suly'); ?>
			<?php echo $form->error($model,'doboz_suly'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'raklap_db'); ?>
			<?php echo $form->textField($model,'raklap_db',array('size'=>10,'maxlength'=>10)); ?>
			<?php echo $form->error($model,'raklap_db'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'doboz_hossz'); ?>
			<?php echo $form->textField($model,'doboz_hossz'); ?>
			<?php echo $form->error($model,'doboz_hossz'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'doboz_szelesseg'); ?>
			<?php echo $form->textField($model,'doboz_szelesseg'); ?>
			<?php echo $form->error($model,'doboz_szelesseg'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'doboz_magassag'); ?>
			<?php echo $form->textField($model,'doboz_magassag'); ?>
			<?php echo $form->error($model,'doboz_magassag'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'megjegyzes'); ?>
			<?php echo $form->textArea($model,'megjegyzes',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'megjegyzes'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'megjelenes_mettol'); ?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$model,
						'attribute'=>'megjelenes_mettol',
						'options'=>array('dateFormat'=>'yy-mm-dd',)
					));
				?>
				
			<?php echo $form->error($model,'megjelenes_mettol'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'megjelenes_meddig'); ?>
			
				<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$model,
						'attribute'=>'megjelenes_meddig',
						'options'=>array('dateFormat'=>'yy-mm-dd',)
					));
				?>
			
			<?php echo $form->error($model,'megjelenes_meddig'); ?>
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
							'htmlOptions' => array ('class' => 'btn btn-primary btn-lg',),
						 )); ?>
				<?php $this->widget('zii.widgets.jui.CJuiButton', 
						 array(
							'name'=>'back',
							'caption'=>'Vissza',
							'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'submit' => Yii::app()->request->urlReferrer),
						 )); ?>
		</div>
		
	<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>

</div><!-- form -->