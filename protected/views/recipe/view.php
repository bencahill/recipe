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
		'yield',
		'id',
	),
));

$sectionId = 0;
foreach( $model->sections as $section ) {

	$rawData = $model->getRelated('ingredients',false,array('condition'=>"section_id=$sectionId"));

	$dataProvider = new CArrayDataProvider($rawData, array(
		'sort'=>array(
			'defaultOrder'=>'position ASC',
		),
		'pagination'=>false,
	));

?>
<div style="clear:both;width:50%;float:left;">
<?php

	$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$dataProvider,
		'summaryText'=>'',
		'columns'=>array(
			'quantity',
			'ingredient',
		),
		'hideHeader'=>($sectionId > 0) ? true : false,
	));

?>
</div>
<div style="width:45%;float:right;padding:20px 15px 15px;">
<?php

	echo $section;

?>
</div>
<?php

	$sectionId++;

}

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'description',
		'notes:html',
		'source',
		'category_id',
	),
));
?>
