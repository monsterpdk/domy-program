<?php
/* @var $this ArajanlatokController */
/* @var $model Arajanlatok */
/* @var $form CActiveForm */
?>

	<input type='hidden' id='osszesTetelId' name='osszesTetelId' />

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
					'egyedi_ar:boolean',
					'hozott_boritek:boolean',
					'netto_darabar:number',
				)
			));
			
			// LI: elrakjuk egy hidden változóba az összes tétel id-ját, így ha az 'összes  kijelölése'
			//	   checkbox-ra nyom a felhasználó innen be tudjuk állítani az összes ID-t
			$osszesTetelIdJsTomb = '[';
			foreach (ArajanlatTetelek::model()->findAllByAttributes(array('arajanlat_id'=> $model->id)) as $tetel) {
				$osszesTetelIdJsTomb .= (strlen($osszesTetelIdJsTomb) > 1 ? ',' : '').$tetel->id;
			}
			$osszesTetelIdJsTomb .= ']';

			// kirajuk egy JS változóba az ID-kat
			echo '<script>
					$(\'#osszesTetelId\').val (' . $osszesTetelIdJsTomb . ');

					// select all checkbox-ra hallgatózás
					$(document).on(\'click.yiiGridView\', \'#arajanlatTetelek-grid' . $grid_id. ' .select-all\', function (event) {
						$(\'#arajanlatTetelek-grid' . $grid_id . '\').selGridView("clearAllSelection");
						$(\'#arajanlatTetelek-grid' . $grid_id . '\').selGridView("addSelection", ' . $osszesTetelIdJsTomb . ');
						$( ".select-all" ).prop(\'checked\', true);			
					});
					
					// deselect all checkbox-ra hallgatózás
					$(document).on(\'click.yiiGridView\', \'#arajanlatTetelek-grid' . $grid_id. ' .deselect-all\', function (event) {
						$(\'#arajanlatTetelek-grid' . $grid_id . '\').selGridView("clearAllSelection");
						$( ".deselect-all" ).prop(\'checked\', false);						
					});
					
					$(".select-all").prop("checked", true);

					$( document ).ready(function() {
						$("input.select-all").each(function(){
							$(this).prop( "checked", true );
						});
					});
			  </script>
			';
		?>

		<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>