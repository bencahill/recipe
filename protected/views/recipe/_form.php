<div class="form">

<?php Yii::app()->clientScript->registerScriptFile(
    Yii::app()->baseUrl.'/js/sections.js'
); ?>

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'horizontalForm',
    'type'=>'vertical',
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

<fieldset>

<?php
	//show errorsummary at the top for all models
	//build an array of all models to check
	echo $form->errorSummary(array_merge(array($model),$validatedIngredients));
?>
	<?php echo $form->textFieldRow($model,'title'); ?>
	<?php echo $form->textAreaRow($model,'description',array('rows'=>6,'cols'=>50)); ?>
	<?php echo $form->dropDownListRow($model,'columns',array(1=>1,2=>2,3=>3,4=>4,5=>5)); ?>

	<table class="yields mmf_table" style="display:none;">
		<tr>
			<td class="mmf_cell"></td>
			<td class="mmf_cell">
				<?php echo $form->labelEx($model,'yield1'); ?>
				<?php echo $form->textArea($model,'yield1',array('rows'=>2, 'cols'=>13)); ?>
				<?php echo $form->error($model,'yield1'); ?>
			</td>
			<td class="mmf_cell">
				<?php echo $form->labelEx($model,'yield2'); ?>
				<?php echo $form->textArea($model,'yield2',array('rows'=>2, 'cols'=>13)); ?>
				<?php echo $form->error($model,'yield2'); ?>
			</td>
			<td class="mmf_cell">
				<?php echo $form->labelEx($model,'yield3'); ?>
				<?php echo $form->textArea($model,'yield3',array('rows'=>2, 'cols'=>13)); ?>
				<?php echo $form->error($model,'yield3'); ?>
			</td>
			<td class="mmf_cell">
				<?php echo $form->labelEx($model,'yield4'); ?>
				<?php echo $form->textArea($model,'yield4',array('rows'=>2, 'cols'=>13)); ?>
				<?php echo $form->error($model,'yield4'); ?>
			</td>
			<td class="mmf_cell">
				<?php echo $form->labelEx($model,'yield5'); ?>
				<?php echo $form->textArea($model,'yield5',array('rows'=>2, 'cols'=>13)); ?>
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
							array( 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'SpellChecker', 'Scayt', '-', 'Format' ),
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
        ),
        'position'=>array(
            'type'=>'hidden',
        ),
    ));

$ckeCss = Yii::app()->assetManager->getPublishedUrl( Yii::getPathOfAlias('ext.editMe.vendors.CKEditor') ) . '/contents.css';
$ckeOptions = '{"toolbar":[["Bold","Italic","Underline","Strike","Subscript","Superscript","-","RemoveFormat"],["NumberedList","BulletedList","-","Outdent","Indent","-","SpellChecker","Scayt","-","Format"]],"forcePasteAsPlainText":true,"extraPlugins":"","removeDialogTabs":"","contentsCss":["' . $ckeCss . '"],"resize_enabled":true,"resize_dir":"both","autoGrow_onStartup":false,"language":"","baseHref":"","bodyClass":"","bodyId":"","docType":"","filebrowserBrowseUrl":"","filebrowserFlashBrowseUrl":"","filebrowserImageBrowseUrl":"","filebrowserFlashUploadUrl":"","filebrowserUploadUrl":"","filebrowserImageBrowseLinkUrl":"","filebrowserImageUploadUrl":"","fullPage":false,"height":200,"width":"","uiColor":"","disableNativeSpellChecker":false,"autoUpdateElement":true}';

$this->widget('ext.multimodelform.MultiModelForm',array(
        'id' => 'id_ingredient', //the unique widget id
        'formConfig' => $ingredientFormConfig, //the form configuration array
		'model' => $ingredient, //instance of the form model
		'sortAttribute' => 1, //if assigned: sortable fieldsets is enabled
		'tableView' => true,
		'removeHtmlOptions' => array( 'tabindex'=>-1 ),
		'hideCopyTemplate' => false,
		'sortOptions' => array(
			'placeholder' => 'ui-state-highlight',
			'opacity' => 0.8,
			'cursor' => 'move',
			'items' => '.mmf_row:not(:last)',
			'start' => 'js:function( event, ui) {
				$(ui.item).find("textarea").each(function() {
					$(this).ckeditorGet().destroy();
				});
				ui.placeholder.height(ui.item.height());
			}',
			'stop' => 'js:function( event, ui) {
				sectionCalc();
				$(ui.item).find("textarea").ckeditor(' . $ckeOptions . ');
			}',
		),
 
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
		$('.mmf_row:not(.section)').last().after('<tr class="mmf_row section"> <td class="mmf_cell" colspan="6"> <label for="Recipe_section'+id+'"> Instructions </label> <textarea name="Recipe[sections][]" id="Recipe_section'+id+'"></textarea> </td> <td class="mmf_cell"></td> </tr>');
		$('#Recipe_section'+id).add($('.section textarea').get(-2)).ckeditor(<?php echo $ckeOptions; ?>);
		addRemoveLink( $('.section').get(-2) );
		$('.mmf_row:not(.section)').last().find('input[id*=name]').focus();
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
	var a = function() {
		var b = $(window).scrollTop();
		var s = $("#scrollanchor");
		var d = s.offset().top;
		var e = $(".section").last().offset().top;
		var c=$(".mmf_table.yields");
		if (b>d && b<e) {
			c.css({position:"fixed",top:$('.navbar').outerHeight()+"px"});
			s.height(c.outerHeight());
		} else {
			c.css({position:"relative",top:""});
			s.height(0);
		}
	};
	$(window).scroll(a);a();
	$('#Recipe_title').bind('input', function() {
		$('h1 em').text($('#Recipe_title').val());
	});
	$('#id_ingredient').attr('tabindex',-1);
	$('#Recipe_title').focus();
	$('.mmf_table input').keydown(function(event, ui) {
		if(event.which == 13 || event.which == 9) {
			var $this = $(this);
			var $inputs = $('input,iframe').filter(':visible');
			var index = $inputs.index($this);
			var next = $inputs.get((index+1));
			$window = $(window);
			$window.scrollTop($(next).offset().top - ($window.height()/2));
		}
	});
});
</script>

<a id="id_section" href="#" tabindex="-1">Add section</a>

<label for="Recipe_notes">
Notes
</label>
<?php
$this->widget('ext.editMe.widgets.ExtEditMe', array(
	'model'=>$model,
	'attribute'=>'notes',
	'toolbar'=>array(
		array( 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ),
		array( 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'SpellChecker', 'Scayt', '-', 'Format' ),
	),
));
?>

	<?php echo $form->checkBoxRow($model,'number_instructions',array('value'=>1,'uncheckValue'=>0)); ?>
	<?php echo $form->textFieldRow($model,'source'); ?>
	<?php echo $form->dropDownListRow($model,'category_id',Category::model()->listAll()); ?>

</fieldset>
 
<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Submit')); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
