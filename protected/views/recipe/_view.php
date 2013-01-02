<div class="view">

	<h3><?php echo CHtml::link(CHtml::encode($data->title), array('view', 'id'=>$data->id)); ?></h3>

	<?php echo CHtml::encode($data->description); ?>

</div>