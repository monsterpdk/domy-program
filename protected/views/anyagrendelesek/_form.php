<?php
/* @var $this AnyagrendelesekController */
/* @var $model Anyagrendelesek */
/* @var $form CActiveForm */

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
	'id'=>'anyagrendelesek-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Anyagrendelés adatai</strong>",
		));
	?>
		
		<?php echo $form->errorSummary($model); ?>

		<?php echo $form->hiddenField($model, 'id'); ?>
		<?php echo $form->hiddenField($model, 'user_id'); ?>
		<?php echo $form->hiddenField($model, 'anyagbeszallitas_id'); ?>
		
		<?php echo CHtml::hiddenField('raktarhely_id' , '', array('id' => 'raktarhely_id')); ?>
		
		<?php if (!$model->isNewRecord): ?>
			<?php echo $form->hiddenField($model, 'gyarto_id'); ?>
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
			<?php echo $form->labelEx($model,'bizonylatszam'); ?>
			<?php echo $form->textField($model,'bizonylatszam',array('size'=>12,'maxlength'=>12)); ?>
			<?php echo $form->error($model,'bizonylatszam'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'rendeles_datum'); ?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$model,
						'attribute'=>'rendeles_datum',
						'options'=>array('dateFormat'=>'yy-mm-dd',),
						'htmlOptions'=>array('style' => 'width:123px'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_set_now_rendeles_datum',
						'caption'=>'Most',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  
							$("#Anyagrendelesek_rendeles_datum").datepicker("setDate", new Date());
						}'),
						'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'margin-left:10px; height:32px', 'target' => '_blank'),
					));
				?>
			
			<?php echo $form->error($model,'rendeles_datum'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'displayOsszertek'); ?>
			<?php echo $form->textField($model,'displayOsszertek',array('size'=>10,'maxlength'=>8, 'readOnly'=>true)); ?>
			<?php echo $form->error($model,'displayOsszertek'); ?>
		</div>
		
		<div class="row clear">
			<?php echo $form->labelEx($model,'megjegyzes'); ?>
			<?php echo $form->textArea($model,'megjegyzes',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'megjegyzes'); ?>
		</div>

		<?php if (Yii::app()->user->checkAccess('Admin')): ?>
			<div class="row active">
				<?php echo $form->checkBox($model,'sztornozva'); ?>
				<?php echo $form->label($model,'sztornozva'); ?>
				<?php echo $form->error($model,'sztornozva'); ?>
			</div>

			<div class="row active">
				<?php echo $form->checkBox($model,'lezarva'); ?>
				<?php echo $form->label($model,'lezarva'); ?>
				<?php echo $form->error($model,'lezarva'); ?>
			</div>
		<?php endif; ?>
		
		<div class="row buttons">
				<?php $this->widget('zii.widgets.jui.CJuiButton', 
						 array(
							'name'=>'anyagrendelesek_form_submit',
							'caption'=>'Mentés',
							'htmlOptions' => array ('class' => 'btn btn-primary btn-lg',),
						 )); ?>
				<?php $this->widget('zii.widgets.jui.CJuiButton', 
						 array(
							'name'=>'back',
							'caption'=>'Vissza',
							'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'submit' => Yii::app()->request->urlReferrer),
						 )); ?>
				<?php $this->widget('zii.widgets.jui.CJuiButton', 
						 array(
							'name'=>'print',
							'caption'=>'Nyomtatás',
							 'onclick'=>new CJavaScriptExpression('function(){openPrintDialog($(this)); return false;}'),
							'htmlOptions' => array ('class' => 'btn btn-danger btn-lg', 'style' =>'margin-left: 70px',),
						 )); ?>						 
		</div>
		
	<?php $this->endWidget(); ?>

<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Megrendelt termékek</strong>",
	));

	if (Yii::app()->user->checkAccess('AnyagrendelesTermekek.Create')) {
		
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button_create_anyagrendelesTermek',
			'caption'=>'Termék hozzáadása',
			'buttonType'=>'link',
			'onclick'=>new CJavaScriptExpression('function() {addUpdateAnyagrendelesTermek("create", $(this));}'),
			'htmlOptions'=>array('class'=>'btn btn-success'),
		));
	}
	
	// a dialógus ablak inicializálása
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id'=>'dialogAnyagrendelesTermek',
		'options'=>array(
			'title'=>'Termék hozzáadása',
			'autoOpen'=>false,
			'modal'=>true,
			'width'=>900,
			'height'=>580,
		),
	));
?>
	<div class="divForForm"></div>
	 
	<?php $this->endWidget();?>
	 
	<script type="text/javascript">
	
		function addUpdateAnyagrendelesTermek(createOrUpdate, buttonObj)
		{
		
			if ($("#Anyagrendelesek_gyarto_id").val() != null && $("#Anyagrendelesek_gyarto_id").val().trim() != "") {
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
				id = (isUpdate) ? hrefString.substr(hrefString.lastIndexOf("/") + 1) : $("#Anyagrendelesek_id").val();
				dialog_title = (isUpdate) ? "Termék módosítása" : "Termék hozzáadása";

				<?php echo CHtml::ajax(array(
						'url'=> "js:'/index.php/anyagrendelesTermekek/' + op + '/id/' + id + '/gyarto_id/' + $('select[id=\"Anyagrendelesek_gyarto_id\"]').val() + '/grid_id/' + new Date().getTime()",
						'data'=> "js:$(this).serialize()",
						'type'=>'post',
						'id' => 'send-link-'.uniqid(),
						'replace' => '#termek_dialog',
						'dataType'=>'json',
						'success'=>"function(data)
						{
							if (data.status == 'failure')
							{
								$('#dialogAnyagrendelesTermek div.divForForm').html(data.div);
								$('#dialogAnyagrendelesTermek div.divForForm form').submit(addUpdateAnyagrendelesTermek);
							}
							else
							{
								$.fn.yiiGridView.update(\"anyagrendelesTermekek-grid\",{ complete: function(jqXHR, status) {}})
								$('#Anyagrendelesek_displayOsszertek').val(data.displayOsszertek);
								
								$('#dialogAnyagrendelesTermek div.divForForm').html(data.div);
								$('#dialogAnyagrendelesTermek').dialog('close');
							}
			 
						} ",
				))?>;
				
			}
			
			$("#dialogAnyagrendelesTermek").dialog("open");
			$("#dialogAnyagrendelesTermek").dialog('option', 'title', dialog_title);
			
			return false; 
		}
	 
	</script>

	<?php
		$config = array();
		$dataProvider=new CActiveDataProvider('AnyagrendelesTermekek',
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
			'id' => 'anyagrendelesTermekek-grid',
			'dataProvider'=>$dataProvider,
			'enablePagination' => false,
			'afterAjaxUpdate'=>'function(id,data){
				refreshOsszertek ();
			}',
			'columns'=>array(
				'termek.kodszam',
				'termek.nev',
				'rendelt_darabszam',
				'rendeleskor_netto_darabar',
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
									'click'=>'function() {addUpdateAnyagrendelesTermek("update", $(this));}',
									'visible' => "Yii::app()->user->checkAccess('AnyagrendelesTermekek.Update')",
								),
								'delete' => array(
									'label' => 'Töröl',
									'icon'=>'icon-white icon-remove-sign',
									'url'=>'Yii::app()->createUrl("/anyagrendelesTermekek/delete", array("id"=>$data["id"]))',
									'visible' => "Yii::app()->user->checkAccess('AnyagrendelesTermekek.Delete')",
								),
							),
					),
			)
		));
		
		$this->endWidget();
	?>

</div><!-- form -->

<?php $this->endWidget(); ?>


<?php if ((Yii::app()->user->checkAccess('AnyagbeszallitasTermekek.Create') || Yii::app()->user->checkAccess('Admin')) && $model -> lezarva != 1): ?>
	<!-- A form elküldése előtt leellenőrzöm a rendelt és beérkezett darabszámok egyezését. Ha egyeznek a tételek, feldobjuk a raktárelhelyezési dialog-ot -->
	<!-- Csak akkor vizsgáljuk, ha a user ADMIN, vagy raktáros, aki az anyagbeszállítást veszi fel. Aki az anyagrendeléseket kezeli, ott nem ellenőrzünk. -->
	<script>
		$(document).ready(function() {
			$('#anyagrendelesek_form_submit').click(function(ev) {

				$.ajax({
					type: 'GET',
					dataType: 'JSON',
					url: '<?php echo Yii::app()->createUrl("anyagbeszallitasok/checkProductDifference") . "/anyagbeszallitas_id/" . $model->anyagbeszallitas_id . "/anyagrendeles_id/" . $model->id; ?>',
					success:function(data){
						if (data !==  null) {
							// a tételek ellenőrzés során eltérést találtunk
							if (data.ok != 1) {
								// LI: egy új kérés szerint nem dobunk fel dialog-ot az eltérésről, hagyjuk menteni
								$("#anyagrendelesek-form").submit()
								
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
						return true;
						/*
							$('#dialogShowError').html('Lejárt a munkamenet. Jelentkezzen be újra!');
							$('#dialogShowError').dialog('open');
						*/
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
	
    ?>
<?php endif; ?>

<script>
	function refreshOsszertek () {
		$.ajax({
			type: 'GET',
			dataType: 'JSON',
			url: '<?php echo Yii::app()->createUrl("anyagrendelesek/refreshOsszertek") . "/anyagrendeles_id/" . $model->id; ?>',
			success:function(data){
				if (data !== null) {
					$('#Anyagrendelesek_displayOsszertek').val(data.osszertek);

					return false;
				}
			},
		});

		return false;
	}
</script>

<?php	
	// LI: print dialog inicializálása
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogAnyagrendelesPrint',
            
            'options'=>array(
                'title'=>'Nyomtatás',
				'width'=> '400px',
                'modal' => true,
                'buttons' => array('Nyomtatás árral' => 'js:function() { model_id = $(this).data("model_id"), $(location).attr("href", "../printPDF?id=" + model_id + "&type=arral");}', 'Nyomtatás ár nélkül' => 'js:function() { model_id = $(this).data("model_id"), $(location).attr("href", "../printPDF?id=" + model_id + "&type=arnelkul");}'),
                'autoOpen'=>false,
        )));
?>		
	<p> Nyomtatási mód kiválasztása </p>
	
<?php		
	$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script type="text/javascript">
		function openPrintDialog (button_obj) {
			var row_id = $("#Anyagrendelesek_id").val();
			
			$("#dialogAnyagrendelesPrint").data('model_id', row_id).dialog("open");
		}
</script>