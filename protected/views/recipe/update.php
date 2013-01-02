<?php
$this->breadcrumbs=array(
	'Recipes'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'View Recipe', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Recipes', 'url'=>array('admin')),
);
?>

<?php
global $sections;
if( empty($_POST['Recipe']) ) {
	$sections = $model->sections;
} else {
	$sections = $_POST['Recipe']['sections'];
}
?>

<h1>Update <em><?php echo $model->title; ?></em></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,
								'ingredient'=>$ingredient,'validatedIngredients'=>$validatedIngredients)); ?>
