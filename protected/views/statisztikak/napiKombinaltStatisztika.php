<?php
/* @var $this StatisztikaController */

$this->breadcrumbs=array(
	'Napi kombinált statisztika',
);

$this->menu=array(
	array('label'=>'Statisztika', 'url'=>array('admin')),
);
?>

<h1>Napi kombinált statisztika</h1>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route . "PrintPDF"),
	'method'=>'post',
)); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'htmlOptions'=>array('class'=>'well'),
		));
	?>
	
	<?php 
		echo $form->errorSummary($model); 
	?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'statisztika_mettol'); ?>
			
			<?php
				$this->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$model,
					'attribute'=>'statisztika_mettol',
					'language' => 'hu',
					'options'=>array('dateFormat'=>'yy-mm-dd',),
					'htmlOptions'=>array('style' => 'width:123px'),
				));			
			?>

		<?php echo $form->labelEx($model,'statisztika_meddig'); ?>
			
			<?php
				$this->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$model,
					'attribute'=>'statisztika_meddig',
					'language' => 'hu',
					'options'=>array('dateFormat'=>'yy-mm-dd',),
					'htmlOptions'=>array('style' => 'width:123px'),
				));			
			?>
			
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
				 array(
					'name'=>'submitForm',
					'caption'=>'Lekérés',
					'htmlOptions' => array ('class' => 'btn btn-primary btn-lg',),
				 )); ?>
			
	</div>
	
	<div class="clear"></div>

	<?php $this->endWidget(); ?>
	
<?php $this->endWidget(); ?>

</div>

