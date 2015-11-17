<?php
/* @var $this AnyagbeszallitasokController */
/* @var $model Anyagbeszallitasok */

$this->breadcrumbs=array(
	'Anyagbeszállítások'=>array('index'),
	$model->id,
);

?>

<h1><?php echo $model->id; ?> anyagbeszálíltás adatai</h1>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'bizonylatszam',
			'gyarto.cegnev',
			'beszallitas_datum',
			'kifizetes_datum',
			'megjegyzes',
			'user.username',
			'anyagrendeles.displayBizonylatszamDatum',
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
	// Beszállított termékek (RAKTÁR)
	if (Yii::app()->user->checkAccess('AnyagbeszallitasTermekek.View')) {
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Beszállított termékek (raktár)</strong>",
		));
		
			$config = array();
			$dataProvider=new CActiveDataProvider('AnyagbeszallitasTermekek',
				array( 'data' => $model->termekek,
					   'criteria'=>array('order' => ' id DESC',),
				)
			);

			$this->widget('zii.widgets.grid.CGridView', array(
				'id' => 'anyagbeszallitasTermekek-grid',
				'enablePagination' => false,
				'dataProvider'=>$dataProvider,
				'columns'=>array(
					'termek.nev',
					'darabszam',
					'netto_darabar:number',
					array(
								'class' => 'bootstrap.widgets.TbButtonColumn',
								'htmlOptions'=>array('style'=>'width: 130px; text-align: center;'),
								'template' => '',
						),
				)
			));
		$this->endWidget();
	}
	
	// Beszállított termékek (IRODA)
	if (Yii::app()->user->checkAccess('AnyagbeszallitasTermekekIroda.View')) {
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Beszállított termékek (iroda)</strong>",
		));
		
			$config = array();
			$dataProvider=new CActiveDataProvider('AnyagbeszallitasTermekek',
				array( 'data' => $model->termekekIroda,
					   'criteria'=>array('order' => ' id DESC',),
				)
			);

			$this->widget('zii.widgets.grid.CGridView', array(
				'id' => 'anyagbeszallitasTermekekIroda-grid',
				'enablePagination' => false,
				'dataProvider'=>$dataProvider,
				'columns'=>array(
					'termek.nev',
					'darabszam',
					'netto_darabar:number',
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