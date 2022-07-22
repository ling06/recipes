<?php
namespace app\widgets;

class NavNoBootstrap extends \yii\bootstrap4\Nav
{

    public function run()
    {
        return $this->renderItems();
    }

}
