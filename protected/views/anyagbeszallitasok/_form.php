<?php
/* @var $this AnyagbeszallitasokController */
/* @var $model Anyagbeszallitasok */
/* @var $form CActiveForm */

// pl. raktáros munkakörhöz kellhet, csak a raktárba érkezett anyagmennyiséget tudja szerkeszteni,
// a beszállítás adatait ne
$canEditBeszallitasData = Yii::app()->user->checkAccess('AnyagbeszallitasTermekekIroda.Update') || Yii::app()->user->checkAccess('Admin');

Yii::app() -> clientScript->registerScript('updateGridView', '
	$.updateGridView = function(gridID, nameList, valueList) {
		var index;
			
		for	(index = 0; index < nameList.length; index++) {
			$("#" + gridID + " input[name=\'" + nameList[index] + "\'], #" + gridID + " select[name=\'" + nameList[index] + "\']").val(valueList[index]);				
		} 

		$.fn.yiiGridView.update(gridID, {
			data: $.param($("#"+gridID+" .filters input, #"+gridID+" .filters select"))
		});
	}
	', CClientScript::POS_READY);

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

		<?php echo CHtml::hiddenField('raktarhely_id' , '', array('id' => 'raktarhely_id')); ?>
		
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
					array('disabled'=>(!$model->gyarto_id == null || !$canEditBeszallitasData))
				); ?>
				
			<?php echo $form->error($model,'gyarto_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'anyagrendeles_id'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'anyagrendeles_id',
					($model->lezarva != 1) ? CHtml::listData(Anyagrendelesek::model()->findAll(array("condition"=>"lezarva=0", 'order'=>'bizonylatszam DESC')), 'id', 'displayBizonylatszamDatum') : CHtml::listData(Anyagrendelesek::model()->findAll(), 'id', 'displayBizonylatszamDatum'),
					((!$model->anyagrendeles_id == null) || !$canEditBeszallitasData) ? array('empty'=>'', 'disabled'=>'true', 'onChange'=>'javascript:tetelekFrissitese();') : array('empty'=>'', 'onChange'=>'javascript:tetelekFrissitese();')
				); ?>
				
			<?php echo $form->error($model,'anyagrendeles_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'bizonylatszam'); ?>
			<?php echo $form->textField($model,'bizonylatszam',array('size'=>12,'maxlength'=>12, 'readonly'=>!$canEditBeszallitasData)); ?>
			<?php echo $form->error($model,'bizonylatszam'); ?>
		</div>

		<div class="clear">			
			<div class="row">
				<?php echo $form->labelEx($model,'beszallitas_datum'); ?>
					
					<?php
						$this->widget('zii.widgets.jui.CJuiDatePicker', array(
							'model'=>$model,
							'attribute'=>'beszallitas_datum',
							'options'=>array('dateFormat'=>'yy-mm-dd',),
							'htmlOptions'=>array('style' => 'width:123px', 'disabled'=>!$canEditBeszallitasData),
						));
					?>

					<?php if ($canEditBeszallitasData)
						$this->widget('zii.widgets.jui.CJuiButton', array(
							'name'=>'button_set_now_beszallitas_datum',
							'caption'=>'Most',
							'buttonType'=>'link',
							'onclick'=>new CJavaScriptExpression('function() {  
								$("#Anyagbeszallitasok_beszallitas_datum").datepicker("setDate", new Date());
							}'),
							'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'margin-left:10px; height:32px', 'target' => '_blank'),
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
							'options'=>array('dateFormat'=>'yy-mm-dd',),
							'htmlOptions'=>array('style' => 'width:123px', 'disabled'=>!$canEditBeszallitasData),
						));
					?>
					
					<?php if ($canEditBeszallitasData)
						$this->widget('zii.widgets.jui.CJuiButton', array(
							'name'=>'button_set_now_kifizetes_datum',
							'caption'=>'Most',
							'buttonType'=>'link',
							'onclick'=>new CJavaScriptExpression('function() {  
								$("#Anyagbeszallitasok_kifizetes_datum").datepicker("setDate", new Date());
							}'),
							'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'margin-left:10px; height:32px', 'target' => '_blank'),
						));
					?>
					
				<?php echo $form->error($model,'kifizetes_datum'); ?>
			</div>	
		</div>
		
		<div class='clear'>
			<div class="row">
				<?php echo $form->labelEx($model,'displayOsszertekIroda'); ?>
				<?php echo $form->textField($model,'displayOsszertekIroda',array('size'=>10,'maxlength'=>8, 'readonly'=>true)); ?>
				<?php echo $form->error($model,'displayOsszertekIroda'); ?>
			</div>
			
			<div class="row">
				<?php echo $form->labelEx($model,'displayOsszertekRaktar'); ?>
				<?php echo $form->textField($model,'displayOsszertekRaktar',array('size'=>10,'maxlength'=>8, 'readonly'=>true)); ?>
				<?php echo $form->error($model,'displayOsszertekRaktar'); ?>
			</div>
		</div>
		
		<div class="row clear">
			<?php echo $form->labelEx($model,'megjegyzes'); ?>
			<?php echo $form->textArea($model,'megjegyzes',array('size'=>60,'maxlength'=>255, 'readonly'=>!$canEditBeszallitasData)); ?>
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
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
					 array(
						'name'=>'anyagbeszallitasok_form_submit',
						'caption'=>'Mentés',
						'htmlOptions' => array ('class' => 'btn btn-primary btn-lg',),
					 )); ?>
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
					 array(
						'name'=>'back',
						'caption'=>'Vissza',
						'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'submit' => Yii::app()->request->urlReferrer),
					 )); ?>
			
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
			'width'=>900,
			'height'=>580,
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
			
			anyagrendeles_id = $('select[id=\"Anyagbeszallitasok_anyagrendeles_id\"]').val();
			if (anyagrendeles_id == '') anyagrendeles_id = "null";
			
			bizonylatszam = $("#Anyagbeszallitasok_bizonylatszam").val();
			if (bizonylatszam == '') bizonylatszam = "null";
			
			<?php echo CHtml::ajax(array(
					'url'=> "js:'/index.php/AnyagbeszallitasTermekek/' + op + '/id/' + id + '/gyarto_id/' + $('select[id=\"Anyagbeszallitasok_gyarto_id\"]').val() + '/anyagrendeles_id/' + anyagrendeles_id + '/bizonylatszam/' + bizonylatszam + '/grid_id/' + new Date().getTime()",
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
					'termek.kodszam',
					'termek.DisplayTermekTeljesNev',
					'hozott_boritek:boolean',
					
					// a darabszám szerkeszthető a gyorsabb ügyintézés érdekében
					array(
						'class' => 'editable.EditableColumn',
						'name'  => 'darabszam',
						'value' => function($data, $row) use ($model){
							return $data->darabszam;
						},
						'header' => 'Darabszám',
						'editable' => array(
 						   'placement' => 'right',
						   'url'       => $this->createUrl('anyagbeszallitasok/updateDarabszamRaktar'),
						   'validate' => 'js: function(value) {
								if ( ($.trim(value) == "") || !(value % 1 === 0) || !($.isNumeric(value) && parseInt(value) >= 0) ) return "Csak 0, vagy annál nagyobb érték írható be !";
							}',
							'onSave' => 'js: function(e, params) {
								// sikeres mentés után frissítjük az összérték mezőket
								refreshOsszertek ();
							}',
					)),
					
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
			'width'=>900,
			'height'=>580,
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
			
			anyagrendeles_id = $('select[id=\"Anyagbeszallitasok_anyagrendeles_id\"]').val();
			if (anyagrendeles_id == '') anyagrendeles_id = "null";
			
			bizonylatszam = $("#Anyagbeszallitasok_bizonylatszam").val();
			if (bizonylatszam == '') bizonylatszam = "null";
			
			<?php echo CHtml::ajax(array(
					'url'=> "js:'/index.php/AnyagbeszallitasTermekekIroda/' + op + '/id/' + id + '/gyarto_id/' + $('select[id=\"Anyagbeszallitasok_gyarto_id\"]').val() + '/anyagrendeles_id/' + anyagrendeles_id + '/bizonylatszam/' + bizonylatszam + '/grid_id/' + new Date().getTime()",
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
			$dataProvider=new CActiveDataProvider('AnyagbeszallitasTermekekIroda',
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
					'termek.kodszam',
					'termek.DisplayTermekTeljesNev',
					'hozott_boritek:boolean',
					
					// a darabszám szerkeszthető a gyorsabb ügyintézés érdekében
					array(
						'class' => 'editable.EditableColumn',
						'name'  => 'darabszam',
						'value' => function($data, $row) use ($model){
							return $data->darabszam;
						},
						'header' => 'Darabszám',
						'editable' => array(
 						   'placement' => 'right',
						   'url'       => $this->createUrl('anyagbeszallitasok/updateDarabszamIroda'),
						   'validate' => 'js: function(value) {
								if ( ($.trim(value) == "") || !(value % 1 === 0) || !($.isNumeric(value) && parseInt(value) >= 0) ) return "Csak 0, vagy annál nagyobb érték írható be !";
							}',
							'onSave' => 'js: function(e, params) {
								// sikeres mentés után frissítjük az összérték mezőket
								  refreshOsszertek ();
							}',
					)),

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

				// UPDATE: felmerült egy igény, mely szerint lehessen raktárba bevételezni anyagrendelés nélkül is, ilyenkor csak az irodai és raktár mennyiségeket hasonlítjuk össze
				ev.preventDefault();

				$.ajax({
					type: 'GET',
					dataType: 'JSON',
					url: '<?php echo Yii::app()->createUrl("anyagbeszallitasok/checkProductDifference") . "/anyagbeszallitas_id/" . $model->id . "/anyagrendeles_id/"; ?>' + anyagrendeles_js_value,
					success:function(data){
						if (data !==  null) {
							// a tételek ellenőrzés során eltérést találtunk
							if (data.ok != 1) {
								// LI: egy új kérés szerint nem dobunk fel dialog-ot az eltérésről, hagyjuk menteni
								$("#anyagbeszallitasok-form").submit()
								
								//$('#dialogUnSuccesfullCheck').html(data);
								//$('#dialogUnSuccesfullCheck').dialog('open');
							} else if (data.ok == 1) {
								// a tételek ellenőrzés során megegyeztek a tételek az anyagrendelés és beszállítás során, lezárható
								// az anyagbeszállításhoz tartozó anyagrendelés

								if (data.hozott_boritek == 0) {
									$('#nemHozottSzoveg').show();
									$('#hozottSzoveg').hide();
								} else {
									// van hozott termék a listában, ezért automatikusan abba a raktárba rakjuk őket
									$('#nemHozottSzoveg').hide();
									$('#hozottSzoveg').show();
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
						'Mentés, lezárás és elhelyezés'=>'js:function(){$(this).dialog("close"); $("#raktarhely_id").val( $("#raktarHelyek").val()); $("#anyagbeszallitasok-form").submit();}',
						'Mégse'=>'js:function(){ $(this).dialog("close" );}',),
					'autoOpen'=>false,
			)));

			echo "<div id='nemHozottSzoveg' stlye='display:none'>
			Az anyagrendeléshez található beszállítás a rendszerben. Mentést követően lezárásra kerül az anyagrendelés és az anyagbeszállítás, a tételek pedig a kiválasztott raktárba kerülnek. <br /><br /> Raktár+raktárhely kiválasztása: <br /><br />
			</div>";
			
			echo "<div id='hozottSzoveg' stlye='display:none'>
			Az anyagrendeléshez található beszállítás a rendszerben. A tételek között található hozott termék, így azon tételek automatikusan a <strong> 'Hozott boríték raktárba'</strong>, az egyéb tételek pedig a kiválasztott raktárba kerülnek. <br /><br />
			</div>";
			
			echo "<div id='raktarValasztoCombo'>";
			$list = CHtml::listData(RaktarHelyek::model()->findAll(array("condition"=>"nev <> 'Hozott boríték raktár 1'", 'order'=>'nev')), 'id', 'displayTeljesNev');
			echo CHtml::dropDownList('raktarHelyek', '', $list, array());
			echo "</div>";
			
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

<?php
	// a dialógus ablak inicializálása
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id'=>'dialogSynchronizeProgresss',
		'options'=>array(
			'title'=>'Szinkronizálás',
			'autoOpen'=>false,
			'modal'=>true,
			'width'=>300,
			'height'=>300,
		),
	));?>
	
	<div class="divForForm">
		<p align='center' style='margin:50px'>
			<img src='../../../images/ajax-loader.gif' />
		</p>

		<p align='center'>
			Tételek szinkronizálása ...
		</p>
	</div>
	 
<?php $this->endWidget();?>

<script>

		function refreshOsszertek () {
			$.ajax({
				type: 'GET',
				dataType: 'JSON',
				url: '<?php echo Yii::app()->createUrl("anyagbeszallitasok/refreshOsszertek") . "/anyagbeszallitas_id/" . $model->id; ?>',
				success:function(data){
					if (data !== null) {
						$('#Anyagbeszallitasok_displayOsszertekIroda').val(data.osszertekIroda);
						$('#Anyagbeszallitasok_displayOsszertekRaktar').val(data.osszertekRaktar);

						return false;
					}
				},
			});

			return false;
		}
		
		// LI : itt adjuk hozzá a kapcsolódó anyagrendelés kiválasztása után a tételeket az irodai részhez, vagy a raktári részhez
		function tetelekFrissitese () {
			var anyagrendeles_id = $('#Anyagbeszallitasok_anyagrendeles_id').val();
			
			if (anyagrendeles_id != '') {
				if (confirm('A termékek szinkronizálva lesznek a kiválasztott anyagrendelés termékeivel. A jelenleg felvett termékek törlődni fognak. Biztosan folytatja?')) {
					$.ajax({
						type: 'GET',
						dataType: 'JSON',
						url: '<?php echo Yii::app()->createUrl("anyagbeszallitasok/synchronizeTetel") . "/anyagbeszallitas_id/" . $model->id . "/anyagrendeles_id/" ; ?>' + anyagrendeles_id,
						success:function(data){
							if (data !== null) {
								$('#Anyagbeszallitasok_displayOsszertekIroda').val(data.osszertekIroda);
								$('#Anyagbeszallitasok_displayOsszertekRaktar').val(data.osszertekRaktar);

								return false;
							}
						},
						beforeSend: function() {
							// feldobjuk a felhasználónak a progress dialog-ot
							$("#dialogSynchronizeProgresss").dialog("open");
						},
						complete: function() {
							// frissítjük a termékraktár listákat (a gridview-ek önmaguk firssítése után frissíték az összérték mezőket is)
							$.fn.yiiGridView.update("AnyagbeszallitasTermekek-grid");
							$.fn.yiiGridView.update("AnyagbeszallitasTermekekIroda-grid");

							// bezárjuk a progress dialog-ot
							$("#dialogSynchronizeProgresss").dialog("close");
						},
					});
				} else {
					// ha a felhasználó a nem gombot választotta, akkor a lenyíló listába vissza kell állítanunk az előző elemet
					$('#Anyagbeszallitasok_anyagrendeles_id').val( ($('#Anyagbeszallitasok_anyagrendeles_id').data("oldData")) );	
				}
			}
			
			return false;
		}
		
		// hogy el tudjuk menteni az anyagrendelés előzőleg kiválasztott értékét
		var anyagrendeles = $("#Anyagbeszallitasok_anyagrendeles_id");
		anyagrendeles.data("oldData", anyagrendeles.val());

		anyagrendeles.change (function(data){
			var obj = $(this);
			obj.data("oldData", obj.val());
		});

</script>