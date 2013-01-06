<?php if ($id1 == -1 || $id2 == -1): ?>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'compareSelect',
	'type'=>'vertical',
	'method'=>'get',
));

$rawData = Yii::app()->db->createCommand('SELECT id,title FROM tbl_recipe')->queryAll();
$titles = array();
array_walk( $rawData, function($a) use (&$titles) { $titles[$a['id']] = $a['title']; } );
?>

<fieldset>

<label for="id1">First</label>
<?php $this->widget('ext.chosen.Chosen', array(
	'id'=>'id1',
	'name'=>'id1',
	'data'=>$titles,
)); ?>

<hr>

<label for="id2">Second</label>
<?php $this->widget('ext.chosen.Chosen', array(
	'id'=>'id2',
	'name'=>'id2',
	'data'=>$titles,
)); ?>

</fieldset>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Submit', 'htmlOptions'=>array('name'=>'',))); ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
$(function() {
	$('#compareSelect').submit(function() {
		window.location.href = window.location.href.replace(/\/$/, '') + '/' + $('#id1').val() + ',' + $('#id2').val();
		return false;
	});
});
</script>
<?php else: ?>
<iframe style="display:block;width:100%;" frameBorder="0" src="<?php echo $this->createUrl('recipe/view',array('id'=>$id1));?>"></iframe>
<iframe style="display:block;width:100%;" frameBorder="0" src="<?php echo $this->createUrl('recipe/view',array('id'=>$id2));?>"></iframe>

<script type="text/javascript">
$(function() {
	$('iframe').load(function() {
		$(this).contents().find('link').filter('[href*=print]').attr('media','screen,print');
		setTimeout(function() {
			$('iframe').each(function() {
				$this = $(this);
				$this.height($this.contents().find('body').height()+1);
			});
		}, 50);
	});
});
</script>
<?php endif; ?>
