<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Felhasználók listája', 'url'=>array('index')),
	array('label'=>'Felhasználó szerkesztése', 'url'=>array('admin')),
);
?>

<h1>Új felhasználó</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>