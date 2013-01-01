<?php

/**
 * This is the model class for table "tbl_ingredient".
 *
 * The followings are the available columns in table 'tbl_ingredient':
 * @property integer $id
 * @property string $quantity1
 * @property string $quantity2
 * @property string $quantity3
 * @property string $quantity4
 * @property string $quantity5
 * @property string $name
 * @property integer $position
 * @property integer $recipe_id
 * @property integer $section_id
 *
 * The followings are the available model relations:
 * @property Recipe $recipe
 */
class Ingredient extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ingredient the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_ingredient';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, recipe_id, section_id', 'required'),
			array('recipe_id, section_id', 'numerical', 'integerOnly'=>true),
			array('quantity1, quantity2, quantity3, quantity4, quantity5, section_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, quantity1, quantity2, quantity3, quantity4, quantity5, name, recipe_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'recipe' => array(self::BELONGS_TO, 'Recipe', 'recipe_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'quantity1' => 'Quantity',
			'quantity2' => 'Quantity',
			'quantity3' => 'Quantity',
			'quantity4' => 'Quantity',
			'quantity5' => 'Quantity',
			'name' => 'Name',
			'recipe_id' => 'Recipe',
			'section_id' => 'Section',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('quantity1',$this->quantity1,true);
		$criteria->compare('quantity2',$this->quantity2,true);
		$criteria->compare('quantity3',$this->quantity3,true);
		$criteria->compare('quantity4',$this->quantity4,true);
		$criteria->compare('quantity5',$this->quantity5,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('recipe_id',$this->recipe_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}