<?php
/* @var $this TermekArakController */
/* @var $model TermekArak */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'termek-arak-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Csomag adatai</strong>",
		));
	?>
	
		<div class="row">
			<?php echo $form->labelEx($model,'termek_id'); ?>
			<?php //echo $form->textField($model,'termek_id',array('size'=>10,'maxlength'=>10)); ?>
			
			<?php echo CHtml::activeDropDownList($model, 'termek_id',
				CHtml::listData(Termekek::model()->findAll(array("condition"=>"torolt=0")), 'id', 'displayTermeknev')
			); ?>
			
			<?php echo $form->error($model,'termek_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'csomag_beszerzesi_ar'); ?>
			<?php echo $form->textField($model,'csomag_beszerzesi_ar'); ?>
			<?php echo $form->error($model,'csomag_beszerzesi_ar'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'csomag_ar_szamolashoz'); ?>
			<?php echo $form->textField($model,'csomag_ar_szamolashoz'); ?>
			<?php echo $form->error($model,'csomag_ar_szamolashoz'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'csomag_ar_nyomashoz'); ?>
			<?php echo $form->textField($model,'csomag_ar_nyomashoz'); ?>
			<?php echo $form->error($model,'csomag_ar_nyomashoz'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'csomag_eladasi_ar'); ?>
			<?php echo $form->textField($model,'csomag_eladasi_ar'); ?>
			<?php echo $form->error($model,'csomag_eladasi_ar'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'csomag_ar2'); ?>
			<?php echo $form->textField($model,'csomag_ar2'); ?>
			<?php echo $form->error($model,'csomag_ar2'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'csomag_ar3'); ?>
			<?php echo $form->textField($model,'csomag_ar3'); ?>
			<?php echo $form->error($model,'csomag_ar3'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'db_beszerzesi_ar'); ?>
			<?php echo $form->textField($model,'db_beszerzesi_ar'); ?>
			<?php echo $form->error($model,'db_beszerzesi_ar'); ?>
		</div>

	<?php $this->endWidget(); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Mennyiségi adatok</strong>",
		));
	?>
	
		<div class="row">
			<?php echo $form->labelEx($model,'db_ar_nyomashoz'); ?>
			<?php echo $form->textField($model,'db_ar_nyomashoz'); ?>
			<?php echo $form->error($model,'db_ar_nyomashoz'); ?>
		</div>


		<div class="row">
			<?php echo $form->labelEx($model,'db_eladasi_ar'); ?>
			<?php echo $form->textField($model,'db_eladasi_ar'); ?>
			<?php echo $form->error($model,'db_eladasi_ar'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'db_ar2'); ?>
			<?php echo $form->textField($model,'db_ar2'); ?>
			<?php echo $form->error($model,'db_ar2'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'db_ar3'); ?>
			<?php echo $form->textField($model,'db_ar3'); ?>
			<?php echo $form->error($model,'db_ar3'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'datum_mettol'); ?>
			
			<?php
				$this->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$model,
					'attribute'=>'datum_mettol',
					'options'=>array('dateFormat'=>'yy-mm-dd',)
				));
			?>
			
			<?php echo $form->error($model,'datum_mettol'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'datum_meddig'); ?>
			
			<?php
				$this->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$model,
					'attribute'=>'datum_meddig',
					'options'=>array('dateFormat'=>'yy-mm-dd',)
				));
			?>
			
			<?php echo $form->error($model,'datum_meddig'); ?>
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

<?php $this->endWidget(); ?>

</div><!-- form -->