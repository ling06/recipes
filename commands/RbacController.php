<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{

    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAllRoles();
        $auth->removeAllPermissions();
        $auth->removeAllRules();

        $roleAdmin = $auth->createRole('admin');
        $auth->add($roleAdmin);

        $permissionRbac = $auth->createPermission('rbac');
        $permissionRbac->description = 'Редактирование ролей';
        $auth->add($permissionRbac);

        $permissionRecipeUpdate = $auth->createPermission('recipe-update');
        $permissionRecipeUpdate->description = 'Редактирование рецептов';
        $auth->add($permissionRecipeUpdate);

        $permissionRecipeUpdateAll = $auth->createPermission('recipe-update-all');
        $permissionRecipeUpdateAll->description = 'Редактирование чужих рецептов';
        $auth->add($permissionRecipeUpdateAll);

        $permissionRecipeDelete = $auth->createPermission('recipe-delete');
        $permissionRecipeDelete->description = 'Удаление рецептов';
        $auth->add($permissionRecipeDelete);

        $permissionRecipeDeleteAll = $auth->createPermission('recipe-delete-all');
        $permissionRecipeDeleteAll->description = 'Удаление чужих рецептов';
        $auth->add($permissionRecipeDeleteAll);

        $auth->addChild($roleAdmin, $permissionRbac);
        $auth->addChild($roleAdmin, $permissionRecipeUpdate);
        $auth->addChild($roleAdmin, $permissionRecipeUpdateAll);
        $auth->addChild($roleAdmin, $permissionRecipeDelete);
        $auth->addChild($roleAdmin, $permissionRecipeDeleteAll);

    }

}