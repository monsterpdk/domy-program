<?php
/* @var $this TermekekController */
/* @var $model Termekek */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'termekek-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

		<?php echo $form->hiddenField($model, 'id'); ?>
		
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>"<strong>Termékadatok #1</strong>",
			));
		?>
		
		<div class="row">
			<?php echo $form->labelEx($model,'nev'); ?>
			<?php echo $form->textField($model,'nev',array('size'=>60,'maxlength'=>127)); ?>
			<?php echo $form->error($model,'nev'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'tipus'); ?>
			<?php echo DHtml::enumDropDownList($model, 'tipus'); ?>
			<?php echo $form->error($model,'tipus'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'kodszam'); ?>
			<?php echo $form->textField($model,'kodszam',array('size'=>15,'maxlength'=>15)); ?>
			<?php echo $form->error($model,'kodszam'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'cikkszam'); ?>
			<?php echo $form->textField($model,'cikkszam',array('size'=>30,'maxlength'=>30)); ?>
			<?php echo $form->error($model,'cikkszam'); ?>
		</div>
		
		
		<div class="row">
			<?php echo $form->labelEx($model,'meret_id'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'meret_id',
					CHtml::listData(TermekMeretek::model()->findAll(array("condition"=>"torolt=0")), 'id', 'nev')
				); ?>
				
			<?php echo $form->error($model,'meret_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'zaras_id'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'zaras_id',
					CHtml::listData(TermekZarasiModok::model()->findAll(array("condition"=>"torolt=0")), 'id', 'nev')
				); ?>
				
			<?php echo $form->error($model,'zaras_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'ablakmeret_id'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'ablakmeret_id',
					CHtml::listData(TermekAblakMeretek::model()->findAll(array("condition"=>"torolt=0")), 'id', 'nev')
				); ?>
				
			<?php echo $form->error($model,'ablakmeret_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'ablakhely_id'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'ablakhely_id',
					CHtml::listData(TermekAblakhelyek::model()->findAll(array("condition"=>"torolt=0")), 'id', 'nev')
				); ?>
				
			<?php echo $form->error($model,'ablakhely_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'papir_id'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'papir_id',
					CHtml::listData(PapirTipusok::model()->findAll(array("condition"=>"torolt=0")), 'id', 'FullName')
				); ?>
				
			<?php echo $form->error($model,'papir_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'afakulcs_id'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'afakulcs_id',
					CHtml::listData(AfaKulcsok::model()->findAll(array("condition"=>"torolt=0")), 'id', 'nev')
				); ?>
				
			<?php echo $form->error($model,'afakulcs_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'gyarto_id'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'gyarto_id',
					CHtml::listData(Gyartok::model()->findAll(array("condition"=>"torolt=0")), 'id', 'cegnev')
				); ?>
				
			<?php echo $form->error($model,'gyarto_id'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'suly'); ?>
			<?php echo $form->textField($model,'suly'); ?>
			<?php echo $form->error($model,'suly'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'redotalp'); ?>
			<?php echo $form->textField($model,'redotalp',array('size'=>50,'maxlength'=>50)); ?>
			<?php echo $form->error($model,'redotalp'); ?>
		</div>

		<div class="row active" style="width:214px;">
			<?php echo $form->checkBox($model,'belesnyomott'); ?>
			<?php echo $form->label($model,'belesnyomott'); ?>
			<?php echo $form->error($model,'belesnyomott'); ?>
		</div>

		<div class="row active" style="width:214px;">
			<?php echo $form->checkBox($model,'arkalkulacioban_megjelenik'); ?>
			<?php echo $form->label($model,'arkalkulacioban_megjelenik'); ?>
			<?php echo $form->error($model,'arkalkulacioban_megjelenik'); ?>
		</div>

		<!--
		<div class="row">
			<?php //echo $form->labelEx($model,'kategoria_tipus'); ?>
			<?php //echo $form->textField($model,'kategoria_tipus',array('size'=>1,'maxlength'=>1)); ?>
			<?php //echo $form->error($model,'kategoria_tipus'); ?>
		</div>
		-->
		
		<div class="row">
			<?php echo $form->labelEx($model,'termekcsoport_id'); ?>
			
				<?php echo CHtml::activeDropDownList($model, 'termekcsoport_id',
					CHtml::listData(termekcsoportok::model()->findAll(array("condition"=>"torolt=0")), 'id', 'nev')
				); ?>
				
			<?php echo $form->error($model,'termekcsoport_id'); ?>
		</div>
		
	<?php $this->endWidget(); ?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"<strong>Termékadatok #2</strong>",
		));
	?>

		<div class="row">
			<?php echo $form->labelEx($model,'ksh_kod'); ?>
			<?php echo $form->textField($model,'ksh_kod',array('size'=>10,'maxlength'=>10)); ?>
			<?php echo $form->error($model,'ksh_kod'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'csom_egys'); ?>
			<?php echo $form->textField($model,'csom_egys',array('size'=>10,'maxlength'=>10)); ?>
			<?php echo $form->error($model,'csom_egys'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'minimum_raktarkeszlet'); ?>
			<?php echo $form->textField($model,'minimum_raktarkeszlet',array('size'=>10,'maxlength'=>10)); ?>
			<?php echo $form->error($model,'minimum_raktarkeszlet'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'maximum_raktarkeszlet'); ?>
			<?php echo $form->textField($model,'maximum_raktarkeszlet',array('size'=>10,'maxlength'=>10)); ?>
			<?php echo $form->error($model,'maximum_raktarkeszlet'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'doboz_suly'); ?>
			<?php echo $form->textField($model,'doboz_suly'); ?>
			<?php echo $form->error($model,'doboz_suly'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'raklap_db'); ?>
			<?php echo $form->textField($model,'raklap_db',array('size'=>10,'maxlength'=>10)); ?>
			<?php echo $form->error($model,'raklap_db'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'doboz_hossz'); ?>
			<?php echo $form->textField($model,'doboz_hossz'); ?>
			<?php echo $form->error($model,'doboz_hossz'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'doboz_szelesseg'); ?>
			<?php echo $form->textField($model,'doboz_szelesseg'); ?>
			<?php echo $form->error($model,'doboz_szelesseg'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'doboz_magassag'); ?>
			<?php echo $form->textField($model,'doboz_magassag'); ?>
			<?php echo $form->error($model,'doboz_magassag'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'megjegyzes'); ?>
			<?php echo $form->textArea($model,'megjegyzes',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'megjegyzes'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'felveteli_datum'); ?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$model,
						'attribute'=>'felveteli_datum',
						'options'=>array('dateFormat'=>'yy-mm-dd',),
						'htmlOptions'=>array('style' => 'width:123px'),
					));
				?>
				
				<?php
					$this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'button_set_now_felveteli_datum',
						'caption'=>'Most',
						'buttonType'=>'link',
						'onclick'=>new CJavaScriptExpression('function() {  
							$("#Termekek_felveteli_datum").datepicker("setDate", new Date());
						}'),
						'htmlOptions'=>array('class' => 'bt btn-info search-button', 'style' => 'margin-left:10px; height:32px', 'target' => '_blank'),
					));
				?>
			
			<?php echo $form->error($model,'felveteli_datum'); ?>
		</div>
		
		<?php if (Yii::app()->user->checkAccess('Admin')): ?>
			<div class="row active">
				<?php echo $form->checkBox($model,'torolt'); ?>
				<?php echo $form->label($model,'torolt'); ?>
				<?php echo $form->error($model,'torolt'); ?>
			</div>
		<?php endif; ?>

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
	
	<div class='clear'></div>

		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>"<strong>Képek</strong>",
				'htmlOptions'=> array ('style' => 'clear:both;width:100%!important', 'class' => 'portlet'),
			));
		?>

		<script type="text/template" id="qq-thumbnails-template">
			<div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Húzza a feltöltendő képeket ide">
				<div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
					<div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
				</div>
				<div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
					<span class="qq-upload-drop-area-text-selector"></span>
				</div>
				<div class="qq-upload-button-selector qq-upload-button">
					<div><i class="icon-plus icon-white"></i> Kép feltöltése</div>
				</div>
				<span class="qq-drop-processing-selector qq-drop-processing">
					<span>Képek feldolgozása...</span>
					<span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
				</span>
				
				<ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
					<li>
						<div class="qq-progress-bar-container-selector">
							<div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
						</div>
						<span class="qq-upload-spinner-selector qq-upload-spinner"></span>
						<a target='_blank' class="view-link"> <img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale> </a>
						<span class="qq-upload-file-selector qq-upload-file"></span>
						<span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Fájlnév szerkesztése"></span>
						<input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
						<span class="qq-upload-size-selector qq-upload-size"></span>
						<button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">Mégse</button>
						<button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">Újra</button>
						<button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">Törlés</button>
						<span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
					</li>
				</ul>

				<dialog class="qq-alert-dialog-selector">
					<div class="qq-dialog-message-selector"></div>
					<div class="qq-dialog-buttons">
						<button type="button" class="qq-cancel-button-selector">Bezár</button>
					</div>
				</dialog>

				<dialog class="qq-confirm-dialog-selector">
					<div class="qq-dialog-message-selector"></div>
					<div class="qq-dialog-buttons">
						<button type="button" class="qq-cancel-button-selector">Nem</button>
						<button type="button" class="qq-ok-button-selector">Igen</button>
					</div>
				</dialog>

				<dialog class="qq-prompt-dialog-selector">
					<div class="qq-dialog-message-selector"></div>
					<input type="text">
					<div class="qq-dialog-buttons">
						<button type="button" class="qq-cancel-button-selector">Mégse</button>
						<button type="button" class="qq-ok-button-selector">Ok</button>
					</div>
				</dialog>
			</div>
		</script>

		<div>
			<h4>Feltöltött képek</h4> <br />
		</div>
		
		<div class='clear'></div>
		
		<?php
			$dirname = Yii::getPathOfAlias('webroot').'/uploads/termekek/kepek/' . $model->id . '/';;
			$images = glob($dirname."*.*");
			$imageFolder = Yii::app()->getBaseUrl(true) . '/uploads/termekek/kepek/' . $model->id . '/';
			
			foreach($images as $image) {
				$imageUrl = $imageFolder.basename($image);
				echo '
					<ul style="list-style: outside none none; margin: 0px 0px 20px 0px; padding: 0;">
						<li>
							<a href="' . $imageUrl . '" target="_blank" class="view-link"><img src = "' . $imageUrl . '" width=100px class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale></a>
							<span class="qq-upload-file-selector qq-upload-file"> ' . basename($image) . ' </span>
				';
							echo CHtml::ajaxButton(
								"Törlése",
								$this->createUrl('deleteImage'),
								array (
									'context'=>'js:$(this)',
									'type'=>'POST',
									'data'=>array('termekId'=>$model->id, 'filename'=>basename($image)),
									'success'=>'js:function(data){$(this).closest(\'li\').remove();}',
																	
								),
								array('class'=>'qq-btn qq-upload-delete-selector qq-upload-delete')
							);
				echo '			
						</li>
					</ul>
				';			
			}
		?>
		
		<div>
			<h4>Új képek feltöltése</h4> <br />
		</div>
		
		<div class='clear'></div>

		<?php
			$this->widget('ext.EFineUploader.EFineUploader',
			 array(
				   'id'=>'FineUploader',
					'config'=>array(
							   'template'=>'qq-thumbnails-template',
							   'autoUpload'=>true,
							   'multiple'=>true,
						       'text'=> array(
									'uploadButton'=>"<i class='icon-plus icon-white'></i> Kép feltöltése"
								),
							   'request'=>array(
									'endpoint'=>$this->createUrl('uploadImages'),
									'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken, 'termekId'=>$model->id),
								),
								'deleteFile'=> array(
									'enabled'=>true,
									'forceConfirm'=>true,
									'method'=>'POST',
									'endpoint'=>$this->createUrl('deleteImage'),
								),	   
								'retry'=>array('enableAuto'=>true,'preventRetryResponseProperty'=>true),
								'chunking'=>array('enable'=>true,'partSize'=>100),//bytes
								'callbacks'=>array(
												'onComplete'=>"js:function(id, name, response){
													var serverPathToFile = response.filePath,
													fileItem = this.getItemByFileId(id);

													if (response.success) {
														var viewBtn = qq(fileItem).getByClass(\"view-link\")[0];

														viewBtn.setAttribute(\"href\", response.imageUrl);
													}
												}",
												//'onError'=>"js:function(id, name, errorReason){ }",
												'onSubmitDelete' => "js:function(id) {
													this.setDeleteFileParams({filename: this.getName(id), termekId: $('#Termekek_id').val()}, id);
												}",
												'onValidateBatch' => "js:function(fileOrBlobData) {}", // LI: e nélkül JS hiba
												 ),
								'validation'=>array(
										 'allowedExtensions'=>array('jpg','jpeg', 'png'),
										 'sizeLimit'=>5 * 1024 * 1024, // max. file limit egyelőre 5 MB
												),
				)
			  ));
		 
		?>

	<?php $this->endWidget(); ?>
	
<?php $this->endWidget(); ?>

</div><!-- form -->