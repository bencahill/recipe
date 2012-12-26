<?php
$this->breadcrumbs=array(
	'Recipes'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Recipe', 'url'=>array('index')),
	array('label'=>'Create Recipe', 'url'=>array('create')),
	array('label'=>'Update Recipe', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Recipe', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Recipe', 'url'=>array('admin')),
);
?>

<h1><?php echo $model->title; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
	),
));

$dataProvider = new CArrayDataProvider($model->ingredients, array(
	'sort'=>array(
		'defaultOrder'=>'position ASC',
	),
));

$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'summaryText'=>'',
	'columns'=>array(
		'quantity',
		'ingredient',
		'section_id',
	),
));

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'description',
		'notes',
		'source',
		'servings',
		'serving_unit',
		'category_id',
	),
));
?>
