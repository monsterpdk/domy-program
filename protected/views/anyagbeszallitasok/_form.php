<?php
/* @var $this AnyagbeszallitasokController */
/* @var $model Anyagbeszallitasok */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'anyagbeszallitasok-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Anyagbeszállítás adatai</strong>",
		));
	?>
		
		<?php echo $form->errorSummary($model); ?>

		<?php echo $form->hiddenField($model, 'id'); ?>
		<?php echo $form->hiddenField($model, 'user_id'); ?>

		<?php echo CHtml::hiddenField('raktar_id' , '', array('id' => 'raktar_id')); ?>
		
		<?php if (!$model->gyarto_id == null): ?>
			<?php echo $form->hiddenField($model, 'gyarto_id'); ?>
		<?php endif; ?>
		
		<?php if (!$model->anyagrendeles_id == null): ?>
			<?php echo $form->hiddenField($model, 'anyagrendeles_id'); ?>
		<?php endif; ?>
		
		<div class="row">
			<?php echo $form->labelEx($model,'gyarto_id'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'gyarto_id',
					CHtml::listData(Gyartok::model()->findAll(array("condition"=>"torolt=0")), 'id', 'cegnev'),
					array('disabled'=>(!$model->gyarto_id == null))
				); ?>
				
			<?php echo $form->error($model,'gyarto_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'anyagrendeles_id'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'anyagrendeles_id',
					($model->lezarva != 1) ? CHtml::listData(Anyagrendelesek::model()->findAll(array("condition"=>"lezarva=0")), 'id', 'displayBizonylatszamDatum') : CHtml::listData(Anyagrendelesek::model()->findAll(), 'id', 'displayBizonylatszamDatum'),
					array('empty'=>'', 'disabled'=>(!$model->anyagrendeles_id == null))
				); ?>
				
			<?php echo $form->error($model,'anyagrendeles_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'bizonylatszam'); ?>
			<?php echo $form->textField($model,'bizonylatszam',array('size'=>10,'maxlength'=>10)); ?>
			<?php echo $form->error($model,'bizonylatszam'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'beszallitas_datum'); ?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$model,
						'attribute'=>'beszallitas_datum',
						'options'=>array('dateFormat'=>'yy-mm-dd',)
					));
				?>
				
			<?php echo $form->error($model,'beszallitas_datum'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'kifizetes_datum'); ?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$model,
						'attribute'=>'kifizetes_datum',
						'options'=>array('dateFormat'=>'yy-mm-dd',)
					));
				?>
				
			<?php echo $form->error($model,'kifizetes_datum'); ?>
		</div>	

		<div class="row">
			<?php echo $form->labelEx($model,'displayOsszertek'); ?>
			<?php echo $form->textField($model,'displayOsszertek',array('size'=>10,'maxlength'=>8, 'readOnly'=>true)); ?>
			<?php echo $form->error($model,'displayOsszertek'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'megjegyzes'); ?>
			<?php echo $form->textArea($model,'megjegyzes',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'megjegyzes'); ?>
		</div>

		<?php if (Yii::app()->user->checkAccess('Admin')): ?>
			<div class="row active">
				<?php echo $form->checkBox($model,'lezarva'); ?>
				<?php echo $form->label($model,'lezarva'); ?>
				<?php echo $form->error($model,'lezarva'); ?>
			</div>
		<?php endif; ?>	
		
		<div class="row buttons">
			<?php echo CHtml::submitButton('Mentés', array('id' => 'anyagbeszallitasok_form_submit')); ?>
			<?php echo CHtml::button('Vissza', array('submit' => Yii::app()->request->urlReferrer)); ?>
		
			<?php
				if (Yii::app()->user->checkAccess("Anyagbeszallitasok.CreateAnyagrendeles") && $model->anyagrendeles_id != null && $model->anyagrendeles_id == 0) {
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_create_anyagrendeles',
						'caption'=>'Anyagrendelés létrehozása',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  $("#anyagbeszallitasok-form").submit(); }'),
						'htmlOptions'=>array('class' => 'bt btn-primary search-button', 'style' => 'margin-left:20px', 'target' => '_blank'),
						'url'=>array('anyagrendelesek/createFromBeszallitas/anyagbeszallitas_id/' . $model -> id),
					));
				}
			?>
		</div>
	<?php $this->endWidget(); ?>


<!-- Beszállított termékek listája (RAKTÁR)-->

<?php
if (Yii::app()->user->checkAccess('AnyagbeszallitasTermekek.View'))
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Beszállított termékek (raktár)</strong>",
	));

	if (Yii::app()->user->checkAccess('AnyagbeszallitasTermekek.Create')) {
		
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_anyagbeszallitasTermek',
			'caption'=>'Termék hozzáadása',
			'buttonType'=>'link',
			'onclick'=>new CJavaScriptExpression('function() {addUpdateAnyagbeszallitasTermek("create", $(this));}'),
			'htmlOptions'=>array('class'=>'btn btn-success'),
		));
	}
	
	// a dialógus ablak inicializálása
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id'=>'dialogAnyagbeszallitasTermek',
		'options'=>array(
			'title'=>'Termék hozzáadása',
			'autoOpen'=>false,
			'modal'=>true,
			'width'=>550,
			'height'=>470,
		),
	));?>
	<div class="divForForm"></div>
	 
	<?php $this->endWidget();?>
	 
	<script type="text/javascript">
	
		function addUpdateAnyagbeszallitasTermek(createOrUpdate, buttonObj)
		{
		
			redirectUrl = "";
			try {
				redirectUrl = createOrUpdate.target.action;
			} catch (e) {
				redirectUrl = "";
			}
			
			try {
				$('#termek_dialog').dialog('destroy');
			} catch(err) {}

			if (typeof buttonObj != 'undefined')
				hrefString = buttonObj.parent().children().eq(1).attr('href');
				
			isUpdate = createOrUpdate == "update" || (typeof redirectUrl != 'undefined' && redirectUrl != '' && redirectUrl.indexOf("update") != -1);
			op = (isUpdate) ? "update" : "create";
			id = (isUpdate) ? hrefString.substr(hrefString.lastIndexOf("/") + 1) : $("#Anyagbeszallitasok_id").val();
			dialog_title = (isUpdate) ? "Termék módosítása" : "Termék hozzáadása";
			
			<?php echo CHtml::ajax(array(
					'url'=> "js:'/index.php/AnyagbeszallitasTermekek/' + op + '/id/' + id + '/gyarto_id/' + $('select[id=\"Anyagbeszallitasok_gyarto_id\"]').val() + '/anyagrendeles_id/' + $('select[id=\"Anyagbeszallitasok_anyagrendeles_id\"]').val() + '/bizonylatszam/' + $(\"#Anyagbeszallitasok_bizonylatszam\").val()+ '/grid_id/' + new Date().getTime()",
					'data'=> "js:$(this).serialize()",
					'type'=>'post',
					'id' => 'send-link-'.uniqid(),
					'replace' => '#termek_dialog',
					'dataType'=>'json',
					'success'=>"function(data)
					{
						if (data.status == 'failure')
						{
							$('#dialogAnyagbeszallitasTermek div.divForForm').html(data.div);
							$('#dialogAnyagbeszallitasTermek div.divForForm form').submit(addUpdateAnyagbeszallitasTermek);
						}
						else
						{
							$.fn.yiiGridView.update(\"AnyagbeszallitasTermekek-grid\",{ complete: function(jqXHR, status) {}})
							
							$('#dialogAnyagbeszallitasTermek div.divForForm').html(data.div);
							$('#dialogAnyagbeszallitasTermek').dialog('close');
						}
		 
					} ",
			))?>;
			
			$("#dialogAnyagbeszallitasTermek").dialog("open");
			$("#dialogAnyagbeszallitasTermek").dialog('option', 'title', dialog_title);
			
			return false; 
		}
	 
	</script>

	<?php
		if (Yii::app()->user->checkAccess('AnyagbeszallitasTermekek.View')) {
			$config = array();
			$dataProvider=new CActiveDataProvider('AnyagbeszallitasTermekek',
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
				'id' => 'AnyagbeszallitasTermekek-grid',
				'dataProvider'=>$dataProvider,
				'enablePagination' => false,
				'afterAjaxUpdate'=>'function(id,data){
					refreshOsszertek ();
				}',
				'columns'=>array(
					'termek.nev',
					'darabszam',
					'netto_darabar',
					array(
								'class' => 'bootstrap.widgets.TbButtonColumn',
								'htmlOptions'=>array('style'=>'width: 130px; text-align: center;'),
								'template' => '{update} {delete}',
								
								'updateButtonOptions'=>array('class'=>'btn btn-success btn-mini'),
								'deleteButtonOptions'=>array('class'=>'btn btn-danger btn-mini'),
								
								'buttons' => array(
									'update' => array(
										'label' => 'Szerkeszt',
										'icon'=>'icon-white icon-pencil',
										'url'=>'',
										'click'=>'function() {addUpdateAnyagbeszallitasTermek("update", $(this));}',
										'visible' => "Yii::app()->user->checkAccess('AnyagbeszallitasTermekek.Update')",
									),
									'delete' => array(
										'label' => 'Töröl',
										'icon'=>'icon-white icon-remove-sign',
										'url'=>'Yii::app()->createUrl("/AnyagbeszallitasTermekek/delete", array("id"=>$data["id"]))',
										'visible' => "Yii::app()->user->checkAccess('AnyagbeszallitasTermekek.Delete')",
									),
								),
						),
				)
			));
			
			$this->endWidget();
		}
	?>

<!-- Beszállított termékek listája (IRODA) -->
<?php

if (Yii::app()->user->checkAccess('AnyagbeszallitasTermekekIroda.View'))
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Beszállított termékek (iroda)</strong>",
	));

	if (Yii::app()->user->checkAccess('AnyagbeszallitasTermekekIroda.Create')) {
		
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_anyagbeszallitasTermekIroda',
			'caption'=>'Termék hozzáadása',
			'buttonType'=>'link',
			'onclick'=>new CJavaScriptExpression('function() {addUpdateAnyagbeszallitasTermekIroda("create", $(this));}'),
			'htmlOptions'=>array('class'=>'btn btn-success'),
		));
	}
	
	// a dialógus ablak inicializálása
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id'=>'dialogAnyagbeszallitasTermekIroda',
		'options'=>array(
			'title'=>'Termék hozzáadása',
			'autoOpen'=>false,
			'modal'=>true,
			'width'=>550,
			'height'=>470,
		),
	));?>
	<div class="divForForm"></div>
	 
	<?php $this->endWidget();?>
	 
	<script type="text/javascript">
	
		function addUpdateAnyagbeszallitasTermekIroda(createOrUpdate, buttonObj)
		{
		
			redirectUrl = "";
			try {
				redirectUrl = createOrUpdate.target.action;
			} catch (e) {
				redirectUrl = "";
			}
			
			try {
				$('#termek_dialog').dialog('destroy');
			} catch(err) {}

			if (typeof buttonObj != 'undefined')
				hrefString = buttonObj.parent().children().eq(1).attr('href');
				
			isUpdate = createOrUpdate == "update" || (typeof redirectUrl != 'undefined' && redirectUrl != '' && redirectUrl.indexOf("update") != -1);
			op = (isUpdate) ? "update" : "create";
			id = (isUpdate) ? hrefString.substr(hrefString.lastIndexOf("/") + 1) : $("#Anyagbeszallitasok_id").val();
			dialog_title = (isUpdate) ? "Termék módosítása" : "Termék hozzáadása";
			
			<?php echo CHtml::ajax(array(
					'url'=> "js:'/index.php/AnyagbeszallitasTermekekIroda/' + op + '/id/' + id + '/gyarto_id/' + $('select[id=\"Anyagbeszallitasok_gyarto_id\"]').val() + '/anyagrendeles_id/' + $('select[id=\"Anyagbeszallitasok_anyagrendeles_id\"]').val() + '/bizonylatszam/' + $(\"#Anyagbeszallitasok_bizonylatszam\").val()+ '/grid_id/' + new Date().getTime()",
					'data'=> "js:$(this).serialize()",
					'type'=>'post',
					'id' => 'send-link-'.uniqid(),
					'replace' => '#termek_dialog',
					'dataType'=>'json',
					'success'=>"function(data)
					{
						if (data.status == 'failure')
						{
							$('#dialogAnyagbeszallitasTermekIroda div.divForForm').html(data.div);
							$('#dialogAnyagbeszallitasTermekIroda div.divForForm form').submit(addUpdateAnyagbeszallitasTermekIroda);
						}
						else
						{
							$.fn.yiiGridView.update(\"AnyagbeszallitasTermekekIroda-grid\",{ complete: function(jqXHR, status) {}})
							
							$('#dialogAnyagbeszallitasTermekIroda div.divForForm').html(data.div);
							$('#dialogAnyagbeszallitasTermekIroda').dialog('close');
						}
		 
					} ",
			))?>;
			
			$("#dialogAnyagbeszallitasTermekIroda").dialog("open");
			$("#dialogAnyagbeszallitasTermekIroda").dialog('option', 'title', dialog_title);
			
			return false; 
		}
	 
	</script>

	<?php
		if (Yii::app()->user->checkAccess('AnyagbeszallitasTermekekIroda.View')) {
			$config = array();
			$dataProvider=new CActiveDataProvider('AnyagbeszallitasTermekek',
				array( 'data' => $model->termekekIroda,
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
				'id' => 'AnyagbeszallitasTermekekIroda-grid',
				'dataProvider'=>$dataProvider,
				'enablePagination' => false,
				'afterAjaxUpdate'=>'function(id,data){
					refreshOsszertek ();
				}',
				'columns'=>array(
					'termek.nev',
					'darabszam',
					'netto_darabar',
					array(
								'class' => 'bootstrap.widgets.TbButtonColumn',
								'htmlOptions'=>array('style'=>'width: 130px; text-align: center;'),
								'template' => '{update} {delete}',
								
								'updateButtonOptions'=>array('class'=>'btn btn-success btn-mini'),
								'deleteButtonOptions'=>array('class'=>'btn btn-danger btn-mini'),
								
								'buttons' => array(
									'update' => array(
										'label' => 'Szerkeszt',
										'icon'=>'icon-white icon-pencil',
										'url'=>'',
										'click'=>'function() {addUpdateAnyagbeszallitasTermekIroda("update", $(this));}',
										'visible' => "Yii::app()->user->checkAccess('AnyagbeszallitasTermekekIroda.Update')",
									),
									'delete' => array(
										'label' => 'Töröl',
										'icon'=>'icon-white icon-remove-sign',
										'url'=>'Yii::app()->createUrl("/AnyagbeszallitasTermekekIroda/delete", array("id"=>$data["id"]))',
										'visible' => "Yii::app()->user->checkAccess('AnyagbeszallitasTermekekIroda.Delete')",
									),
								),
						),
				)
			));
			
			$this->endWidget();
		}
	?>	

</div><!-- form -->

<?php $this->endWidget(); ?>

<?php if ((Yii::app()->user->checkAccess('AnyagbeszallitasTermekek.Create') || Yii::app()->user->checkAccess('Admin')) && $model -> lezarva != 1): ?>
	<!-- A form elküldése előtt leellenőrzöm a rendelt és beérkezett darabszámok egyezését. Ha eltérést találok figyelmeztetem a felhasználót. -->
	<!-- Csak akkor vizsgáljuk, ha a user ADMIN, vagy raktáros, aki az anyagbeszállítást veszi fel. Aki az anyagrendeléseket kezeli, ott nem ellenőrzünk. -->
	<script>
		$(document).ready(function() {
			$('#anyagbeszallitasok_form_submit').click(function(ev) {
				anyagrendeles_js_value = $("#Anyagbeszallitasok_anyagrendeles_id").val();

				// ha nincs kitöltve az anyagrendelés nem csinálunk raktárellenőrzést, nem zavarjuk vele a felhasználót, de
				// ha hozzárendelte már az anyagbeszállítást egy anyagrendeléshez, akkor ellenőrzünk
				
				if (anyagrendeles_js_value != "") {
					ev.preventDefault();

					$.ajax({
						type: 'GET',
						dataType: 'JSON',
						url: '<?php echo Yii::app()->createUrl("anyagbeszallitasok/checkProductDifference") . "/anyagbeszallitas_id/" . $model->id . "/anyagrendeles_id/"; ?>' + anyagrendeles_js_value,
						success:function(data){
							if (data !==  null) {
								// a tételek ellenőrzés során eltérést találtunk
								if (data != "") {
									$('#dialogUnSuccesfullCheck').html(data);
									$('#dialogUnSuccesfullCheck').dialog('open');
								} else if (data == "") {
									// a tételek ellenőrzés során megegyeztek a tételek az anyagrendelés és beszállítás során, lezárható
									// az anyagbeszállításhoz tartozó anyagrendelés
									
									if ( $('#dialogSuccesfullCheck').html().indexOf('a rendszerben') == -1 ) {
										$('#dialogSuccesfullCheck').html('Az anyagbeszállításhoz található megrendelés a rendszerben. Mentést követően lezárásra kerül az anyagrendelés és az anyagbeszállítás, a tételek pedig a kiválasztott raktárba kerülnek. <br /><br /> Raktár kiválasztása: <br /><br />' + $('#dialogSuccesfullCheck').html());
									}
									
									$('#dialogSuccesfullCheck').dialog('open');
								}
							}
						},
						error: function() {
							$('#dialogShowError').html('Lejárt a munkamenet. Jelentkezzen be újra!');
							$('#dialogShowError').dialog('open');
						},
					});

					return false;
				}
			});
		});
	</script>
	
	<?php
	// sikeres raktárellenőrzés után feljövő dialog
		$this->beginWidget('zii.widgets.jui.CJuiDialog',
			array(
				'id'=>'dialogSuccesfullCheck',
				
				'options'=>array(
					'title'=>'Megerősítés',
					'width'=>'450px',
					'modal' => true,
					'buttons' => array(
						'Mentés, lezárás és elhelyezés'=>'js:function(){$(this).dialog("close");  $("#raktar_id").val( $("#raktar").val()); $("#anyagbeszallitasok-form").submit();}',
						'Mégse'=>'js:function(){ $(this).dialog("close" );}',),
					'autoOpen'=>false,
			)));
			
			$list = CHtml::listData(Raktarak::model()->findAll(array("condition"=>"torolt=0")), 'id', 'nev');
			echo CHtml::dropDownList('raktar', '', $list, array());
			
			$this->endWidget();
			
	// sikertelen raktárellenőrzés után feljövő dialog
		$this->beginWidget('zii.widgets.jui.CJuiDialog',
			array(
				'id'=>'dialogUnSuccesfullCheck',
				
				'options'=>array(
					'title'=>'Információ',
					'width'=>'400px',
					'modal' => true,
					'buttons' => array(
						'Mentés mégis'=>'js:function(){ $(this).dialog("close"); $("#anyagbeszallitasok-form").submit(); }',
						'Mégse'=>'js:function(){ $(this).dialog("close"); }',),
					'autoOpen'=>false,
			)));
			
			$this->endWidget();			
			
	// hibaüzenet megjelenítéséhez használt dialog
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogShowError',
            
            'options'=>array(
                'title'=>'Hiba',
                'modal' => true,
                'buttons' => array(
                    'Ok'=>'js:function(){}',
                    'Cancel'=>'js:function(){$(\'dialogShowInformation\').dialog(\'close\')}',),
                'autoOpen'=>false,
        )));
		
		$this->endWidget();			
    ?>
<?php endif; ?>

<script>
	function refreshOsszertek () {
		$.ajax({
			type: 'GET',
			dataType: 'JSON',
			url: '<?php echo Yii::app()->createUrl("anyagbeszallitasok/refreshOsszertek") . "/anyagbeszallitas_id/" . $model->id; ?>',
			success:function(data){
				if (data !== null) {
					$('#Anyagbeszallitasok_displayOsszertek').val(data.osszertek);

					return false;
				}
			},
		});

		return false;
	}
</script>