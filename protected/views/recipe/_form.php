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
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'columns'); ?>
		<?php echo $form->dropDownList($model,'columns',array(1=>1,2=>2,3=>3,4=>4,5=>5)); ?>
		<?php echo $form->error($model,'columns'); ?>
	</div>

	<table class="yields mmf_table" style="display:none;">
		<tr>
			<td class="mmf_cell"></td>
			<td class="mmf_cell">
				<?php echo $form->labelEx($model,'yield1'); ?>
				<?php echo $form->textArea($model,'yield1',array('rows'=>2, 'cols'=>10)); ?>
				<?php echo $form->error($model,'yield1'); ?>
			</td>
			<td class="mmf_cell">
				<?php echo $form->labelEx($model,'yield2'); ?>
				<?php echo $form->textArea($model,'yield2',array('rows'=>2, 'cols'=>10)); ?>
				<?php echo $form->error($model,'yield2'); ?>
			</td>
			<td class="mmf_cell">
				<?php echo $form->labelEx($model,'yield3'); ?>
				<?php echo $form->textArea($model,'yield3',array('rows'=>2, 'cols'=>10)); ?>
				<?php echo $form->error($model,'yield3'); ?>
			</td>
			<td class="mmf_cell">
				<?php echo $form->labelEx($model,'yield4'); ?>
				<?php echo $form->textArea($model,'yield4',array('rows'=>2, 'cols'=>10)); ?>
				<?php echo $form->error($model,'yield4'); ?>
			</td>
			<td class="mmf_cell">
				<?php echo $form->labelEx($model,'yield5'); ?>
				<?php echo $form->textArea($model,'yield5',array('rows'=>2, 'cols'=>10)); ?>
				<?php echo $form->error($model,'yield5'); ?>
			</td>
			<td class="mmf_cell"></td>
		</tr>
		<?php
		$sectionCount = 0;
		global $sections;
		foreach( $sections as $section ):
			$sectionCount++;
		?>
			<tr class="mmf_row section">
				<td class="mmf_cell" colspan="6">
					<label for="Recipe_section_<?php echo $sectionCount; ?>_">
					Instructions
					</label>
		<?php
					$this->widget('ext.editMe.widgets.ExtEditMe', array(
						'name'=>'Recipe[sections][]',
						'htmlOptions'=>array(
							'rows'=>8,
							'cols'=>80,
							'id'=>'Recipe_section_'.$sectionCount.'_',
						),
						'value'=>$section,
						'toolbar'=>array(
							array( 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ),
							array( 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'SpellChecker', 'Scayt' ),
						),
					));
		?>
				</td>
				<td class="mmf_cell"></td>
			</tr>
		<?php
		endforeach;
		?>
	</table>

	<div id="scrollanchor"></div>

<?php
 
// see http://www.yiiframework.com/doc/guide/1.1/en/form.table
// Note: Can be a route to a config file too,
//       or create a method 'getMultiModelForm()' in the ingredient model
 
$ingredientFormConfig = array(
      'elements'=>array(
        'name'=>array(
            'type'=>'text',
            'size'=>16,
        ),
        'quantity1'=>array(
            'type'=>'text',
            'size'=>13,
        ),
        'quantity2'=>array(
            'type'=>'text',
            'size'=>13,
        ),
        'quantity3'=>array(
            'type'=>'text',
            'size'=>13,
        ),
        'quantity4'=>array(
            'type'=>'text',
            'size'=>13,
        ),
        'quantity5'=>array(
            'type'=>'text',
            'size'=>13,
        ),
        'section_id'=>array(
            'type'=>'hidden',
            'visible'=>false,
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
    $sections = $('.section');
    for( i = 0; i < $sections.length; i++ ) {
        $lastIng = $('.mmf_row').not('.section').find('[id*=section]').filter('[value='+i+']').last().parent();
        if( $lastIng.length > 0 ) {
            $('.section').not('#mmf_sortable .section').first().insertAfter($lastIng);
        } else {
            $('.section').not('#mmf_sortable .section').first().insertAfter($('.mmf_row').last());
        }
    }
    $('.section').last().appendTo($('#mmf_sortable'));
    addRemoveLink( $('.section').filter(':not(:last)') );

	$('#id_section').click(function() {
		var id = ($('.section').length + 1);
		$('.section textarea').last().ckeditorGet().destroy();
		$('.mmf_row:not(.section)').last().before($('.section').last());
		$('.mmf_row:not(.section)').last().after('<tr class="mmf_row section"> <td class="mmf_cell" colspan="2"> <label for="Recipe_section'+id+'"> Instructions </label> <textarea name="Recipe[sections][]" id="Recipe_section'+id+'"></textarea> </td> <td class="mmf_cell"></td> </tr>');
		$('#Recipe_section'+id).add($('.section textarea').get(-2)).ckeditor({'toolbar':[['Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat'],['NumberedList','BulletedList','-','Outdent','Indent','-','SpellChecker','Scayt']],'forcePasteAsPlainText':true,'extraPlugins':'','removeDialogTabs':'','contentsCss':['/assets/e07a29c9/contents.css'],'resize_enabled':true,'resize_dir':'both','autoGrow_onStartup':false,'language':'','baseHref':'','bodyClass':'','bodyId':'','docType':'','filebrowserBrowseUrl':'','filebrowserFlashBrowseUrl':'','filebrowserImageBrowseUrl':'','filebrowserFlashUploadUrl':'','filebrowserUploadUrl':'','filebrowserImageBrowseLinkUrl':'','filebrowserImageUploadUrl':'','fullPage':false,'height':200,'width':'','uiColor':'','disableNativeSpellChecker':false,'autoUpdateElement':true});
		addRemoveLink( $('.section').get(-2) );
		return false;
	});
	sectionCalc();
	$('.mmf_row.id_ingredient_copy input[id=Ingredient_name]').keydown(function(event) {
		if(event.which >= 48 && event.which <= 90) {
			$('#id_ingredient').click();
			$($('.mmf_row.id_ingredient_copy').get(-2)).find('input[id*=name]').focus();
			$('.mmf_row.id_ingredient_copy input[id*=name]').filter(':not(:last)').unbind('keydown');
		}
	});
	$('input').keydown(function(event) {
		if(event.which == 13) {
			event.preventDefault();
			var $this = $(this);
			var $inputs = $('input,textarea').filter(':visible');
			var index = $inputs.index($this);
			var next = $inputs.get((index+1));
			$this.blur();
			$(next).select().focus();
		}
	});
	$('.yields').insertBefore('.mmf_table:not(.yields)').show();
	$('<tr><td class="mmf_cell"></td><td class="mmf_cell"></td><td class="mmf_cell"></td><td class="mmf_cell"></td><td class="mmf_cell"></td><td class="mmf_cell"></td><td class="mmf_cell"></td></tr>').prependTo($('.mmf_table:not(.yields) thead'));
	updateColumns();
	$('#Recipe_columns').change(function() {
		updateColumns();
	});
	$(".mmf_table.yields").width($('.mmf_table:not(.yields) thead').width());
	var a = function() {
		var b = $(window).scrollTop();
		var s = $("#scrollanchor");
		var d = s.offset().top;
		var e = $(".section").last().offset().top;
		var c=$(".mmf_table.yields");
		if (b>d && b<e) {
			c.css({position:"fixed",top:"0px"});
			s.height(c.outerHeight());
		} else {
			c.css({position:"relative",top:""});
			s.height(0);
		}
	};
	$(window).scroll(a);a()
});
</script>

<a id="id_section" href="#" tabindex="-1">Add section</a>

	<div class="row">
<?php
$this->widget('ext.editMe.widgets.ExtEditMe', array(
	'model'=>$model,
	'attribute'=>'notes',
	'toolbar'=>array(
		array( 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ),
		array( 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'SpellChecker', 'Scayt' ),
	),
));
?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'number_instructions'); ?>
		<?php echo $form->checkBox($model,'number_instructions',array('value'=>'1','uncheckValue'=>0)); ?>
		<?php echo $form->error($model,'number_instructions'); ?>
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
