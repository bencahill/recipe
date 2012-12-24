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
<div class="view id_section_copy" style="display:none;">
	<div class="row">
		<label for="Recipe_section_<?php echo $sectionCount; ?>_">
		Instructions
		</label>
		<textarea name="Recipe[sections][]" id="Recipe_section_<?php echo $sectionCount; ?>_"><?php echo $section; ?></textarea>
	</div>
</div>
<?php
endforeach;
?>

<script type="text/javascript">
$(function() {
	$sections = $('.id_section_copy');
	for( i = 0; i < $sections.length; i++ ) {
		$lastIng = $('.view').not('.id_section_copy').find('[id*=section]').filter('[value='+i+']').last().parent();
		$('.id_section_copy').not('#mmf_sortable .id_section_copy').first().insertAfter($lastIng);
	}
	$('.id_section_copy').last().appendTo($('#mmf_sortable'));
	addRemoveLink( $('.id_section_copy').filter(':not(:last)') );
});
</script>

<h1>Update Recipe <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,
								'ingredient'=>$ingredient,'validatedIngredients'=>$validatedIngredients)); ?>
