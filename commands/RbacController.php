<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{

    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $roleAdmin = $auth->createRole('admin');
        $auth->add($roleAdmin);

        $permissionRbac = $auth->createPermission('rbac');
        $permissionRbac->description = 'Редактирование ролей';
        $auth->add($permissionRbac);

        $permissionRecipeEdit = $auth->createPermission('recipe-edit');
        $permissionRecipeEdit->description = 'Редактирование рецептов';
        $auth->add($permissionRecipeEdit);

        $permissionRecipeDelete = $auth->createPermission('recipe-delete');
        $permissionRecipeDelete->description = 'Удаление рецептов';
        $auth->add($permissionRecipeDelete);

        $auth->addChild($roleAdmin, $permissionRbac);
        $auth->addChild($roleAdmin, $permissionRecipeEdit);
        $auth->addChild($roleAdmin, $permissionRecipeDelete);

    }

}