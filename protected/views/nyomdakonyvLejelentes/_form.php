<?php
/* @var $this NyomdakonyvLejelentesController */
/* @var $model NyomdakonyvLejelentes */
/* @var $form CActiveForm */

?>

<div class="form">

<script>
	$('#nyomdakonyv-lejelentes-form').submit(function(event){
			event.preventDefault();
			ajax_form_submit();
//			$("#nyomdakonyv-lejelentes-form").submit();
	});


	function ajax_form_submit() {
		var data=$("#nyomdakonyv-lejelentes-form").serialize();
		var action = $("#nyomdakonyv-lejelentes-form").attr("action") ;
		action = action.replace("delete", "create") ;
		action = action.replace(/id\/(\d*)/, "id/<?php echo $nyomdakonyv_model->id;?>") ;
		$.ajax({
			type: 'POST',
			dataType:'json',
			url: action,
			data:data,
			success:function(data){		
//			  var result = jQuery.parseJSON(
			  $("#dialogNyomdakonyvLejelentes").html(data.div);
			},
			error: function(data) { // if error occured
			  alert("Error occured.please try again");
			},
		});		
	}
</script>

	<div class="nyomdakonyv-lejelentes-form-bal">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'nyomdakonyv-lejelentes-eredmeny-form',
			// Please note: When you enable ajax validation, make sure the corresponding
			// controller action is handling ajax validation correctly.
			// There is a call to performAjaxValidation() commented in generated controller code.
			// See class documentation of CActiveForm for details on this.
				'enableAjaxValidation'=>false,
				'action'=>Yii::app()->createUrl("nyomdakonyv/kezi_jelentes_ment/id/" . $nyomdakonyv_model->id),
		)); ?>
		
			<?php echo $form->errorSummary($nyomdakonyv_model); ?>
		
			<?php echo $form->hiddenField($nyomdakonyv_model, 'id'); ?>
			<?php echo $form->hiddenField($model, 'user_id'); ?>
	
		<div class="row">
			<?php echo $form->labelEx($nyomdakonyv_model,'kesz_jo'); ?>
			<?php echo $form->textField($nyomdakonyv_model,'kesz_jo',array('size'=>10,'maxlength'=>6)); ?>
			<?php echo $form->error($nyomdakonyv_model,'kesz_jo'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($nyomdakonyv_model,'kesz_selejt'); ?>
			<?php echo $form->textField($nyomdakonyv_model,'kesz_selejt',array('size'=>10,'maxlength'=>6)); ?>
			<?php echo $form->error($nyomdakonyv_model,'kesz_selejt'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($nyomdakonyv_model,'kesz_visszazu'); ?>
			<?php echo $form->textField($nyomdakonyv_model,'kesz_visszazu',array('size'=>10,'maxlength'=>6)); ?>
			<?php echo $form->error($nyomdakonyv_model,'kesz_visszazu'); ?>
		</div>
		<div class="row buttons">
				<?php $this->widget('zii.widgets.jui.CJuiButton', 
						 array(
							'name'=>'submitForm',
							'caption'=>'Eredmény mentés',
							'htmlOptions' => array ('class' => 'btn btn-primary btn-lg',),
						 )); ?>
				<?php $this->widget('zii.widgets.jui.CJuiButton', 
						 array(
						 	'buttonType'=>'button',
							'name'=>'Closedialog',
							'caption'=>'Bezár',
							'htmlOptions' => array ('class' => 'btn btn-info btn-lg', 'onclick'=>'js: lejelentes_dialog.dialog("close"); return false;'),
						 )); ?>
		</div>	
<?php $this->endWidget(); ?>
	</div>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'nyomdakonyv-lejelentes-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($nyomdakonyv_model, 'id'); ?>
	<?php echo $form->hiddenField($model, 'user_id'); ?>
 
	<div class="nyomdakonyv-lejelentes-form-jobb">
		<div class="row">
			<?php echo $form->labelEx($model,'fullname'); ?>
			<?php echo CHtml::activeDropDownList($model,'user_id',CHtml::listData( User::model()->findAll(), 'id', 'fullname' ), array('prompt'=>'Válassz dolgozót...'));?>
			<?php echo $form->error($model,'user_id'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'teljesitmeny_szazalek'); ?>
			<?php echo $form->textField($model,'teljesitmeny_szazalek',array('size'=>10,'maxlength'=>3)); ?>
			<?php echo $form->error($model,'teljesitmeny_szazalek'); ?>
		</div>
	
		<div class="row buttons">
				<?php $this->widget('zii.widgets.jui.CJuiButton', 
						 array(
							'name'=>'submitForm',
							'caption'=>'Dolgozó hozzáadása',
							'htmlOptions' => array ('class' => 'btn btn-primary btn-lg',),
						 )); ?>
		</div>
	</div>
<?php $this->endWidget(); ?>

	<div class="nyomdakonyv-lejelentes-form-jobb">	
	<?php
		// GRIDVIEW BEGIN
			$config = array();
			$dataProvider=new CActiveDataProvider('NyomdakonyvLejelentes',
				array( 'data' => $nyomdakonyv_model->lejelentes_sorok,
						'sort'=>array(
							'attributes'=>array(
								'teljesitmeny_szazalek' => array(
									'asc' => 'teljesitmeny_szazalek ASC',
									'desc' => 'teljesitmeny_szazalek DESC',
								),
							),
						),
				)
			);

			$this->widget('zii.widgets.grid.CGridView', array(
				'id' => 'nyomdakonyvLejelentes-grid',
				'enablePagination' => false,
				'dataProvider'=>$dataProvider,
				'columns'=>array(
					'user.fullname',
					'teljesitmeny_szazalek',
					array(
								'class' => 'bootstrap.widgets.TbButtonColumn',
								'htmlOptions'=>array('style'=>'width: 130px; text-align: center;'),
								'template' => '{delete_item}',
								
								'updateButtonOptions'=>array('class'=>'btn btn-success btn-mini'),
								
								'buttons' => array(
							        'delete_item' => array
									(
										'label'=>'Töröl',
										'icon'=>'icon-white icon-remove-sign',
										'options'=>array(
											'class'=>'btn btn-danger btn-mini',
											),
										'url'=>'"#"',
										'visible' => "Yii::app()->user->checkAccess('NyomdakonyvLejelentes.Delete')",
										'click'=>"function(){
														$.fn.yiiGridView.update('nyomdakonyvLejelentes-grid', {
															type:'POST',
															dataType:'json',
															url:$(this).attr('href'),
															success:function(data) {	
																$('#dialogNyomdakonyvLejelentes').html(data.div) ;
//																$.fn.yiiGridView.update('nyomdakonyvLejelentes-grid');
															}
														})
														return false;
												  }
										 ",
										 'url'=> 'Yii::app()->createUrl("nyomdakonyvLejelentes/delete/id/" . $data->id)',
									),
								),
						),
				)
			));
		// GRIDVIEW END	
	?>
	</div>
	


</div><!-- form -->