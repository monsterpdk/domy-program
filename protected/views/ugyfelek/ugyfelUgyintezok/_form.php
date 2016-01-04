<?php
/* @var $this UgyfelUgyintezokController */
/* @var $model UgyfelUgyintezok */
?>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Ügyfélügyintéző adatai</strong>",
	));
?>

<div class="form">

    <div class="row" style="width:200px; margin-right:20px; float: left;">
        <?php echo CHtml::activeLabelEx($model, '[' . $index . ']nev'); ?>
        <?php echo CHtml::activeTextField($model, '[' . $index . ']nev', array('size'=>60,'maxlength'=>127)); ?>
        <?php echo CHtml::error($model, '[' . $index . ']nev'); ?>
    </div>
	
    <div class="row" style="width:200px; margin-right:20px; float: left;">
        <?php echo CHtml::activeLabelEx($model, '[' . $index . ']telefon'); ?>
		
		<?php $this->widget("ext.maskedInput.MaskedInput", array(
				"model" => $model,
				"attribute" => '[' . $index . ']telefon',
				"mask" => '(99) 99-999-9999'                
			));
		?>
		
        <?php echo CHtml::error($model, '[' . $index . ']telefon'); ?>
    </div>
	
    <div class="row" style="width:200px; margin-right:20px; float: left;">
        <?php echo CHtml::activeLabelEx($model, '[' . $index . ']email'); ?>
        <?php echo CHtml::activeTextField($model, '[' . $index . ']email', array('size'=>60,'maxlength'=>127)); ?>
        <?php echo CHtml::error($model, '[' . $index . ']email'); ?>
    </div>
    
	<div class="row" style="width:200px; margin-right:20px; float: left;">
        <?php echo CHtml::activeLabelEx($model, '[' . $index . ']alapertelmezett_kapcsolattarto'); ?>
		<?php echo CHtml::activeCheckBox($model, '[' . $index . ']alapertelmezett_kapcsolattarto', array('value' => "1")); ?>
		<?php echo CHtml::error($model,'[' . $index . ']alapertelmezett_kapcsolattarto'); ?>
	</div>    

	<div class="row" style="width:100px;float: left;">
        <br />
        <?php echo CHtml::link('Törlés', '#', array('class' => 'btn', 'onclick' => 'deleteUgyfelUgyintezo(this, ' . $index . '); return false;'));
        ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php
Yii::app()->clientScript->registerScript('deleteUgyfelUgyintezo', "
function deleteUgyfelUgyintezo(elm, index)
{
    element=$(elm).parent().parent();
    /* animate div */
    $(element).animate(
    {
        opacity: 0.25,
        left: '+=50',
        height: 'toggle'
    }, 500,
    function() {
        /* remove div */
        $(element).remove();
    });
}", CClientScript::POS_END);