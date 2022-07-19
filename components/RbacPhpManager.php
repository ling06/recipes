<?php

namespace app\components;

use app\models\User;
use app\models\UserPermissions;
use yii\helpers\VarDumper;
use yii\rbac\Assignment;
use yii\rbac\Item;
use yii\rbac\Permission;
use yii\rbac\PhpManager;
use yii\rbac\Role;

class RbacPhpManager extends PhpManager
{

    /**
     * @param Role|Permission $item
     * @param int|string $userId
     * @return Assignment
     */
    public function assign($item, $userId)
    {
        if ($item->type === Item::TYPE_ROLE) {
            User::updateAll(['role' => $item->name], ['id' => $userId]);
        } elseif ($item->type === Item::TYPE_PERMISSION) {
            $permissionExists = UserPermissions::find()
                ->where(['user_id' => $userId, 'permission' => $item->name])
                ->exists();
            if (!$permissionExists) {
                $permission = new UserPermissions(['user_id' => $userId, 'permission' => $item->name]);
                $permission->save();
            }
        }

        return new Assignment([
            'userId' => $userId,
            'roleName' => $item->name,
            'createdAt' => time(),
        ]);
    }

    /**
     * @param Role|Permission $item
     * @param int|string $userId
     * @return bool
     */
    public function revoke($item, $userId): bool
    {
        $userHasRole = User::find()->where(['id' => $userId, 'role' => $item->name])->exists();
        if ($userHasRole) {
            User::updateAll(['role' => null], ['id' => $userId]);
        } else {
            UserPermissions::deleteAll(['user_id' => $userId, 'permission' => $item->name]);
        }
        return true;
    }

    public function revokeAll($userId)
    {
        User::updateAll(['role' => null], ['id' => $userId]);
        UserPermissions::deleteAll(['user_id' => $userId]);
    }

    protected function load()
    {
        parent::load();
        $this->loadAssignments();
    }

    protected function loadAssignments(?int $userId = null)
    {
        $userRoles = User::find()
            ->select(['name' => 'role', 'user_id' => 'id'])
            ->filterWhere(['id' => $userId])
            ->asArray()
            ->all();
        $userPermissions = UserPermissions::find()
            ->select(['name' => 'permission', 'user_id'])
            ->filterWhere(['user_id' => $userId])
            ->asArray()
            ->all();
        $items = array_merge($userRoles, $userPermissions);
        foreach ($items as $item) {
            $this->assignments[$item['user_id']][$item['name']] = new Assignment([
                'userId' => $item['user_id'],
                'roleName' => $item['name'],
                'createdAt' => time(),
            ]);
        }
    }

    public function checkAccess($userId, $permissionName, $params = []): bool
    {
        $this->loadAssignments($userId);
        return parent::checkAccess($userId, $permissionName, $params);
    }

}