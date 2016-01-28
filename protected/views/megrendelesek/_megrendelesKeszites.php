<?php
/* @var $this ArajanlatokController */
/* @var $model Arajanlatok */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'megrendeles-keszites-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'action' => $this->createUrl('megrendelesek/megrendelesEredmeny'),
)); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Megrendelés</strong>",
		));
	?>
		
		<?php
			echo CHtml::hiddenField('selected_tetel_list' , '', array('id' => 'selected_tetel_list'));
			echo CHtml::hiddenField('osszesTetelId' , '', array('id' => 'osszesTetelId'));
			echo CHtml::hiddenField('arajanlat_id' , $model->id, array('id' => 'hiddenInput')); 
		?>

		<div class="row">
			<?php echo $form->label($model->ugyfel,'cegnev'); ?>
			<?php echo $form->textField($model->ugyfel,'cegnev',array('style' => 'width:500px', 'readonly' =>true)); ?>
		</div>

		<div class="row">
			<?php echo $form->label($model->ugyfel,'display_ugyfel_cim'); ?>
			<?php echo $form->textField($model->ugyfel,'display_ugyfel_cim',array('style' => 'width:500px', 'readonly' =>true)); ?>
		</div>
		
		<h4> Megrendelni kívánt tételek kiválasztása </h4>
		<?php
			$criteria = new CDbCriteria;
			$criteria->compare('arajanlat_id', $model->id);
			
			$dataProvider=new CActiveDataProvider('ArajanlatTetelek',
				array( 'criteria' => $criteria,
					   'pagination' => array(
							'pageSize' => 100,
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

			// LI: elrakjuk egy hidden változóba az összes tétel id-ját, így ha az 'összes  kijelölése'
			//	   checkbox-ra nyom a felhasználó innen be tudjuk állítani az összes ID-t
			$osszesTetelIdJsTomb = '[';
			$osszesTetelIdPhpTomb = array();
			foreach (ArajanlatTetelek::model()->findAllByAttributes(array('arajanlat_id'=> $model->id)) as $tetel) {
				$osszesTetelIdJsTomb .= (strlen($osszesTetelIdJsTomb) > 1 ? ',' : '').$tetel->id;
				array_push($osszesTetelIdPhpTomb, $tetel->id);
			}
			$osszesTetelIdJsTomb .= ']';

			$_GET['ArajanlatTetelek_sel'] = $osszesTetelIdPhpTomb;
			
			$this->widget('ext.selgridview.SelGridView', array(
				'id' => 'arajanlatTetelekMegrendeles-grid',
				'dataProvider'=>$dataProvider,
				'selectableRows'=>2,
				'columns'=>array(
					array(
						'class'=>'CCheckBoxColumn',
						'htmlOptions'=>array(
							'style'=>'width:100px'
						),
					),
					'termek.nev',
					'darabszam:number',
					'netto_darabar:number',
					'NettoAr:number',
					'BruttoAr:number'
				)
			));
			
			// kirajuk egy JS változóba az ID-kat
			echo '<script>
					$(\'#osszesTetelId\').val (' . $osszesTetelIdJsTomb . ');

					// select all checkbox-ra hallgatózás
					$(document).on(\'click.yiiGridView\', \'#arajanlatTetelekMegrendeles-grid .select-all\', function (event) {
						$(\'#arajanlatTetelekMegrendeles-grid\').selGridView("clearAllSelection");
						$(\'#arajanlatTetelekMegrendeles-grid\').selGridView("addSelection", ' . $osszesTetelIdJsTomb . ');			
						$( ".select-all" ).prop(\'checked\', true);						
					});
					
					// deselect all checkbox-ra hallgatózás
					$(document).on(\'click.yiiGridView\', \'#arajanlatTetelekMegrendeles-grid  .deselect-all\', function (event) {
						$(\'#arajanlatTetelekMegrendeles-grid\').selGridView("clearAllSelection");
						$( ".deselect-all" ).prop(\'checked\', false);						
					});
					
					$(".select-all").prop("checked", true);
				</script>';
		?>
		
		<?php
			$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
				'id'=>'noItemsSelectedDialog',
				'options'=>array(
					'title'=>'Figyelmeztetés',
					'autoOpen'=>false,
					'modal'=>true,
					'buttons'=>array(
						'Ok'=>'js:function(){ $(this).dialog("close");}',
					),
				),
			));
		
				echo '<div class="dialog_input">A megrendelés elküldéséhez legalább 1 tétel kiválasztása szükséges!</div>';

			$this->endWidget('zii.widgets.jui.CJuiDialog');
		?>
		
		<div class="row buttons" style='text-align: center'>
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
					 array(
						'name'=>'anyagrendelesek_form_submit',
						'caption'=>'Megrendelés',
						'htmlOptions' => array ('class' => 'btn btn-primary btn-lg',),
						'onclick'=>new CJavaScriptExpression('function() {createMegrendelesWithSelectedTeteList(); return false;}')
					 )); ?>
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
					 array(
						'name'=>'back',
						'caption'=>'Kilépés',
						'htmlOptions' => array ('class' => 'btn btn-info btn-lg'),
						'onclick'=>new CJavaScriptExpression('function() {window.location = "http://www.domypress.hu/"; return false;}')
					 )); ?>
		</div>

	
	<?php $this->endWidget(); ?>
	
<?php $this->endWidget(); ?>

<script>
	function createMegrendelesWithSelectedTeteList () {
		var arraySel = $("#arajanlatTetelekMegrendeles-grid").selGridView("getAllSelection");
		
		if (arraySel.length == 0) {
			$('#noItemsSelectedDialog').dialog("open");
			
			return false;
		}
		
		$('#anyagrendelesek_form_submit').prop("disabled", true);
		$('#back').prop("disabled", true);
		
        var stringSel = arraySel.join(',');
		
        $('#selected_tetel_list').val (stringSel);
		$('#megrendeles-keszites-form').submit();
	}
</script>