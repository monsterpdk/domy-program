
<?php
/* @var $this AfaKulcsokController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'ÁFA kulcsok',
);

?>

<h1>ÁFA kulcsok</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'afakulcsok-grid',
	'dataProvider'=>$dataProvider,
	'template' => '{items} {summary} {pager}',
	'columns'=>array(
                'nev',
				'afa_szazalek',
				'alapertelmezett:boolean',
				array(
						'header' => 'Törölt',
						'type'=>'boolean',
						'value' => '$data->torolt',
						'visible' => Yii::app()->user->checkAccess('Admin'),
				),
				array(
                        'class' => 'bootstrap.widgets.TbButtonColumn',
						'htmlOptions'=>array('style'=>'width: 130px; text-align: left;'),
                        'template' => '{view} {update} {delete}',
						
			            'viewButtonOptions'=>array('class'=>'btn btn-warning btn-mini'),
						'updateButtonOptions'=>array('class'=>'btn btn-success btn-mini'),
						'deleteButtonOptions'=>array('class'=>'btn btn-danger btn-mini'),

						'buttons' => array(
							'view' => array(
								'label' => 'Megtekint',
								'icon'=>'icon-white icon-eye-open',
								'visible' => "Yii::app()->user->checkAccess('AfaKulcsok.View')",
							),
							'update' => array(
								'label' => 'Szerkeszt',
								'icon'=>'icon-white icon-pencil',
								'visible' => "Yii::app()->user->checkAccess('AfaKulcsok.Update')",
							),
							'delete' => array(
								'label' => 'Töröl',
								'icon'=>'icon-white icon-remove-sign',
								'visible' => 'Yii::app()->user->checkAccess("AfaKulcsok.Delete") && $data->torolt != 1',
							)
						),
                ),
			)
)); ?>


<p>
	Alapértelmezett ÁFA kulcs:
	<?php
		$data = CHtml::listData(AfaKulcsok::model()->findAll('torolt=?',array(0)), 'id', 'nev');
		$defaultAfaKulcs = AfaKulcsok::model()->findByAttributes(array('alapertelmezett' => 1));
		$selected = ($defaultAfaKulcs != null) ? $defaultAfaKulcs -> id : "";
		 
		echo CHtml::dropDownList(
			'defaultAFA',
			$selected,
			$data,       
			array(
				'style'=>'margin-bottom:10px;',
				'id'=>'defaultAFA',
				'ajax' => array('type'=>'POST',
								'url'=>CController::createUrl('afakulcsok/setDefaultAFA'),
								'data'=> array('default_id' => 'js:this.value'),
								'success' => 'function(data){
									$.fn.yiiGridView.update("afakulcsok-grid",{ complete: function(jqXHR, status) {}})
								}',
								),
			)
		);
	?>
	
</p>

<?php
	if (Yii::app()->user->checkAccess('AfaKulcsok.Create')) {
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_afakulcs',
			'caption'=>'Új ÁFA kulcs hozzáadása',
			'buttonType'=>'link',
			'htmlOptions'=>array('class'=>'btn btn-success'),
			'url'=>array('create'),
		));
	}
?>