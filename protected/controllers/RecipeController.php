<?php

class RecipeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','compare','create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);

		$this->pageTitle = Yii::app()->name . ' - ' . $model->title;

		$this->render('view',array(
			'model'=>$model,
		));
	}

	public function actionCompare($id1 = -1,$id2 = -1)
	{
		$this->render('compare',array(
			'id1'=>$id1,
			'id2'=>$id2,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		Yii::import('ext.multimodelform.MultiModelForm');

		$model=new Recipe;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$ingredient = new Ingredient;
		$validatedIngredients = array(); //ensure an empty array

		if(isset($_POST['Recipe']))
		{
			$model->attributes=$_POST['Recipe'];

			//build a 'dummy' $masterValues for validation only so that recipe_id is not blank
			$masterValues = array('recipe_id' => 1);

			if( //validate detail before saving the master
			MultiModelForm::validate($ingredient,$validatedIngredients,$deleteItems,$masterValues) &&
			$model->save()
			)
			{
				//the value for the foreign key 'recipe_id'
				$masterValues = array ('recipe_id'=>$model->id);
				if (MultiModelForm::save($ingredient,$validatedIngredients,$deleteIngredients,$masterValues))
					$this->redirect(array('view','id'=>$model->id));
			}
		}

		$model->number_instructions = 1;

		$this->render('create',array(
			'model'=>$model,
			//submit the ingredient and validatedItems to the widget in the edit form
			'ingredient'=>$ingredient,
			'validatedIngredients' => $validatedIngredients,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		Yii::import('ext.multimodelform.MultiModelForm');

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$ingredient = new Ingredient;
		$validatedIngredients = array(); //ensure an empty array

		if(isset($_POST['Recipe']))
		{
			$model->attributes=$_POST['Recipe'];
			//the value for the foreign key 'recipe_id'
			$masterValues = array ('recipe_id'=>$model->id);

			if( //Save the master model after saving valid ingredients
			MultiModelForm::save($ingredient,$validatedIngredients,$deleteIngredients,$masterValues) &&
			$model->save()
			)
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->pageTitle = Yii::app()->name . ' - Update '.$model->title;

		$this->render('update',array(
			'model'=>$model,
			//submit the ingredient and validatedItems to the widget in the edit form
			'ingredient'=>$ingredient,
			'validatedIngredients' => $validatedIngredients,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if( isset($_GET['category']) ) {
			$criteria = array('condition'=>'category_id='.$_GET['category']);
			$category = Category::model()->findByPk($_GET['category'])->name;
			$this->pageTitle = Yii::app()->name . ' - ' . $category;
		} else {
			$criteria = array();
			$category = '';
			$this->pageTitle = Yii::app()->name . ' - Recipes';
		}

		$dataProvider=new CActiveDataProvider('Recipe', array(
			'criteria'=>$criteria,
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'category'=>$category,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Recipe('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Recipe']))
			$model->attributes=$_GET['Recipe'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Recipe::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='recipe-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
