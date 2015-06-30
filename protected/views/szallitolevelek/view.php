<?php
/* @var $this MegrendelesekController */
/* @var $model Megrendelesek */
?>

<h1>'<?php echo $model->sorszam; ?>' adatai</h1>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'sorszam',
			array(
				'name' => 'Megrendelés sorszáma',
				'header' => 'Megrendelés sorszáma',
				'value' => $model->megrendeles->sorszam,
			),
			'datum',
			'megjegyzes',
			'egyeb',
			'sztornozva:boolean',
			array(
				'name' => 'torolt',
				'type'=> 'boolean',
				'value' => $model->torolt,
				'visible' => Yii::app()->user->checkAccess('Admin'),
			),	),
	)); ?>
</p>

<p>
	<?php echo CHtml::button('Vissza', array('submit' => Yii::app()->request->urlReferrer)); ?>
</p>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Szállítólevél tételei</strong>",
	));
	
		$config = array();
		$dataProvider=new CActiveDataProvider('SzallitolevelTetelek',
			array( 'data' => $model->tetelek,
				   'criteria'=>array('order' => ' id DESC',),
			)
		);

		$this->widget('zii.widgets.grid.CGridView', array(
			'id' => 'szellitolevelTetelek-grid',
			'enablePagination' => false,
			'dataProvider'=>$dataProvider,
			'columns'=>array(
					'megrendeles_tetel.termek.nev',
					'darabszam',
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