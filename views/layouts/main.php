<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\bootstrap4\Html;
use app\widgets\NavNoBootstrap;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<header class="wrapper">
    <?= NavNoBootstrap::widget([
        'items' => [
            [
                'label' => Yii::t('app', 'Список рецептов'),
                'url' => ['recipes/index'],
            ],
            [
                'label' => Yii::t('app', 'Войти'),
                'url' => ['site/login'],
                'visible' => Yii::$app->user->isGuest,
            ],
            [
                'label' => Yii::t('app', 'Выйти'),
                'url' => ['site/logout'],
                'visible' => !Yii::$app->user->isGuest,
            ],
        ],
        'options' => [
            'class' => 'topmenu',
        ],
        'route' => ltrim(\yii\helpers\Url::to(), '/'),
    ]) ?>
</header>

<main class="wrapper">
    <?= $content ?>
</main>

<footer class="wrapper"></footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
