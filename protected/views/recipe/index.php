<?php
$this->breadcrumbs=array(
	'Recipes',
);

$this->menu=array(
	array('label'=>'Manage Recipes', 'url'=>array('admin')),
);
?>

<h1><?php echo empty($category) ? 'Recipes' : $category; ?></h1>

<?php $this->widget('bootstrap.widgets.TbListView', array(
	'id'=>'indexView',
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
