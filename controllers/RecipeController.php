<?php

namespace app\controllers;

use app\models\forms\RecipeCreateForm;
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
                        'actions' => ['view'],
                    ],
                ],
            ],
        ];
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
                return $this->redirect(['recipes/index']);
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
        $model = Recipe::findOne($id);
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            var_dump($post);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

}