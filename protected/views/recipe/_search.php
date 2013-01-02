<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'title'); ?>
		<?php echo $form->textArea($model,'title',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'notes'); ?>
		<?php echo $form->textArea($model,'notes',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'source'); ?>
		<?php echo $form->textArea($model,'source',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'columns'); ?>
		<?php echo $form->textField($model,'columns'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'yield1'); ?>
		<?php echo $form->textField($model,'yield1'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'yield2'); ?>
		<?php echo $form->textField($model,'yield2'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'yield3'); ?>
		<?php echo $form->textField($model,'yield3'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'yield4'); ?>
		<?php echo $form->textField($model,'yield4'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'yield5'); ?>
		<?php echo $form->textField($model,'yield5'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'category_id'); ?>
		<?php echo $form->textField($model,'category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'author_id'); ?>
		<?php echo $form->textField($model,'author_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->