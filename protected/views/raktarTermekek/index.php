<?php
/* @var $this TermekArakController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Raktárkészletek',
);

?>

<h1>Raktárkészletek</h1>

<?php	
	$this->widget('zii.widgets.jui.CJuiButton', array(
		'name'=>'button_print_raktarkeszlet',
		'caption'=>'Lista nyomtatás',
		'buttonType'=>'link',
		'url'=>Yii::app()->createUrl("raktarTermekek/printRaktarkeszlet"),
		'htmlOptions'=>array('class'=>'btn btn-success','target'=>'_blank'),
	));
?>

<div class="search-form">
	<?php  $this->renderPartial('_search',array(
		'model'=>$model,
	)); ?>
</div>

<?php 
    $this->widget('ext.groupgridview.BootGroupGridView', array(
      'id' => 'raktar_termekek_grid',
      'itemsCssClass'=>'items group-grid-view',
      'dataProvider' => $model -> search(),
      'extraRowColumns' => array('raktarHelyek.raktar.nev'),
      'mergeColumns' => array('raktarHelyek.raktar.nev', 'raktarHelyek.nev'),
      'columns' => array(
						array(
							'class' => 'bootstrap.widgets.TbButtonColumn',
							'htmlOptions'=>array('style'=>'width: 30px; text-align: left;'),
							'template' => '{relocate}',
							
							'buttons' => array(
								'relocate' => array(
									'url' => '',
									'label' => 'Átmozgat',
									'icon'=>'icon-white icon-move',
									'options'=>array(
												'class'=>'btn btn-info btn-mini',
												'onclick' => 'js: openPrintDialog($(this))',
												),
									'visible' => "Yii::app()->user->checkAccess('Megrendelesek.PrintProforma') || Yii::app()->user->checkAccess('Megrendelesek.PrintVisszaigazolas')",
								),
							),
						),
      	  				'raktarHelyek.raktar.nev',
						'raktarHelyek.nev',
						'anyagbeszallitas.bizonylatszam',
						'anyagbeszallitas.beszallitas_datum',
						'termek.DisplayTermekTeljesNev',
						'osszes_db:number',
						'foglalt_db:number',
						'elerheto_db:number',
      ),
	  
    ));

?>