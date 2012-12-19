<?php

/**
 * This is the model class for table "tbl_recipe".
 *
 * The followings are the available columns in table 'tbl_recipe':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $instructions
 * @property string $notes
 * @property string $source
 * @property integer $servings
 * @property string $serving_unit
 * @property string $create_time
 * @property string $update_time
 * @property integer $category_id
 * @property integer $author_id
 *
 * The followings are the available model relations:
 * @property Category $category
 * @property User $author
 * @property Ingredient[] $ingredients
 */
class Recipe extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Recipe the static model class
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
		return 'tbl_recipe';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, category_id', 'required'),
			// array('title, create_time, category_id, author_id', 'required'),
			array('servings, create_time, update_time, category_id, author_id', 'numerical', 'integerOnly'=>true),
			array('description, instructions, notes, source, serving_unit', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, description, instructions, notes, source, servings, serving_unit, category_id, author_id', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),
			'ingredients' => array(self::HAS_MANY, 'Ingredient', 'recipe_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'description' => 'Description',
			'instructions' => 'Instructions',
			'notes' => 'Notes',
			'source' => 'Source',
			'servings' => 'Servings',
			'serving_unit' => 'Serving Unit',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'category_id' => 'Category',
			'author_id' => 'Author',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('instructions',$this->instructions,true);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('servings',$this->servings);
		$criteria->compare('serving_unit',$this->serving_unit,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('author_id',$this->author_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function defaultScope()
	{         
		return array(
			'condition'=>'author_id='.Yii::app()->user->id,         
		);     
	}

	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->create_time=$this->update_time=time();
				$this->author_id=Yii::app()->user->id;
			}
			else
				$this->update_time=time();
			return true;
		}
		else
			return false;
	}
}
