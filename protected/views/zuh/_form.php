<?php
/* @var $this ZuhController */
/* @var $model Zuh */
/* @var $form CActiveForm */
?>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>ZUH adatai</strong>",
	));
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'zuh-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="clear">
		<div class="row">
			<?php echo $form->labelEx($model,'nyomasi_kategoria'); ?>
			<?php echo $form->textField($model,'nyomasi_kategoria',array('size'=>5,'maxlength'=>5)); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'db_tol'); ?>
			<?php echo $form->textField($model,'db_tol',array('size'=>10,'maxlength'=>9)); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'db_ig'); ?>
			<?php echo $form->textField($model,'db_ig',array('size'=>10,'maxlength'=>9)); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'aktiv'); ?>
			<?php echo $form->checkBox($model,'aktiv',array('disabled' => !Yii::app()->user->checkAccess('Zuh.AktivKapcsolo'))); ?>
			<?php echo $form->error($model,'aktiv'); ?>
		</div>
		
	</div>
	
	<div class="clear">
		<table class='table-zuh'>
			<tr>
				<td></td>
				<td>Egy szín</td>
				<td></td>
				<td>Két szín</td>
				<td></td>
				<td>Három szín</td>
				<td></td>
				<td>Több szín</td>
				<td></td>
			</tr>
			
			<tr>
				<td>Darabszám</td>
				<td> <?php echo $form->textField($model,'szin_1_db',array('size'=>6,'maxlength'=>6, 'style'=>'width:70px')); ?> </td>
				<td>db</td>
				<td> <?php echo $form->textField($model,'szin_2_db',array('size'=>6,'maxlength'=>6, 'style'=>'width:70px')); ?> </td>
				<td>db</td>
				<td> <?php echo $form->textField($model,'szin_3_db',array('size'=>6,'maxlength'=>6, 'style'=>'width:70px')); ?> </td>
				<td>db</td>
				<td> <?php echo $form->textField($model,'tobb_szin_db',array('size'=>6,'maxlength'=>6, 'style'=>'width:70px')); ?> </td>
				<td>db</td>
			</tr>
			
			<tr>
				<td>Százalék</td>
				<td> <?php echo $form->textField($model,'szin_1_szazalek',array('size'=>5,'maxlength'=>5, 'style'=>'width:70px')); ?> </td>
				<td>%</td>
				<td> <?php echo $form->textField($model,'szin_2_szazalek',array('size'=>5,'maxlength'=>5, 'style'=>'width:70px')); ?> </td>
				<td>%</td>
				<td> <?php echo $form->textField($model,'szin_3_szazalek',array('size'=>5,'maxlength'=>5, 'style'=>'width:70px')); ?> </td>
				<td>%</td>
				<td> <?php echo $form->textField($model,'tobb_szin_szazalek',array('size'=>5,'maxlength'=>5, 'style'=>'width:70px')); ?> </td>
				<td>%</td>
			</tr>
		</table>
		
	</div>
	
	<div class="clear">
		<div class="row">
			<?php echo $form->labelEx($model,'aruhaz_id'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'aruhaz_id',
					CHtml::listData(Aruhazak::model()->findAll(array("condition"=>"torolt=0")), 'id', 'display_aruhazkod_nev')
				); ?>
				
			<?php echo $form->error($model,'aruhaz_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'megjegyzes'); ?>
			<?php echo $form->textArea($model,'megjegyzes',array('size'=>60,'maxlength'=>127)); ?>
			<?php echo $form->error($model,'megjegyzes'); ?>
		</div>
	</div>
	
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

	<div class = 'clear'>
	</div>
	
<?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->endWidget(); ?>