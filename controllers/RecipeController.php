<?php

namespace app\controllers;

use app\models\forms\RecipeCreateForm;
use app\models\searchers\RecipeSearcher;
use Yii;
use app\models\Recipe;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;

class RecipeController extends Controller
{

    public function getTitles(): array
    {
        return [
            'create' => Yii::t('app', 'Создание рецепта'),
            'update' => Yii::t('app', 'Редактирование рецепта'),
        ];
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'update'],
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['list', 'view'],
                    ],
                ],
            ],
        ];
    }

    public function actionList(): string
    {
        $recipesProvider = (new RecipeSearcher())->search();
        $recipes = $recipesProvider->query
            ->offset($recipesProvider->pagination->offset)
            ->limit($recipesProvider->pagination->limit)
            ->all();
        return $this->render('//recipe/list', [
            'recipes' => $recipes,
        ]);
    }

    public function actionView($id, $slug)
    {
        $recipe = Recipe::find()->where([
            'id' => $id,
            'slug' => $slug,
        ])->one();
        if (!$recipe) {
            throw new NotFoundHttpException();
        }
        return $this->render('view', [
            'recipe' => $recipe,
        ]);
    }

    public function actionCreate()
    {
        $model = new RecipeCreateForm();

        $post = Yii::$app->request->post();
        if ($model->load($post, 'RecipeCreateForm')) {
            $model->Timeline = $post['Timeline'] ?? [];
            $model->Ingredient = $post['Ingredient'] ?? [];
            $transaction = Yii::$app->db->beginTransaction();
            if ($model->save()) {
                $transaction->commit();
                return $this->redirect(['recipe/update', 'id' => $model->id]);
            } else {
                $transaction->rollBack();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = RecipeCreateForm::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException();
        }

        $post = Yii::$app->request->post();
        if ($model->load($post, 'RecipeCreateForm')) {
            $model->Timeline = $post['Timeline'] ?? [];
            $model->Ingredient = $post['Ingredient'] ?? [];
            $transaction = Yii::$app->db->beginTransaction();

            $model->deleteDependencies();

            if ($model->save()) {
                $transaction->commit();
                return $this->redirect(['recipe/update', 'id' => $model->id]);
            } else {
                $transaction->rollBack();
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

}