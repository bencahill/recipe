<?php
$this->breadcrumbs=array(
	'Recipes'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'Update Recipe', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Recipe', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Recipes', 'url'=>array('admin')),
);
?>

<h1><?php echo $model->title; ?></h1>

<?php
$sections = array();
global $instructionCount;
$instructionCount = 1;
function numberInstructions($matches) {
	global $instructionCount;
	$withCount = $matches[1].$instructionCount.'. ';
	$instructionCount++;
	return $withCount;
}

if( $model->number_instructions ) {
	foreach( $model->sections as $section ) {
		$sections[] = preg_replace_callback("|(<p>)|","numberInstructions",$section);
	}
}
else {
	$sections = $model->sections;
}

$yields = '<table style="display:none"><tr class="yields"><td></td>';
$yieldIngredients = array( array('name'=>'Name', 'value'=>'$data->name') );
for( $i = 1; $i <= 5; $i++ ) {
	if( !empty( $model->{'yield'.$i} ) ) {
		$yields .= "<td><p>Yield</p>".nl2br($model->{'yield'.$i})."</td>";
		$yieldIngredients[] = array('name'=>'Quantity', 'value'=>'$data->quantity'.$i);
	}
}
$yields .= '<td></td></tr></table>';
$yieldIngredients[] = array(
	'name'=>'Instructions',
	'type'=>'raw',
	'value'=>function($data) use ($sections) {
		return $sections[$data->section_id];
	}
);

$topView = array();

if( empty( $model->yield2 ) ) {
	$topView[] = array(
		'name'=>'yield',
		'value'=>nl2br($model->yield1),
		'type'=>'raw',
	);
} else {
	echo $yields;
}

if( !empty( $model->description) ) {
	$topView[] = array(
		'name'=>'description',
		'value'=>nl2br($model->description),
		'type'=>'raw',
	);
}

$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>$topView,
));

$rawData = $model->getRelated('ingredients',false);

$dataProvider = new CArrayDataProvider($rawData, array(
	'sort'=>array(
		'defaultOrder'=>'position ASC',
	),
	'pagination'=>false,
));

$this->widget('ext.groupgridview.BootGroupGridView', array(
	'id'=>'ingredientView',
	'dataProvider'=>$dataProvider,
	'summaryText'=>'',
	'mergeCellCss'=>'vertical-align:middle;',
	'mergeColumns'=>array('Instructions'),
	'extraRowColumns'=>array('section_id'),
	'columns'=>$yieldIngredients,
));

$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'notes:html',
		'source',
		'columns',
		'category_id',
	),
));
?>

<script type="text/javascript">
$('.yields').prependTo('#ingredientView thead');
</script>
