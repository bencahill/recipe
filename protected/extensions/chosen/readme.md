Chosen usage instructions
===========================

1. Checkout source code to your project, for example to ext.chosen.
2. Use it, as any input widget.

Example:

    $this->widget('ext.chosen.Chosen',array(
        'name' => 'inputName', // input name
        'value' => '2', // selection
        'data' => array( // list of select options
            '1'=>'Option 1',
            '2'=>'Option 2',
            '3'=>'Option 3',
            '4'=>'Option 4',
        ),
    ));

Also you can use it like CHtml helper
----------------------------------------
Before this import ext.chosen.Chosen, you can add it to config/main.php or call Yii::import('ext.chosen.Chosen') before usage.

	Chosen::dropDownList($name, $select, $data, $htmlOptions);
    Chosen::activeDropDownList($model, $attribute, $data, $htmlOptions);
    Chosen::multiSelect($name, $select, $data, $htmlOptions);
    Chosen::activeMultiSelect($model, $attribute, $data, $htmlOptions);

