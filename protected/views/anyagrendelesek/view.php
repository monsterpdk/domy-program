<?php
/* @var $this AnyagrendelesekController */
/* @var $model Anyagrendelesek */

$this->breadcrumbs=array(
	'Anyagrendelések'=>array('index'),
	$model->id,
);

?>

<h1><?php echo $model->id; ?> anyagrendelés adatai</h1>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'bizonylatszam',
			'gyarto.cegnev',
			'rendeles_datum',
			'megjegyzes',
			'user.username',
			'sztornozva:boolean',
			'lezarva:boolean',
		),
	)); ?>

<p>
	<?php $this->widget('zii.widgets.jui.CJuiButton', 
			 array(
				'name'=>'back',
				'caption'=>'Vissza',
				'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'submit' => Yii::app()->request->urlReferrer),
			 )); ?>
</p>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Megrendelt termékek</strong>",
	));
	
		$config = array();
		$dataProvider=new CActiveDataProvider('AnyagrendelesTermekek',
			array( 'data' => $model->termekek,
				   'criteria'=>array('order' => ' id DESC',),
			)
		);

		$this->widget('zii.widgets.grid.CGridView', array(
			'id' => 'anyagrendelesTermekek-grid',
			'dataProvider'=>$dataProvider,
			'enablePagination' => false,
			'columns'=>array(
				'termek.nev',
				'rendelt_darabszam',
				'rendeleskor_netto_darabar:number',
				array(
							'class' => 'bootstrap.widgets.TbButtonColumn',
							'htmlOptions'=>array('style'=>'width: 130px; text-align: center;'),
							'template' => '',
					),
			)
		));
	$this->endWidget();
?>

<?php
	$this->widget( 'application.modules.auditTrail.widgets.portlets.ShowAuditTrail', array( 'model' => $model, ) );
?>