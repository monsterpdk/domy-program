<?php
/* @var $this NyomdagepekController */
/* @var $dataProvider CActiveDataProvider */
?>

<h1>Nyomdagépek</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'nyomdagepek-grid',
	'dataProvider'=>$dataProvider,
	'template' => '{items} {summary} {pager}',
	'columns'=>array(
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
								'visible' => "Yii::app()->user->checkAccess('Nyomdagepek.View')",
							),
							'update' => array(
								'label' => 'Szerkeszt',
								'icon'=>'icon-white icon-pencil',
								'visible' => "Yii::app()->user->checkAccess('Nyomdagepek.Update')",
							),
							'delete' => array(
								'label' => 'Töröl',
								'icon'=>'icon-white icon-remove-sign',
								'visible' => 'Yii::app()->user->checkAccess("Nyomdagepek.Delete") && $data->torolt != 1',
							)
						),
                ),
                'gepnev',
				'max_fordulat',
				'alapertelmezett:boolean',
				array(
						'header' => 'Törölt',
						'type'=>'boolean',
						'value' => '$data->torolt',
						'visible' => Yii::app()->user->checkAccess('Admin'),
				),
			)
)); ?>


<p>
	Alapértelmezett nyomdagép:
	<?php
		$data = CHtml::listData(Nyomdagepek::model()->findAll('torolt=?',array(0)), 'id', 'gepnev');
		$defaultNyomdagep = Nyomdagepek::model()->findByAttributes(array('alapertelmezett' => 1));
		$selected = ($defaultNyomdagep != null) ? $defaultNyomdagep -> id : "";
		 
		echo CHtml::dropDownList(
			'defaultNyomdagep',
			$selected,
			$data,       
			array(
				'style'=>'margin-bottom:10px;',
				'id'=>'defaultNyomdagep',
				'ajax' => array('type'=>'POST',
								'url'=>CController::createUrl('nyomdagepek/setDefaultNyomdagep'),
								'data'=> array('default_id' => 'js:this.value'),
								'success' => 'function(data){
									$.fn.yiiGridView.update("nyomdagepek-grid",{ complete: function(jqXHR, status) {}})
								}',
								),
			)
		);
	?>
	
</p>

<?php
	if (Yii::app()->user->checkAccess('Nyomdagepek.Create')) {
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_nyomdagep',
			'caption'=>'Új nyomdagép hozzáadása',
			'buttonType'=>'link',
			'htmlOptions'=>array('class'=>'btn btn-success'),
			'url'=>array('create'),
		));
	}
?>