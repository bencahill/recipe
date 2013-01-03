<div class="view">

	<h4><?php echo CHtml::link(CHtml::encode($data->title), array('view', 'id'=>$data->id)); ?></h4>

	<?php echo CHtml::encode($data->description); ?>

</div>