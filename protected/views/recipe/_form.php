<div class="form">

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
		<?php echo $form->textArea($model,'title',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'title'); ?>
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
            'maxlength'=>40,
        ),
        'measurement'=>array(
            'type'=>'text',
            'maxlength'=>40,
        ),
        'ingredient'=>array(
            'type'=>'textarea',
        ),
        'notes'=>array(
            'type'=>'textarea',
        ),
    ));
 
$this->widget('ext.multimodelform.MultiModelForm',array(
        'id' => 'id_ingredient', //the unique widget id
        'formConfig' => $ingredientFormConfig, //the form configuration array
		'model' => $ingredient, //instance of the form model
		'sortAttribute' => 'position', //if assigned: sortable fieldsets is enabled
 
        //if submitted not empty from the controller,
        //the form will be rendered with validation errors
        'validatedItems' => $validatedIngredients,
 
        //array of ingredient instances loaded from db
        'data' => $ingredient->findAll(array('condition'=>'recipe_id=:recipeId', 'order'=>'position', 'params'=>array(':recipeId'=>$model->id))),
    ));
?>

	<div class="row">
		<?php echo $form->labelEx($model,'instructions'); ?>
		<?php echo $form->textArea($model,'instructions',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'instructions'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'notes'); ?>
		<?php echo $form->textArea($model,'notes',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'notes'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'source'); ?>
		<?php echo $form->textArea($model,'source',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'source'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'servings'); ?>
		<?php echo $form->textField($model,'servings'); ?>
		<?php echo $form->error($model,'servings'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'serving_unit'); ?>
		<?php echo $form->textArea($model,'serving_unit',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'serving_unit'); ?>
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
