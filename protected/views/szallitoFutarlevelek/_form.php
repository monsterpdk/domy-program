<?php
/* @var $this SzallitoFutarlevelekController */
/* @var $model SzallitoFutarlevelek */
/* @var $form CActiveForm */

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'szallito-futarlevelek-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Futárlevél adatai</strong>",
		));
	?>
		
		<?php echo $form->errorSummary($model); ?>

		<?php echo $form->hiddenField($model, 'id'); ?>

		<?php echo CHtml::hiddenField('szallito_mentett_futar' , $model->szallito_futar, array('id' => 'szallito_mentett_futar')); ?>


		<div class="row">
			<?php echo $form->labelEx($model,'szallitolevel_szam'); ?>
			<?php echo $form->textField($model,'szallitolevel_szam',array('size'=>12,'maxlength'=>20)); ?>
			<?php echo $form->error($model,'szallitolevel_szam'); ?>
			<?php
			$this->widget('zii.widgets.jui.CJuiButton', array(
				'name'=>'button_load_szallitolevel',
				'caption'=>'Betöltés',
				'buttonType'=>'link',
				'onclick'=>new CJavaScriptExpression('function() {  
							szallitolevel_betoltes();
						}'),
				'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'height:32px; width:95px', 'target' => '_blank'),
			));
			?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'szamla_sorszam'); ?>
			<?php echo $form->textField($model,'szamla_sorszam',array('size'=>12,'maxlength'=>20)); ?>
			<?php echo $form->error($model,'szamla_sorszam'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'szallito_ceg'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'szallito_ceg',
					CHtml::listData(SzallitoCegek::model()->findAll(array("condition"=>"torolt=0")), 'id', 'nev'),
					array('required'=>'required',
							'empty'=>'',
							'ajax'=> array(
								'type'=>'Post',
								'url'=>CController::createUrl('SzallitoCegFutarok/futarlistaAjax'),
								'data'=>array('futarceg_id'=>'js:this.value'),
								'datatype'=>'html',
								'success'=>'function(result){ 
                                                                $("#szallito_futar").html(result);
                                                                $("#szallito_futar").val($("#szallito_mentett_futar").val()); }'
							),
					)
				); ?>
				
			<?php echo $form->error($model,'szallito_ceg'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'szallito_futar'); ?>
			<?php echo CHtml::dropDownList('szallito_futar','', array());?>

			<?php echo $form->error($model,'szallito_futar'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'felvetel_helye'); ?>
			<?php echo $form->textField($model,'felvetel_helye',array('size'=>100,'maxlength'=>100, 'required'=>'required')); ?>
			<?php echo $form->error($model,'felvetel_helye'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'felvetel_ideje'); ?>

			<?php
			$this->widget('application.extensions.timepicker.EJuiDateTimePicker', array(
				'model'=>$model,
				'attribute'=>'felvetel_ideje',
				'language' => 'hu',
				'options'=>array(
					'timeFormat' => 'hh:mm:ss',
					'dateFormat'=>'yy-mm-dd',
				),
				'htmlOptions'=>array('style' => 'width:135px'),
			));
			?>

			<?php
			$this->widget('zii.widgets.jui.CJuiButton', array(
				'name'=>'button_set_now_felvetel_ideje',
				'caption'=>'Most',
				'buttonType'=>'link',
				'onclick'=>new CJavaScriptExpression('function() {  
								$("#SzallitoFutarlevelek_felvetel_ideje").datetimepicker("setDate", (new Date()) );
							}'),
				'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'height:32px; width:65px', 'target' => '_blank'),
			));
			?>

			<?php echo $form->error($model,'felvetel_ideje'); ?>
		</div>

			<div class="row">
				<?php echo $form->labelEx($model,'szallitas_cegnev'); ?>
				<?php echo $form->textField($model,'szallitas_cegnev',array('size'=>100,'maxlength'=>100, 'required'=>'required')); ?>
				<?php echo $form->error($model,'szallitas_cegnev'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'szallitas_cim'); ?>
				<?php echo $form->textField($model,'szallitas_cim',array('size'=>100,'maxlength'=>100, 'required'=>'required')); ?>
				<?php echo $form->error($model,'szallitas_cim'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'szallitas_telefonszam'); ?>
				<?php echo $form->textField($model,'szallitas_telefonszam',array('size'=>20,'maxlength'=>20, 'required'=>'required')); ?>
				<?php echo $form->error($model,'szallitas_telefonszam'); ?>
			</div>

			<?php $this->endWidget(); ?>


			<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>"<strong>Fizetési adatok</strong>",
			));
			?>
			<div class="row">
				<?php echo $form->labelEx($model,'fizetesi_mod'); ?>

				<?php echo CHtml::activeDropDownList($model, 'fizetesi_mod',
					CHtml::listData(FizetesiModok::model()->findAll(array("condition"=>"torolt=0", 'order'=>'nev')), 'id', 'nev'),
					array('empty'=>'', 'required'=>'required')
				); ?>

				<?php echo $form->error($model,'fizetesi_mod'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'utanvet_osszeg'); ?>
				<?php echo $form->textField($model,'utanvet_osszeg',array('size'=>20,'maxlength'=>20)); ?>
				<?php echo $form->error($model,'utanvet_osszeg'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'utanvet_visszahozas_datum'); ?>

				<?php
				$this->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$model,
					'attribute'=>'utanvet_visszahozas_datum',
					'options'=>array('dateFormat'=>'yy-mm-dd',),
					'htmlOptions'=>array('style' => 'width:123px'),
				));
				?>

				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_set_now_utanvet_visszahozas_datum',
						'caption'=>'Most',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  
								$("#SzallitoFutarlevelek_utanvet_visszahozas_datum").datepicker("setDate", new Date());
							}'),
						'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'margin-left:10px; height:32px', 'target' => '_blank'),
					));
				?>

				<?php echo $form->error($model,'utanvet_visszahozas_datum'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'egyeb_info'); ?>
				<?php echo $form->textArea($model,'egyeb_info'); ?>
				<?php echo $form->error($model,'egyeb_info'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'szallitas_dij'); ?>
				<?php echo $form->textField($model,'szallitas_dij',array('size'=>20,'maxlength'=>20)); ?>
				<?php echo $form->error($model,'szallitas_dij'); ?>
			</div>


	<?php $this->endWidget(); ?>

	<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"<strong>Szállítandó áruk</strong>"
	));
	?>

	<?php
	$this->widget('zii.widgets.grid.CEditableGridView', array(
	'dataProvider'=>$aruk,
	'showQuickBar'=>'true',
	'quickCreateAction'=>'QuickCreate', // will be actionQuickCreate()
	'columns'=>array(
//	'title',          // display the 'title' attribute
	array('header' => 'Törlésre', 'name' => 'torolt', 'class' => 'CEditableColumn', 'inputCssClass' => 'torlesre', 'tdCssClass' => 'editable-column-hidden', 'hidden'=>true,   'headerHtmlOptions'=>array('style'=>'display:none'), 'htmlOptions'=>array('style'=>'display:none'),),
	array('header' => 'Tétel ID', 'name' => 'id', 'class' => 'CEditableColumn', 'inputCssClass' => '', 'tdCssClass' => 'editable-column-hidden', 'hidden'=>true,   'headerHtmlOptions'=>array('style'=>'display:none'), 'htmlOptions'=>array('style'=>'display:none'),),
	array('header' => 'Megnevezés', 'name' => 'megnevezes', 'class' => 'CEditableColumn', 'inputCssClass' => 'editable-column-input-szeles', 'tdCssClass' => 'editable-column-40'),
	array('header' => 'db', 'name' => 'darab', 'class' => 'CEditableColumn', 'inputCssClass' => 'editable-column-input-szeles', 'tdCssClass' => 'editable-column-20'),
	array('header' => 'Megjegyzés', 'name' => 'megjegyzes', 'class' => 'CEditableColumn', 'inputCssClass' => 'editable-column-input-szeles', 'tdCssClass' => 'editable-column-40'),
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=>array('style'=>'width: 130px; text-align: center;'),
			'template' => '{delete}',
			'deleteButtonOptions'=>array('class'=>'btn btn-danger btn-mini'),
			'buttons' => array(
				'delete' => array(
					'label' => 'Töröl',
					'icon'=>'icon-white icon-remove-sign',
					'url'=>'',
					'click'=>'function() {tetelTorlesre($(this));}',
					'visible' => "Yii::app()->user->checkAccess('szallitoFutarlevelTetelek.Delete')",
				),
			),
		),
	)));
	?>

		<div class="row buttons">
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
					 array(
						'name'=>'futarlevel_form_submit',
						'caption'=>'Mentés',
						'htmlOptions' => array ('class' => 'btn btn-primary btn-lg',),
					 )); ?>
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
					 array(
						'name'=>'back',
						'caption'=>'Vissza',
						'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'submit' => Yii::app()->request->urlReferrer),
					 )); ?>
		</div>

	<?php $this->endWidget(); ?>

	<?php $this->endWidget(); ?>

<script>
	function teteltablazat_urit() {
		$(".items tbody .odd").closest("tbody").remove() ;
		$(".items tbody tr").each(function() {
			if ($(this).find(".ceditable_grid_view_addbtn").is(":hidden")) {
				$(this).remove();
			}
		});
	}

	function szallitolevel_betoltes() {
		var szallitolevel_szam = $("#SzallitoFutarlevelek_szallitolevel_szam").val();
		<?php echo CHtml::ajax(array(
			'url'=> "js:'/index.php/szallitolevelek/SzallitolevelAdatokAjax/szallitolevel_szam/' + szallitolevel_szam",
			'data'=> "js:$(this).serialize()",
			'type'=>'post',
			'id' => 'send-link-'.uniqid(),
			'replace' => '',
			'dataType'=>'json',
			'success'=>"function(data)
					{
						if (data.status == 'failure')
						{
							alert('Sikertelen betöltés') ;
						}
						else
						{
							teteltablazat_urit() ;
							$(\"#SzallitoFutarlevelek_szallitas_cegnev\").val(data.szallitas_cegnev) ;
							$(\"#SzallitoFutarlevelek_szallitas_cim\").val(data.szallitas_cim) ;
							$(\"#SzallitoFutarlevelek_szallitas_telefonszam\").val(data.szallitas_telefonszam) ;
							if (typeof data.tetelek != \"undefined\") {							
								$.each(data.tetelek, function(index, value) {
									var utolso_sor = $(\".items tbody tr\").last() ;
									utolso_sor.find('[name=\"SzallitoFutarlevelTetelek[megnevezes][]\"]').val(value.megnevezes) ;
									utolso_sor.find('[name=\"SzallitoFutarlevelTetelek[darab][]\"]').val(value.darab) ;
									utolso_sor.find('.ceditable_grid_view_addbtn').click();
//									alert(value.megnevezes) ;
								}); 
							}
						}
		 
					} ",
		))?>;
	}

	function tetelTorlesre(buttonObj) {
		if (typeof buttonObj != 'undefined') {
			var torlesre = buttonObj.parent().parent().find(".torlesre").val();
			if (torlesre == 1) {
				buttonObj.parent().parent().find(".torlesre").val("0") ;
				buttonObj.parent().parent().removeClass("selected-to-delete") ;
			}
			else
			{
				buttonObj.parent().parent().find(".torlesre").val("1") ;
				buttonObj.parent().parent().addClass("selected-to-delete") ;
			}
		}


	}

	$(window).load(function() {
		if ($("#SzallitoFutarlevelek_szallito_ceg").val() != "") {
			$("#SzallitoFutarlevelek_szallito_ceg").change();
		}
	})
</script>