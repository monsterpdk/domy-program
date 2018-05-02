<?php
// kezdő dátum értékek meghatározása: 'aktuális dátum - 1 év'   -   'aktuális dátum'
$now = new DateTime('now');

$statisztika_mettol = $now -> modify('-1 year') -> format('Y-m-d');
$statisztika_meddig = date('Y-m-d');

?>

<h1>Utókalkuláció statisztika</h1>

<div class="wide form">

    <?php $form=$this->beginWidget('CActiveForm', array(
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

        <?php echo $form->labelEx($model,'megrendeles_tipus'); ?>

        <?php
            echo CHtml::radioButton('megrendeles_tipus', true, array(
            'value'=>'eladas',
            'name'=>'megrendeles_tipus',
            'uncheckValue'=>null
            )). " Eladás <br />" ;

            echo CHtml::radioButton('megrendeles_tipus', false, array(
            'value'=>'nyomas',
            'name'=>'megrendeles_tipus',
            'uncheckValue'=>null
            )). " Nyomás <br /><br />" ;
        ?>

        <?php echo $form->labelEx($model, 'statisztika_mettol'); ?>

        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model'=>$model,
            'attribute'=>'statisztika_mettol',
            'language' => 'hu',
            'options'=>array('dateFormat'=>'yy-mm-dd',),
            'htmlOptions'=>array('style' => 'width:123px', 'value' => $statisztika_mettol),
        ));
        ?>

        <?php echo $form->labelEx($model, 'statisztika_meddig'); ?>

        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model'=>$model,
            'attribute'=>'statisztika_meddig',
            'language' => 'hu',
            'options'=>array('dateFormat'=>'yy-mm-dd',),
            'htmlOptions'=>array('style' => 'width:123px', 'value' => $statisztika_meddig),
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

