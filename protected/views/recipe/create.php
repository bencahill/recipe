<?php
$this->breadcrumbs=array(
	'Recipes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Recipe', 'url'=>array('index')),
	array('label'=>'Manage Recipe', 'url'=>array('admin')),
);
?>

<div class="view id_section_copy" style="display:none;">
	<div class="row">
		<label for="Recipe_section">
		Instructions
		</label>
		<textarea name="Recipe[sections][]" id="Recipe_section"></textarea>
	</div>
</div>

<script type="text/javascript">
$(function() {
	$('.id_section_copy').appendTo('#mmf_sortable');
});
</script>

<h1>Create Recipe</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,
								'ingredient'=>$ingredient,'validatedIngredients'=>$validatedIngredients)); ?>
