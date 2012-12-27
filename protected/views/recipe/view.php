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
global $instructionCount;
$instructionCount = 1;
function numberInstructions($matches) {
	global $instructionCount;
	$withCount = $matches[1].$instructionCount.'. ';
	$instructionCount++;
	return $withCount;
}
foreach( $model->sections as $section ) {

	$rawData = $model->getRelated('ingredients',false,array('condition'=>"section_id=$sectionId"));

	$dataProvider = new CArrayDataProvider($rawData, array(
		'sort'=>array(
			'defaultOrder'=>'position ASC',
		),
		'pagination'=>false,
	));

?>
<div class="instructions left">
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
<div class="instructions right<?php if($sectionId==0){echo ' first';} ?>">
<?php

	if( $model->number_instructions ) {
		echo preg_replace_callback("|(<p>)|","numberInstructions",$section);
	} else {
		echo $section;
	}

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
