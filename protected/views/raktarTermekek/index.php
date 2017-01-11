<?php
	/* @var $this TermekArakController */
	/* @var $dataProvider CActiveDataProvider */

	$grid_id = round(microtime(true) * 1000);

	// raw foglalt db oszlop formázása
	function formatFoglaltDb ($data) {
		 return Utils::DarabszamFormazas($data->foglalt_db);
	}
	
	$reszletesLista = false;
	if (isset($_GET['RaktarTermekek'])) {
		if ($_GET['RaktarTermekek']['is_atmozgatas']) {
			$reszletesLista = $_GET['RaktarTermekek']['is_atmozgatas'] == 1;
		}
	}
	
?>

<h1>Raktárkészletek</h1>

<div class="btn-group">
	<button type="button" class="btn btn-success btn-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Lista nyomtatása <span class="caret"></span>
	</button>
	<ul class="dropdown-menu">
		<li><a href="<?php echo Yii::app()->createUrl("raktarTermekek/printRaktarkeszlet", $_GET); ?>" target="_blank">Képernyőn megjelenő lista</a></li>
		<li role="separator" class="divider"></li>
		<li><a href="#" onclick = "openCikkszamValaszto (); return false;">Cikkszám szerint ...</a></li>
		<li><a href="#" onclick = "openTermekcsoportValaszto (); return false;">Termékcsoport szerint ...</a></li>
	</ul>
</div>

<div class="search-form">
	<?php  $this->renderPartial('_search',array(
		'model'=>$model,
		'reszletesLista'=>$reszletesLista,
	)); ?>
</div>

<?php 

    $this->widget('ext.groupgridview.BootGroupGridView', array(
      'id' => 'raktar_termekek_grid',
      'itemsCssClass'=>'items group-grid-view',
      'dataProvider' => $model -> search(),
	  'enableSorting' => false,
      'extraRowColumns' => $reszletesLista ? array('raktarHelyek.raktar.nev') : array(),
      'mergeColumns' => $reszletesLista ? array('raktarHelyek.raktar.nev', 'raktarHelyek.nev') : array(),
      'columns' => array(
						array(
							'class' => 'bootstrap.widgets.TbButtonColumn',
							'htmlOptions'=>array('style'=>'width: 30px; text-align: left;'),
							'template' => '{relocate}',
							'visible' => $reszletesLista,
							'buttons' => array(
								'relocate' => array(
									'url' => '$data->id',
									'label' => 'Átmozgat',
									'icon'=>'icon-white icon-move',
									'options'=>array(
												'class'=>'btn btn-info btn-mini',
												'onclick' => 'js: openRelocateDialog ( $(this).attr("href"), event ); return false;',
												),
								),
							),
						),
						array(
							'name'=>'raktarHelyek.raktar.nev',
							'visible'=>$reszletesLista,
						),
						array(
							'name'=>'raktarHelyek.nev',
							'visible'=>$reszletesLista,
						),						
						array(
							'name'=>'anyagbeszallitas.bizonylatszam',
							'visible'=>$reszletesLista,
						), 
						array(
							'name'=>'anyagbeszallitas.beszallitas_datum',
							'visible'=>$reszletesLista,
						), 
						'termek.cikkszam',
						'termek.DisplayTermekTeljesNev',
						'termek.gyarto.cegnev',
						'osszes_db:number',
						array(
							'class'=>'CLinkColumnEval',
							'linkHtmlOptions'=>array('onclick'=>'"openFoglaltDbListDialog ($data->id); return false;"'),
							'header'=>'Foglalt db',
							'labelExpression'=>'formatFoglaltDb($data)'
						),
						'elerheto_db:number',
      ),
	  
    ));

?>

<!-- CJUIDIALOG BEGIN raktárhelyek szerint -->
<?php 
  $this->beginWidget('zii.widgets.jui.CJuiDialog', 
	   array(   'id'=>'termek_athelyez_dialog' . $grid_id,
				'options'=>array(
								'title'=>'Termék áthelyezése',
								'modal'=>true,
								'width'=>1100,
								'height'=>500,
								'autoOpen'=>false,
								),
						));
?>

	<div class="divForForm"></div>

<?php $this->endWidget(); ?>
<!-- CJUIDIALOG END -->

<!-- CJUIDIALOG BEGIN cikkszámok szerint  -->
<?php 
  $this->beginWidget('zii.widgets.jui.CJuiDialog', 
	   array(   'id'=>'cikkszam_szerint_nyomtat' . $grid_id,
				'options'=>array(
								'title'=>'Nyomtatás cikkszám(ok) szerint',
								'modal'=>true,
								'width'=>620,
								'height'=>230,
								'autoOpen'=>false,
  							    'buttons' => array('Nyomtatás' => 'js:function() {
									window.open("/index.php/raktarTermekek/printRaktarkeszletByCikkszam?cikkszamok=" + $("#cikkszamok").val(), "_blank");
								}'),
							),
						));
?>

	<div>
		<?php echo Chtml::label('Cikkszám(ok) kiválasztása:', 'cikkszamok'); ?>
	
		<?php $this->widget('application.extensions.multicomplete.MultiComplete', array(
			  'name'=>'cikkszamok',
			  'splitter'=>',',
			  'sourceUrl'=>$this->createUrl('termekek/searchCikkszamok'),
			  'options'=>array(
					  'minLength'=>'2',
			  ),
			  'htmlOptions'=>array(
					  'style'=>'width:575px',
			  ),
			));
		?>
	</div>
	
<?php $this->endWidget(); ?>
<!-- CJUIDIALOG END -->

<!-- CJUIDIALOG BEGIN termékcsoportok szerint  -->
<?php 
  $this->beginWidget('zii.widgets.jui.CJuiDialog', 
	   array(   'id'=>'termekcsoport_szerint_nyomtat' . $grid_id,
				'options'=>array(
								'title'=>'Nyomtatás termékcsoport(ok) szerint',
								'modal'=>true,
								'width'=>620,
								'height'=>230,
								'autoOpen'=>false,
  							    'buttons' => array('Nyomtatás' => 'js:function() {
									window.open("/index.php/raktarTermekek/printRaktarkeszletByTermekcsoport?termekcsoportok=" + $("#termekcsoportok").val(), "_blank");
								}'),
							),
						));
?>

	<div>
		<?php echo Chtml::label('Termékcsoport(ok) kiválasztása:', 'termekcsoportok'); ?>
	
		<?php $this->widget('application.extensions.multicomplete.MultiComplete', array(
			  'name'=>'termekcsoportok',
			  'splitter'=>',',
			  'sourceUrl'=>$this->createUrl('termekcsoportok/searchTermekcsoportok'),
			  'options'=>array(
					  'minLength'=>'1',
			  ),
			  'htmlOptions'=>array(
					  'style'=>'width:575px',
			  ),
			));
		?>
	</div>
	
<?php $this->endWidget(); ?>
<!-- CJUIDIALOG END -->

<!-- CJUIDIALOG BEGIN foglalt db megtekintéshez -->
<?php 
	// a dialógus ablak inicializálása
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id'=>'dialogFoglaltDbReszletek' . $grid_id,
		'options'=>array(
			'title'=>'Foglalt darabok listája',
			'autoOpen'=>false,
			'modal'=>true,
			'width'=>900,
			'height'=>580,
			'buttons' => array('Ok' => 'js:function() {
					$("#dialogFoglaltDbReszletek' . $grid_id . '").dialog("close");
								}'),
		),
	));?>
	
		<div id="divLoader" style="display:none">
			<p align='center' style='margin:50px'>
				<img src='../../../images/ajax-loader.gif' />
			</p>

			<p align='center'>
				Tételek lekérése ...
			</p>
		</div>
	
		<div class="divForFoglaltDb"></div>
	 
<?php $this->endWidget();?>


<script type="text/javascript">
	
		// LI: áthelyező dialog összerakása
		function openRelocateDialog (row_id, event) {
			event.preventDefault();
			
			grid_id = <?php echo $grid_id; ?>;

			<?php echo CHtml::ajax(array(
				'url'=> "js:'/index.php/raktarTermekek/termekAthelyez/id/' + row_id + '/grid_id/' + grid_id",
				'data'=> "js:$(this).serialize()",
				'type'=>'post',
				'id' => 'send-link-'.uniqid(),
				'replace' => '',
				'dataType'=>'json',
				'success'=>"function(data)
					{
						if (data.status == 'failure')
						{
							$('#termek_athelyez_dialog' + grid_id + ' div.divForForm').html(data.div);
						}
						else
						{
							$('#termek_athelyez_dialog' + grid_id + ' div.divForForm').html(data.div);
							$('#termek_athelyez_dialog' + grid_id).dialog('close');
						}
		 
					} "
			)); ?>

			$("#termek_athelyez_dialog" + grid_id).dialog("open");
			
			return false;
		}
		
		// LI: cikkszám(ok) szerinti nyomtatáshoz megjelenő cikkszám választó dialog
		function openCikkszamValaszto () {
			grid_id = <?php echo $grid_id; ?>;
			
			$("#cikkszam_szerint_nyomtat" + grid_id).dialog("open");
			
			return false;
		}

		// LI: termékcsoport(ok) szerinti nyomtatáshoz megjelenő termékcsoport választó dialog
		function openTermekcsoportValaszto () {
			grid_id = <?php echo $grid_id; ?>;
			
			$("#termekcsoport_szerint_nyomtat" + grid_id).dialog("open");
			
			return false;
		}
		
		// LI: foglalt db lista elkészítését végzi
		function openFoglaltDbListDialog (row_id) {
			grid_id = <?php echo $grid_id; ?>;

			// töröljük a DIV tartalmát az előző eredmények miatt
			$('#dialogFoglaltDbReszletek' + grid_id + ' div.divForFoglaltDb').html('');
			
			// loader ikon kirakása
			$('#divLoader').show();
			
			<?php echo CHtml::ajax(array(
				'url'=> "js:'/index.php/raktarTermekek/foglaltDbLista/id/' + row_id + '/reszletes/" . ($reszletesLista ? '1' : '0') . "/grid_id/' + grid_id",
				'data'=> "js:$(this).serialize()",
				'type'=>'post',
				'id' => 'send-link-'.uniqid(),
				'replace' => '',
				'dataType'=>'json',
				'success'=>"function(data)
					{
						$('#divLoader').hide();
						
						if (data.status == 'failure')
						{
							$('#dialogFoglaltDbReszletek' + grid_id).dialog('close');
						}
						else
						{
							$('#dialogFoglaltDbReszletek' + grid_id + ' div.divForFoglaltDb').html(data.div);
						}
		 
					} "
			)); ?>

			$("#dialogFoglaltDbReszletek" + grid_id).dialog("open");
			
			return false;
		}

</script>