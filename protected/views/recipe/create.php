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

<table style="display:none;">
	<tr class="mmf_row section">
		<td class="mmf_cell" colspan="2">
			<label for="Recipe_section">
			Instructions
			</label>
			<textarea rows="8" cols="80" name="Recipe[sections][]" id="Recipe_section"></textarea>
		</td>
		<td class="mmf_cell"></td>
	</tr>
</table>

<script type="text/javascript">
$(function() {
	$('.section').appendTo('#mmf_sortable');
});
</script>

<h1>Create Recipe</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,
								'ingredient'=>$ingredient,'validatedIngredients'=>$validatedIngredients)); ?>
