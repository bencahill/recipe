<div class="form">

<?php Yii::app()->clientScript->registerScriptFile(
    Yii::app()->baseUrl.'/js/sections.js'
); ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'recipe-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php
	//show errorsummary at the top for all models
	//build an array of all models to check
	echo $form->errorSummary(array_merge(array($model),$validatedIngredients));
?>
	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title'); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'yield'); ?>
		<?php echo $form->textField($model,'yield'); ?>
		<?php echo $form->error($model,'yield'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

<?php
 
// see http://www.yiiframework.com/doc/guide/1.1/en/form.table
// Note: Can be a route to a config file too,
//       or create a method 'getMultiModelForm()' in the ingredient model
 
$ingredientFormConfig = array(
      'elements'=>array(
        'quantity'=>array(
            'type'=>'text',
            'size'=>12,
        ),
        'ingredient'=>array(
            'type'=>'text',
            'size'=>24,
        ),
        'section_id'=>array(
            'type'=>'hidden',
        ),
    ));

$this->widget('ext.multimodelform.MultiModelForm',array(
        'id' => 'id_ingredient', //the unique widget id
        'formConfig' => $ingredientFormConfig, //the form configuration array
		'model' => $ingredient, //instance of the form model
		'sortAttribute' => 'position', //if assigned: sortable fieldsets is enabled
		'tableView' => true,
 
        //if submitted not empty from the controller,
        //the form will be rendered with validation errors
        'validatedItems' => $validatedIngredients,
 
        //array of ingredient instances loaded from db
        'data' => $ingredient->findAll(array('condition'=>'recipe_id=:recipeId', 'order'=>'position', 'params'=>array(':recipeId'=>$model->id))),
    ));
?>

<script type="text/javascript">
$(function() {
	$('#id_section').relCopy();
	sectionCalc();
	$('.mmf_row.id_ingredient_copy input[id=Ingredient_quantity]').keydown(function(event) {
		if(event.which >= 48 && event.which <= 90) {
			$('#id_ingredient').click();
			$($('.mmf_row.id_ingredient_copy').get(-2)).find('input[id*=quantity]').focus();
			$('.mmf_row.id_ingredient_copy input[id*=quantity]').filter(':not(:last)').unbind('keydown');
		}
	});
	$('.mmf_cell input').keydown(function(event) {
		if(event.which == 13) {
			event.preventDefault();
			var $this = $(this);
			var $inputs = $('.mmf_cell input');
			var index = $inputs.index($this);
			var next = $inputs.get((index+1));
			$this.blur();
			$(next).select().focus();
		}
	});
});
</script>

<a id="id_section" href="#" rel=".section" tabindex="-1">Add section</a>

	<div class="row">
		<?php echo $form->labelEx($model,'notes'); ?>
		<?php echo $form->textArea($model,'notes',array('rows'=>8, 'cols'=>80)); ?>
		<?php echo $form->error($model,'notes'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'source'); ?>
		<?php echo $form->textField($model,'source'); ?>
		<?php echo $form->error($model,'source'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo $form->textField($model,'category_id'); ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
