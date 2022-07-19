<?php

namespace app\controllers;

class Controller extends \yii\web\Controller
{

    public function getTitles(): array
    {
        return [];
    }

    public function beforeAction($action): bool
    {
        $titles = $this->getTitles();
        if (isset($titles[$action->id])) {
            $this->view->title = $titles[$action->id];
        }
        return parent::beforeAction($action);
    }

}