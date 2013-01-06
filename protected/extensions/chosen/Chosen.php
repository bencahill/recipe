<?php
/**
 * Widget to use Chosen in Yii application.
 *
 * Chosen script:
 * @link http://harvesthq.github.com/chosen/
 *
 * @author Bogdan Savluk <savluk.bogdan@gmail.com>
 */
class Chosen extends CInputWidget
{
    /** @var string Path to assets directory published in init() */
    private $assetsDir;

    /** @var bool Multiple or single item should be selected */
    public $multiple = false;

    /** @var string|null If is set will override default label "Select Some Options" */
    public $placeholderMultiple;

    /** @var string|null If is set will override default label "Select an Option" */
    public $placeholderSingle;

    /**
     * @var bool Allow deselect single selected item from dropDown.
     * Chosen will add a UI element for option deselection.
     * This will only work if the first option has blank text.
     */
    public $allowSingleDeselect = true;

    /** @var string|null If is set will override default label "No results match" */
    public $noResults;

    /** @var array Chosen script settings passed to $.fn.chosen() */
    private $settings = array();

    /** @var array See CHtml::listData() */
    public $data;
    /** @var bool hidden input with empty selection before widget, so if no option selected(with this option) - empty field would be send*/
    public $sendEmpty = true;

    /** Publish assets and set default values for properties */
    public function init()
    {
        $dir = dirname(__FILE__) . '/assets';
        $this->assetsDir = Yii::app()->assetManager->publish($dir);

        if ($this->multiple) {
            if (isset($this->htmlOptions['multiple']))
                $this->multiple = true;
            elseif ($this->multiple)
                $this->htmlOptions['multiple'] = true;
        }
        if ($this->multiple) {
            if (isset($this->placeholderMultiple))
                $this->htmlOptions['data-placeholder'] = $this->placeholderMultiple;
            else
                $this->htmlOptions['data-placeholder'] = Yii::t('Chosen.main', "Select Some Options");
        } else {

            if (isset($this->placeholderSingle))
                $this->htmlOptions['data-placeholder'] = $this->placeholderSingle;
            else
                $this->htmlOptions['data-placeholder'] = Yii::t('Chosen.main', "Select an Option");
        }

        if (isset($this->noResults))
            $this->settings['no_results_text'] = $this->noResults;
        else
            $this->settings['no_results_text'] = Yii::t('Chosen.main', "No results match");
        if (!$this->multiple)
            $this->settings['allow_single_deselect'] = $this->allowSingleDeselect;
    }

    /** Render widget html and register client scripts */
    public function run()
    {
        list($name, $id) = $this->resolveNameID();
        if (isset($this->htmlOptions['id']))
            $id = $this->htmlOptions['id'];
        else
            $this->htmlOptions['id'] = $id;
        if (isset($this->htmlOptions['name']))
            $name = $this->htmlOptions['name'];

        if ($this->multiple && substr($name, -2) !== '[]')
            $name .= '[]';

        if ($this->multiple && $this->sendEmpty) {
            echo CHtml::hiddenField(substr($name, 0,-2), '', array('id' => false));
        }
        if (isset($this->model)) {
            echo CHtml::dropDownList($name, CHtml::value($this->model, $this->attribute), $this->data, $this->htmlOptions);
        } else {
            echo CHtml::dropDownList($name, $this->value, $this->data, $this->htmlOptions);
        }
        $this->registerScripts($id);
    }

    /** Register client scripts */
    private function registerScripts($id)
    {
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        if (defined('YII_DEBUG'))
            $cs->registerScriptFile($this->assetsDir . '/chosen.jquery.js');
        else
            $cs->registerScriptFile($this->assetsDir . '/chosen.jquery.min.js');

        $cs->registerCssFile($this->assetsDir . '/chosen.css');

        $settings = CJavaScript::encode($this->settings);
        $cs->registerScript("{$id}_chosen", "$('#{$id}').chosen({$settings});");
    }

    /** Single item select */
    public static function dropDownList($name, $select, $data, $htmlOptions = array())
    {
        return Yii::app()->getController()->widget(__CLASS__, array(
            'name' => $name,
            'value' => $select,
            'data' => $data,
            'htmlOptions' => $htmlOptions,
        ), true);
    }

    public static function activeDropDownList($model, $attribute, $data, $htmlOptions = array())
    {
        return self::dropDownList(CHtml::activeName($model, $attribute), CHtml::value($model, $attribute), $data, $htmlOptions);
    }

    /** Multiple items select */
    public static function multiSelect($name, $select, $data, $htmlOptions = array())
    {
        if (substr($name, -2) !== '[]')
            $name .= '[]';

        return Yii::app()->getController()->widget(__CLASS__, array(
            'name' => $name,
            'value' => $select,
            'data' => $data,
            'htmlOptions' => $htmlOptions,
            'multiple' => true,
        ), true);
    }

    public static function activeMultiSelect($model, $attribute, $data, $htmlOptions = array())
    {
        return self::multiSelect(CHtml::activeName($model, $attribute) . '[]', CHtml::value($model, $attribute), $data, $htmlOptions);
    }


}
