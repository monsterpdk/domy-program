<?php
/* @var $this TermekArakController */
/* @var $model TermekArak */
/* @var $form CActiveForm */

if (!isset($termek_adatok)) {
	$termek_adatok["belesnyomott"] = 0;
}

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'termek-arak-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Termék adatai</strong>",
		));
	?>
	
		<div class="row">
			<?php echo $form->labelEx($model,'termek_id'); ?>
			<?php //echo $form->textField($model,'termek_id',array('size'=>10,'maxlength'=>10)); ?>
			
			<?php echo CHtml::activeDropDownList($model, 'termek_id',
				CHtml::listData(Termekek::model()->findAll(array("condition"=>"torolt=0")), 'id', 'displayTermekTeljesNev')
			); ?>
			
			<?php echo $form->error($model,'termek_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'db_beszerzesi_ar'); ?>
			<?php echo $form->textField($model,'db_beszerzesi_ar'); ?>
			<?php echo $form->error($model,'db_beszerzesi_ar'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'db_ar_nyomashoz'); ?>
			<?php echo $form->textField($model,'db_ar_nyomashoz'); ?>
			<?php echo $form->error($model,'db_ar_nyomashoz'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'db_eladasi_ar'); ?>
			<?php echo $form->textField($model,'db_eladasi_ar'); ?>
			<?php echo $form->error($model,'db_eladasi_ar'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'csomag_ar_szamolashoz'); ?>
			<?php echo $form->textField($model,'csomag_ar_szamolashoz'); ?>
			<?php echo $form->error($model,'csomag_ar_szamolashoz'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'csomag_ar_nyomashoz'); ?>
			<?php echo $form->textField($model,'csomag_ar_nyomashoz'); ?>
			<?php echo $form->error($model,'csomag_ar_nyomashoz'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'csomag_eladasi_ar'); ?>
			<?php echo $form->textField($model,'csomag_eladasi_ar'); ?>
			<?php echo $form->error($model,'csomag_eladasi_ar'); ?>
		</div>
	
		<div class="row active">
			<input id = "termek_belesnyomott" type="checkbox" value="<?php echo $termek_adatok["belesnyomott"]; ?>" <?php if ($termek_adatok["belesnyomott"] == 1) echo " checked "; ?> name="belesnyomott" disabled >
			Bélésnyomott
		</div>
			
	<?php $this->endWidget(); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Érvényesség</strong>",
		));
	?>
	

		<div class="row">
			<?php echo $form->labelEx($model,'datum_mettol'); ?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$model,
						'attribute'=>'datum_mettol',
						'options'=>array('dateFormat'=>'yy-mm-dd',),
						'htmlOptions'=>array('style' => 'width:123px'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_set_now_datum_mettol',
						'caption'=>'Most',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  
							$("#TermekArak_datum_mettol").datepicker("setDate", new Date());
						}'),
						'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'margin-left:10px; height:32px', 'target' => '_blank'),
					));
				?>
			
			<?php echo $form->error($model,'datum_mettol'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'datum_meddig'); ?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$model,
						'attribute'=>'datum_meddig',
						'options'=>array('dateFormat'=>'yy-mm-dd',),
						'htmlOptions'=>array('style' => 'width:123px'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_set_now_datum_meddig',
						'caption'=>'Most',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  
							$("#TermekArak_datum_meddig").datepicker("setDate", new Date());
						}'),
						'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'margin-left:10px; height:32px', 'target' => '_blank'),
					));
				?>
			
			<?php echo $form->error($model,'datum_meddig'); ?>
		</div>
		
		<?php if (Yii::app()->user->checkAccess('Admin')): ?>
			<div class="row active">
				<?php echo $form->checkBox($model,'torolt'); ?>
				<?php echo $form->label($model,'torolt'); ?>
				<?php echo $form->error($model,'torolt'); ?>
			</div>
		<?php endif; ?>
		
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>"<strong>Csomag ár sávok</strong>",
				'htmlOptions'=>array('class'=>"portlet right-widget"),
			));
	
				if (Yii::app()->user->checkAccess('TermekSavosCsomagarak.Create')) {
					
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_create_csomagar_sav',
						'caption'=>'Ár sáv hozzáadása',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {addArSav("create", $(this));}'),
						'htmlOptions'=>array('class'=>'btn btn-success'),
					));
				}
				
				// a dialógus ablak inicializálása
				$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
					'id'=>'dialogArSav',
					'options'=>array(
						'title'=>'Ár sáv hozzáadása',
						'autoOpen'=>false,
						'modal'=>true,
						'width'=>400,
						'height'=>400,
					),
				));
				
				echo "<div class='divForForm'></div>";
				
				$this->endWidget();
				
				
			// GRIDVIEW BEGIN
				$dataProvider=new CActiveDataProvider('TermekSavosCsomagarak',
					array( 'data' => $model->termeksavoscsomagarak,
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
					'id' => 'savos-csomagarak-grid',
					'enablePagination' => false,
					'dataProvider'=>$dataProvider,
					'columns'=>array(
						'user.fullname',
						'idopont',
						'jegyzet',
						array(
									'class' => 'bootstrap.widgets.TbButtonColumn',
									'htmlOptions'=>array('style'=>'width: 130px; text-align: center;'),
									'template' => '{update} {delete_item}',
									
									'updateButtonOptions'=>array('class'=>'btn btn-success btn-mini'),
									
									'buttons' => array(
										'update' => array(
											'label' => 'Szerkeszt',
											'icon'=>'icon-white icon-pencil',
											'url'=>'',
											'click'=>'function() {addUpdateArSav("update", $(this));}',
											'visible' => "Yii::app()->user->checkAccess('TermekSavosCsomagarak.Update')",
										),
										'delete_item' => array
										(
											'label'=>'Töröl',
											'icon'=>'icon-white icon-remove-sign',
											'options'=>array(
												'class'=>'btn btn-danger btn-mini',
												),
											'url'=>'"#"',
											'visible' => "Yii::app()->user->checkAccess('TermekSavosCsomagarak.Delete')",
											'click'=>"function(){
															$.fn.yiiGridView.update('savos-csomagarak-grid', {
																type:'POST',
																dataType:'json',
																url:$(this).attr('href'),
																success:function(data) {
																	$.fn.yiiGridView.update('savos-csomagarak-grid');
																}
															})
															return false;
													  }
											 ",
											 'url'=> 'Yii::app()->createUrl("TermekSavosCsomagarak/delete/" . $data->id)',
										),
									),
							),
					)
				));
			// GRIDVIEW END
		$this->endWidget();
		?>		

		<div class="row buttons">
			<?php $this->widget('zii.widgets.jui.CJuiButton', 
					 array(
						'name'=>'submitForm',
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

</div><!-- form -->

<script type="text/javascript">
	$(document).ready(function(){
		updateBelesnyomottCheckbox ();
	});
	
	$('#TermekArak_termek_id').on('change', function() {
		updateBelesnyomottCheckbox ();
	});
	
	function updateBelesnyomottCheckbox ()
	{
		var termek_id = $('#TermekArak_termek_id').val();

		<?php echo CHtml::ajax(array(
				'url'=> "js:'/index.php/termekarak/updateBelesnyomottCheckbox/termek_id/' + termek_id",
				'data'=> "js:$(this).serialize()",
				'type'=>'post',
				'id' => 'update-belesnyomott-link-'.uniqid(),
				'replace' => '',
				'dataType'=>'json',
				'success'=>"function(data)
				{
					if (data.status == 'failure')
					{
						$( '#termek_belesnyomott' ).prop( 'checked', false );
					}
					else
					{
						$( '#termek_belesnyomott' ).prop( 'checked', data.belesnyomott == 1 ? true : false );
					}
	 
				} ",
		))?>;

		return false; 
	}
</script>