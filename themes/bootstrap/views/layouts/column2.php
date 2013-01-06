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
				$links = array();
				foreach( Category::model()->listAll() as $id => $name ) {
					$links[] = array( 'label'=>$name, 'url'=>$this->createUrl('recipe/index',array('category'=>$id)) );
				}
				$links[] = '---';
				$links[] = array('label'=>'View All', 'url'=>$this->createUrl('recipe/index'));
				$this->widget('bootstrap.widgets.TbButtonGroup', array(
					'buttons'=>array(
						array('label'=>'Filter by Category', 'items'=>$links),
					),
				));
			}
        ?>
        </div><!-- sidebar -->
    </div>
</div>
<?php $this->endContent(); ?>