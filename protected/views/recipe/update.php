<?php
$this->breadcrumbs=array(
	'Recipes'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Recipe', 'url'=>array('index')),
	array('label'=>'Create Recipe', 'url'=>array('create')),
	array('label'=>'View Recipe', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Recipe', 'url'=>array('admin')),
);
?>

<?php
$sectionCount = 0;
foreach( $model->sections as $section ):
	$sectionCount++;
?>
<table style="display:none;">
	<tr class="mmf_row section">
		<td class="mmf_cell" colspan="2">
			<label for="Recipe_section_<?php echo $sectionCount; ?>_">
			Instructions
			</label>
			<textarea rows="8" cols="80" name="Recipe[sections][]" id="Recipe_section_<?php echo $sectionCount; ?>_"><?php echo $section; ?></textarea>
		</td>
		<td class="mmf_cell"></td>
	</tr>
</table>
<?php
endforeach;
?>

<script type="text/javascript">
$(function() {
	$sections = $('.section');
	for( i = 0; i < $sections.length; i++ ) {
		$lastIng = $('.mmf_row').not('.section').find('[id*=section]').filter('[value='+i+']').last().parent();
		$('.section').not('#mmf_sortable .section').first().insertAfter($lastIng);
	}
	$('.section').last().appendTo($('#mmf_sortable'));
	addRemoveLink( $('.section').filter(':not(:last)') );
});
</script>

<h1>Update Recipe <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,
								'ingredient'=>$ingredient,'validatedIngredients'=>$validatedIngredients)); ?>
