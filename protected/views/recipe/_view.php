<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notes')); ?>:</b>
	<?php echo CHtml::encode($data->notes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('source')); ?>:</b>
	<?php echo CHtml::encode($data->source); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('columns')); ?>:</b>
	<?php echo CHtml::encode($data->columns); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('yield1')); ?>:</b>
	<?php echo CHtml::encode($data->yield1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('yield2')); ?>:</b>
	<?php echo CHtml::encode($data->yield2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('yield3')); ?>:</b>
	<?php echo CHtml::encode($data->yield3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('yield4')); ?>:</b>
	<?php echo CHtml::encode($data->yield4); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('yield5')); ?>:</b>
	<?php echo CHtml::encode($data->yield5); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('category_id')); ?>:</b>
	<?php echo CHtml::encode($data->category_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('author_id')); ?>:</b>
	<?php echo CHtml::encode($data->author_id); ?>
	<br />

	*/ ?>

</div>