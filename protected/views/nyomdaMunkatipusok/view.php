<?php
/* @var $this NyomdaMunkatipusokController */
/* @var $model NyomdaMunkatipusok */
?>

<h1> '<?php echo $model->munkatipus_nev; ?>' munkatipus adatai</h1>

<p>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'munkatipus_nev',
			'darabszam_tol',
			'darabszam_ig',
			'szinszam_tol',
			'szinszam_ig',
			array(
				'name' => 'torolt',
				'type'=>'boolean',
				'value' => $model->torolt,
				'visible' => Yii::app()->user->checkAccess('Admin'),
			),
		),
	)); ?>
</p>

<!-- Termékek listája -->
<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Termékek</strong>",
	));
	
		// GRIDVIEW BEGIN
			$config = array();
			$dataProviderTermekek=new CActiveDataProvider('NyomdaMunkatipusTermekek',
				array( 'data' => $model->termekek,
						'sort'=>array(
							'attributes'=>array(
								'id' => array(
									'asc' => 'id ASC',
									'desc' => 'id DESC',
								),
							),
						),
				)
			);

			$this->widget('zii.widgets.grid.CGridView', array(
				'id' => 'termekek-grid',
				'enablePagination' => false,
				'dataProvider'=>$dataProviderTermekek,
				'columns'=>array(
					'termek.nev',
					array(
								'class' => 'bootstrap.widgets.TbButtonColumn',
								'htmlOptions'=>array('style'=>'width: 130px; text-align: center;'),
								'template' => '',
								
								
								'buttons' => array(
									'class' => 'bootstrap.widgets.TbButtonColumn',
									'htmlOptions'=>array('style'=>'width: 130px; text-align: center;'),
									'template' => '',
								),
						),
				)
			));

	$this->endWidget();
?>

<!-- Műveletek listája -->
<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Műveletek</strong>",
	));
	
		// GRIDVIEW BEGIN
			$config = array();
			$dataProviderMuveletek=new CActiveDataProvider('NyomdaMunkatipusMuveletek',
				array( 'data' => $model->muveletek,
						'sort'=>array(
							'attributes'=>array(
								'id' => array(
									'asc' => 'id ASC',
									'desc' => 'id DESC',
								),
							),
						),
				)
			);

			$this->widget('zii.widgets.grid.CGridView', array(
				'id' => 'termekek-grid',
				'enablePagination' => false,
				'dataProvider'=>$dataProviderMuveletek,
				'columns'=>array(
					'muvelet.muvelet_nev',
					array(
								'class' => 'bootstrap.widgets.TbButtonColumn',
								'htmlOptions'=>array('style'=>'width: 130px; text-align: center;'),
								'template' => '',
								
								
								'buttons' => array(
									'class' => 'bootstrap.widgets.TbButtonColumn',
									'htmlOptions'=>array('style'=>'width: 130px; text-align: center;'),
									'template' => '',
								),
						),
				)
			));

	$this->endWidget();
?>

<p>
	<?php echo CHtml::button('Vissza', array('submit' => Yii::app()->request->urlReferrer)); ?>
</p>

<?php
	$this->widget( 'application.modules.auditTrail.widgets.portlets.ShowAuditTrail', array( 'model' => $model, ) );
?>