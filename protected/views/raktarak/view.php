<?php
/* @var $this RaktarakController */
/* @var $model Raktarak */

$this->breadcrumbs=array(
	'Raktárak'=>array('index'),
	$model->id,
);

?>

<h1><?php echo $model->nev; ?> raktár adatai</h1>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'nev',
			'tipus',
			'leiras',
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
	// Raktárhelyek listázása
	if (Yii::app()->user->checkAccess('RaktarHelyek.View')) {
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Raktárhelyek</strong>",
		));
		
			$config = array();
			$dataProvider=new CActiveDataProvider('RaktarHelyek',
				array( 'data' => $model->raktarHelyek,
					   'criteria'=>array('order' => ' nev DESC',),
				)
			);

			$this->widget('zii.widgets.grid.CGridView', array(
				'id' => 'raktarHelyek-grid',
				'enablePagination' => false,
				'dataProvider'=>$dataProvider,
				'columns'=>array(
					'nev',
					'leiras',
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