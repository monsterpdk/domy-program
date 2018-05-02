<?php
/* @var $this SzallitoCegekController */
/* @var $model SzallitoCegek */

$this->breadcrumbs=array(
	'Szállító cégek'=>array('index'),
	$model->id,
);

?>

<h1><?php echo $model->nev; ?> szállító cég adatai</h1>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'nev',
			array(
				'name' => 'torolt',
				'type'=>'boolean',
				'value' => $model->torolt,
				'visible' => Yii::app()->user->checkAccess('Admin'),
			),
		),
	)); ?>
</p>

<p>
	<?php $this->widget('zii.widgets.jui.CJuiButton', 
			 array(
				'name'=>'back',
				'caption'=>'Vissza',
				'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'submit' => Yii::app()->request->urlReferrer),
			 )); ?>
</p>

<?php
	// Szállító cégek listázása
	if (Yii::app()->user->checkAccess('SzallitoCegek.View')) {
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Szállító cégek</strong>",
		));
		
			$config = array();
			$dataProvider=new CActiveDataProvider('SzallitoCegek',
				array( 'data' => $model->raktarHelyek,
					   'criteria'=>array('order' => ' nev DESC',),
				)
			);

			$this->widget('zii.widgets.grid.CGridView', array(
				'id' => 'szallitoCegek-grid',
				'enablePagination' => false,
				'dataProvider'=>$dataProvider,
				'columns'=>array(
					'nev',
					array(
								'class' => 'bootstrap.widgets.TbButtonColumn',
								'htmlOptions'=>array('style'=>'width: 130px; text-align: center;'),
								'template' => '',
						),
				)
			));
		$this->endWidget();
	}
?>

<?php
	$this->widget( 'application.modules.auditTrail.widgets.portlets.ShowAuditTrail', array( 'model' => $model, ) );
?>