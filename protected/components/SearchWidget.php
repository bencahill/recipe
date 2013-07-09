<?php
Yii::import('zii.widgets.CPortlet');

class SearchWidget extends CPortlet
{
	protected function renderContent()
	{
		$model = new Recipe;
		$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'id'=>'searchForm',
			'type'=>'search',
			'method'=>'get',
			'action'=>'search',
		));

		echo $form->textFieldRow($model, 'title', array('class'=>'input-medium', 'prepend'=>'<i class="icon-search"></i>', 'id'=>'q', 'name'=>'q'));
		$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Search'));

		$this->endWidget();
		?><script type="text/javascript">$(function() { $('#searchForm #q').attr('placeholder',''); });</script><?php
	}
}
?>
