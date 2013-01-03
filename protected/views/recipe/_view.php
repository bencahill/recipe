<div class="view">

	<h4><?php echo CHtml::link(CHtml::encode($data->title), array('view', 'id'=>$data->id)); ?>
	<span class="category">(<?php echo CHtml::link(CHtml::encode($data->category->name), array('index', 'category'=>$data->category_id)); ?>)</span>
	</h4>

	<?php echo CHtml::encode($data->description); ?>

</div>