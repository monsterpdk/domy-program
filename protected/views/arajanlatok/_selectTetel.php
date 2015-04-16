<?php
/* @var $this ArajanlatokController */
/* @var $model Arajanlatok */
/* @var $form CActiveForm */
?>


	<?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
		array(
			'id'=>'dialogTetelSelect',
			
			'options'=>array(
				'title'=>'Válassza ki mely tételeket szeretné átvinni a megrendelőlapra',
				'width'=> '800px',
				'modal' => true,
				'buttons' => array('Ok' => 'js:function() { createMegrendelesWithSelectedTeteList ($(this).data("model_id"), $(this).data("grid_id"), $(this )); }', 'Mégse' => 'js:function() { $(this).dialog("close"); }'),
				'close'=>'js:function(){ $(this).dialog("destroy").remove(); }',
				'autoOpen'=>true,
		)));
	?>
	
		<?php
			$criteria = new CDbCriteria;
			$criteria->compare('arajanlat_id', $arajanlat_id);
			
			$dataProvider=new CActiveDataProvider('ArajanlatTetelek',
				array( 'criteria' => $criteria,
					   'pagination' => array(
							'pageSize' => 10,
						),
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

			$this->widget('ext.selgridview.SelGridView', array(
				'id' => 'arajanlatTetelek-grid' . $grid_id,
				'dataProvider'=>$dataProvider,
				'selectableRows'=>2,
				'columns'=>array(
					array(
						'class'=>'CCheckBoxColumn',
					),
					'termek.nev',
					'szinek_szama1',
					'szinek_szama2',
					'darabszam',
					'netto_darabar:number',
				)
			));
		?>
		
		<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>