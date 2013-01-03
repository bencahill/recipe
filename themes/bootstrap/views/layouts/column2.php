<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row">
    <div class="span9">
        <div id="content">
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
    <div class="span3">
        <div id="sidebar">
        <?php
            $this->beginWidget('zii.widgets.CPortlet', array(
                'title'=>'Operations',
            ));
            $this->widget('bootstrap.widgets.TbMenu', array(
                'items'=>$this->menu,
                'htmlOptions'=>array('class'=>'operations'),
            ));
            $this->endWidget();
			if( Yii::app()->controller->id == 'recipe' && Yii::app()->controller->action->id == 'index' ) {
				$this->beginWidget('zii.widgets.CPortlet', array(
					'title'=>'Category',
				));
				echo CHtml::dropDownList('category',isset($_GET['category']) ? $_GET['category'] : '',array(''=>'View All') + Category::model()->listAll(), array('onchange'=>'window.location = "'.$this->createUrl('index').'"+($(this).val()?"category/":"")+$(this).val()'));
				$this->endWidget();
			}
        ?>
        </div><!-- sidebar -->
    </div>
</div>
<?php $this->endContent(); ?>