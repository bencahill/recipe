<?php

/**
 * This is the model class for table "tbl_ingredient".
 *
 * The followings are the available columns in table 'tbl_ingredient':
 * @property integer $id
 * @property string $quantity
 * @property string $measurement
 * @property string $ingredient
 * @property string $notes
 * @property integer $recipe_id
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
			array('quantity, measurement, ingredient, recipe_id', 'required'),
			array('recipe_id', 'numerical', 'integerOnly'=>true),
			array('notes', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, quantity, measurement, ingredient, notes, recipe_id', 'safe', 'on'=>'search'),
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
			'quantity' => 'Quantity',
			'measurement' => 'Measurement',
			'ingredient' => 'Ingredient',
			'notes' => 'Notes',
			'recipe_id' => 'Recipe',
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
		$criteria->compare('quantity',$this->quantity,true);
		$criteria->compare('measurement',$this->measurement,true);
		$criteria->compare('ingredient',$this->ingredient,true);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('recipe_id',$this->recipe_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}