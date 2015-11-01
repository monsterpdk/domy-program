<?php
/* @var $this NyomdaMunkatipusokController */
/* @var $model NyomdaMunkatipusok */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'nyomda-munkatipusok-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Munkatípus adatai</strong>",
		));
	?>
	
	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model, 'id'); ?>
	
	<div>
		<?php echo $form->labelEx($model,'munkatipus_nev'); ?>
		<?php echo $form->textField($model,'munkatipus_nev',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'munkatipus_nev'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'darabszam_tol'); ?>
		<?php echo $form->textField($model,'darabszam_tol',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'darabszam_tol'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'darabszam_ig'); ?>
		<?php echo $form->textField($model,'darabszam_ig',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'darabszam_ig'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szinszam_tol_elo'); ?>
		<?php echo CHtml::activeDropDownList($model, 'szinszam_tol_elo', array('0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4'), array()); ?>
		<?php echo $form->error($model,'szinszam_tol_elo'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'szinszam_ig_elo'); ?>
		<?php echo CHtml::activeDropDownList($model, 'szinszam_ig_elo', array('0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4'), array()); ?>
		<?php echo $form->error($model,'szinszam_ig_elo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'szinszam_tol_hat'); ?>
		<?php echo CHtml::activeDropDownList($model, 'szinszam_tol_hat', array('0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4'), array()); ?>
		<?php echo $form->error($model,'szinszam_tol_hat'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'szinszam_ig_hat'); ?>
		<?php echo CHtml::activeDropDownList($model, 'szinszam_ig_hat', array('0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4'), array()); ?>
		<?php echo $form->error($model,'szinszam_ig_hat'); ?>
	</div>
	
	<?php if (Yii::app()->user->checkAccess('Admin')): ?>
		<div class="row active">
			<?php echo $form->checkBox($model,'torolt'); ?>
			<?php echo $form->label($model,'torolt'); ?>
			<?php echo $form->error($model,'torolt'); ?>
		</div>
	<?php endif; ?>

<?php $this->endWidget(); ?>


<?php // TERMÉKEK
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Termékek</strong>",
			'htmlOptions'=>array('class'=>"portlet right-widget"),
		));

			if (Yii::app()->user->checkAccess('NyomdaMunkatipusTermekek.Create')) {
				
				$this->widget('zii.widgets.jui.CJuiButton', array(
					'name'=>'button_create_termek',
					'caption'=>'Termék hozzáadása',
					'buttonType'=>'link',
					'onclick'=>new CJavaScriptExpression('function() { addTermek(); }'),
					'htmlOptions'=>array('class'=>'btn btn-success'),
				));
			}

			// GRIDVIEW BEGIN
			$config = array();
			$dataProvider=new CActiveDataProvider('NyomdaMunkatipusTermekek',
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

			// CJUIDIALOG BEGIN
			  $this->beginWidget('zii.widgets.jui.CJuiDialog', 
				   array(   'id'=>'nyomda-munkatipus-termek-dialog',
						'options'=>array(
										'title'=>'Termék kiválasztása',
										'width'=>'auto',
										'autoOpen'=>false,
										),
								));
								
				echo "<div class='divForFormTermekek'></div>";
			
			$this->endWidget('zii.widgets.jui.CJuiDialog');
			// CJUIDIALOG END
			
			$this->widget('zii.widgets.grid.CGridView', array(
				'id' => 'termekek-grid',
				'enablePagination' => false,
				'dataProvider'=>$dataProvider,
				'columns'=>array(
					'termek.nev',
					array(
								'class' => 'bootstrap.widgets.TbButtonColumn',
								'htmlOptions'=>array('style'=>'width: 130px; text-align: center;'),
								'template' => '{delete_item}',
								
								'buttons' => array(
							        'delete_item' => array
									(
										'label'=>'Töröl',
										'icon'=>'icon-white icon-remove-sign',
										'options'=>array(
											'class'=>'btn btn-danger btn-mini',
											),
										'url'=>'"#"',
										'visible' => "Yii::app()->user->checkAccess('NyomdaMunkatipusTermekek.Delete')",
										'click'=>"function(){
														$.fn.yiiGridView.update('termekek-grid', {
															type:'POST',
															dataType:'json',
															url:$(this).attr('href'),
															success:function(data) {
																$.fn.yiiGridView.update('termekek-grid');
															}
														})
														return false;
												  }
										 ",
										 'url'=> 'Yii::app()->createUrl("NyomdaMunkatipusTermekek/delete/" . $data->id)',
									),
								),
						),
				)
			));
		// GRIDVIEW END
	
	?>
<?php $this->endWidget(); ?>
	
	
<?php // MŰVELETEK
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Műveletek</strong>",
			'htmlOptions'=>array('class'=>"portlet right-widget"),
		));

			if (Yii::app()->user->checkAccess('NyomdaMunkatipusMuveletek.Create')) {
				
				$this->widget('zii.widgets.jui.CJuiButton', array(
					'name'=>'button_create_muvelet',
					'caption'=>'Művelet hozzáadása',
					'buttonType'=>'link',
					'onclick'=>new CJavaScriptExpression('function() { addMuvelet(); }'),
					'htmlOptions'=>array('class'=>'btn btn-success'),
				));
			}
			
		
			
			// GRIDVIEW BEGIN
			$config = array();
			$dataProvider=new CActiveDataProvider('NyomdaMunkatipusMuveletek',
				array( 'data' => $model->muveletek,
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

			// CJUIDIALOG BEGIN
			  $this->beginWidget('zii.widgets.jui.CJuiDialog', 
				   array(   'id'=>'nyomda-munkatipus-muvelet-dialog',
						'options'=>array(
										'title'=>'Művelet kiválasztása',
										'width'=>'auto',
										'autoOpen'=>false,
										),
								));
								
				echo "<div class='divForFormMuveletek'></div>";
			
			$this->endWidget('zii.widgets.jui.CJuiDialog');
			// CJUIDIALOG END
			
			$this->widget('zii.widgets.grid.CGridView', array(
				'id' => 'muveletek-grid',
				'enablePagination' => false,
				'dataProvider'=>$dataProvider,
				'columns'=>array(
					'muvelet.muvelet_nev',
					array(
								'class' => 'bootstrap.widgets.TbButtonColumn',
								'htmlOptions'=>array('style'=>'width: 130px; text-align: center;'),
								'template' => '{delete_item}',
								
								'buttons' => array(
							        'delete_item' => array
									(
										'label'=>'Töröl',
										'icon'=>'icon-white icon-remove-sign',
										'options'=>array(
											'class'=>'btn btn-danger btn-mini',
											),
										'url'=>'"#"',
										'visible' => "Yii::app()->user->checkAccess('NyomdaMunkatipusMuveletek.Delete')",
										'click'=>"function(){
														$.fn.yiiGridView.update('muveletek-grid', {
															type:'POST',
															dataType:'json',
															url:$(this).attr('href'),
															success:function(data) {
																$.fn.yiiGridView.update('muveletek-grid');
															}
														})
														return false;
												  }
										 ",
										 'url'=> 'Yii::app()->createUrl("NyomdaMunkatipusMuveletek/delete/" . $data->id)',
									),
								),
						),
				)
			));
		// GRIDVIEW END
	
	?>
	
<?php $this->endWidget(); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Vezérlőpult</strong>",
		));
	?>	

		<div class="row buttons">
			<?php echo CHtml::submitButton('Mentés'); ?>
			<?php echo CHtml::button('Vissza', array('submit' => Yii::app()->request->urlReferrer)); ?>
		</div>

	<?php $this->endWidget(); ?>

</div>

<!-- form -->
<?php $this->endWidget(); ?>

<script type="text/javascript">
	
	function addTermek ()
	{
		id = $("#NyomdaMunkatipusok_id").val();
			
		<?php echo CHtml::ajax(array(
				'url'=> "js:'/index.php/nyomdaMunkatipusTermekek/create/id/' + id + '/grid_id/' + new Date().getTime()",
				'data'=> "js:$(this).serialize()",
				'type'=>'post',
				'id' => 'send-munkatipus-termek-'.uniqid(),
				'replace' => '',
				'dataType'=>'json',
				'success'=>"function(data)
				{
					if (data.status == 'failure')
					{
						$('#nyomda-munkatipus-termek-dialog div.divForFormTermekek').html(data.div);
					}
					else
					{
						$('#nyomda-munkatipus-termek-dialog div.divForFormTermekek').html(data.div);
						$('#nyomda-munkatipus-termek-dialog').dialog('close');
					}
	 
				} ",
		))?>;
		
		$("#nyomda-munkatipus-termek-dialog").dialog("open");
		
		return false; 		
	}
	
	function addMuvelet ()
	{
		id = $("#NyomdaMunkatipusok_id").val();
			
		<?php echo CHtml::ajax(array(
				'url'=> "js:'/index.php/nyomdaMunkatipusMuveletek/create/id/' + id + '/grid_id/' + new Date().getTime()",
				'data'=> "js:$(this).serialize()",
				'type'=>'post',
				'id' => 'send-munkatipus-muvelet-'.uniqid(),
				'replace' => '',
				'dataType'=>'json',
				'success'=>"function(data)
				{
					if (data.status == 'failure')
					{
						$('#nyomda-munkatipus-muvelet-dialog div.divForFormMuveletek').html(data.div);
					}
					else
					{
						$('#nyomda-munkatipus-muvelet-dialog div.divForFormMuveletek').html(data.div);
						$('#nyomda-munkatipus-muvelet-dialog').dialog('close');
					}
	 
				} ",
		))?>;
		
		$("#nyomda-munkatipus-muvelet-dialog").dialog("open");
		
		return false; 		
	}
	
</script>