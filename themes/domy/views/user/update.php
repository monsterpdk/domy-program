<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Felhasználók listája', 'url'=>array('index')),
	array('label'=>'Új felhasználó', 'url'=>array('create')),
	array('label'=>'Felhasználó megjelenítése', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Felhasználó szerkesztése', 'url'=>array('admin')),
);
?>

<h2> <?php echo $model->username; ?> felhasználó szerkesztése </h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>