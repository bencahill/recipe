<?php
$breadcrumbs = array();
if( ! Yii::app()->user->isGuest ) {
	$breadcrumbs['Recipes'] = array('index');
}
$breadcrumbs[] = $model->title;

$this->breadcrumbs=$breadcrumbs;

if( ! Yii::app()->user->isGuest ) {
	$this->menu=array(
		array('label'=>'Update Recipe', 'url'=>array('update', 'id'=>$model->id)),
		array('label'=>'Delete Recipe', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
		array('label'=>'Manage Recipes', 'url'=>array('admin')),
	);
}
?>

<h1><?php echo CHtml::link(CHtml::encode($model->title), array('view', 'id'=>$model->id)); ?></h1>
<?php if( ! Yii::app()->user->isGuest ) { ?>
<span class="category"><?php echo CHtml::link(CHtml::encode($model->category->name), array('index', 'category'=>$model->category_id)); ?></span>
<?php } ?>

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

$formatFractions = function( $quantity ) {
	return preg_replace( '/(\d)\/(\d)/', '<sup>\1</sup>&frasl;<sub>\2</sub>', $quantity );
};

$yields = '<table style="display:none"><tr class="yields"><td></td><td><p>Yield</p>'.nl2br($model->yield1).'</td>';
$yieldIngredients = array( array('name'=>'Ingredients', 'value'=>'$data["name"]'),
	array('name'=>'Quantity', 'type'=>'raw', 'value'=>function($data) use ($formatFractions) {
		return $formatFractions($data["quantity1"]);
	}),
);
for( $i = 2; $i <= 5; $i++ ) {
	if( $i <= $model->columns ) {
		$yields .= "<td><p>Yield</p>".nl2br($model->{'yield'.$i})."</td>";
		$yieldIngredients[] = array('name'=>'Quantity', 'type'=>'raw', 'value'=>function($data) use ($formatFractions, $i) {
			return $formatFractions($data["quantity$i"]);
		});
	}
}
$yields .= '<td></td></tr></table>';
$yieldIngredients[] = array(
	'name'=>'Instructions',
	'type'=>'raw',
	'value'=>function($data) use ($sections, $formatFractions) {
		return $formatFractions( $sections[$data["section_id"]] );
	}
);

$topView = array();

if( empty( $model->yield2 ) ) {
	if( !empty( $model->yield1 ) ) {
		$topView[] = array(
			'name'=>'yield',
			'value'=>nl2br($model->yield1),
			'type'=>'raw',
		);
	}
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

$id = $model->id;
$command=Yii::app()->db->createCommand('SELECT * FROM tbl_ingredient WHERE recipe_id=?');
$command->bindParam(1,$id);
$command->execute();
$rawData=$command->queryAll();
$lastIngredient = array_slice($rawData, -1, 1);
$modelSectionCount = ( count($model->sections) - 1 );
if( $lastIngredient[0]['section_id'] < $modelSectionCount ) {
	$rawData[] = array(
		'id'=>0,
		'section_id'=>$modelSectionCount,
		'position'=>9999999,
		'name'=>'',
		'quantity1'=>'',
		'quantity2'=>'',
		'quantity3'=>'',
		'quantity4'=>'',
		'quantity5'=>'',
	);
}

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

$bottomList = array();
if( !empty($model->notes) ) {
	$bottomList[] = array(
		'name'=>'Notes',
		'type'=>'raw',
		'value'=>$formatFractions( $model->notes )
	);
}
if( !empty($model->source) ) {
	$bottomList[] = 'source';
}

$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>$bottomList,
));
?>

<script type="text/javascript">
$(function() {
	$('.yields').prependTo('#ingredientView thead');
	$('.extrarow').each(function() {
		$this = $(this);
		$this.attr('colspan','');
		for (var i=1; i<<?php echo ($model->columns + 2); ?>; i++) {
			$this.clone().insertAfter($this);
		}
	});
<?php if( $model->columns <= 3 ): ?>
	$('#ingredientView th:nth-child(2), #ingredientView td:nth-child(2), #ingredientView th:nth-child(3), #ingredientView td:nth-child(3), #ingredientView th:nth-child(4), #ingredientView td:nth-child(4), #ingredientView th:nth-child(5), #ingredientView td:nth-child(5), #ingredientView th:nth-child(6), #ingredientView td:nth-child(6)').width('<?php echo ($model->columns == 3) ? 15 : 20; ?>%');
<?php endif; ?>
});
</script>
