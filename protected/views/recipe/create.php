<?php
$this->breadcrumbs=array(
	'Recipes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Recipes', 'url'=>array('admin')),
);

global $sections;
if( empty($_POST['Recipe']) ) {
	$sections = array('');
} else {
	$sections = $_POST['Recipe']['sections'];
}
?>

<h1>Create Recipe</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,
								'ingredient'=>$ingredient,'validatedIngredients'=>$validatedIngredients)); ?>
