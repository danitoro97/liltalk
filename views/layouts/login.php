<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;


AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <style>
        nav ul li a {
            font-size: 2em;
        }
        nav ul li {
            float:left !important;
            margin-left: 10%;
        }
    </style>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
        ],
    ]);
    $item = [
        ['label' => Yii::t('app', 'Encuentra personas , comparte historias...')],
   ];
   echo Nav::widget([
       'options' => ['class' => 'navbar-nav navbar-right'],
       'items' =>$item ,
   ]);
   NavBar::end();
    ?>

    <div class="container">

        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
        <a href="#"><span class="flag-icon flag-icon-es<?=(Yii::$app->language == 'es-ES' ? ' selected' : null)?>" data-value='es-ES'></span></a>
        <a href="#"><span class="flag-icon flag-icon-us<?=(Yii::$app->language == 'en-US' ? ' selected' : null)?>" data-value='en-US'></span></a>

    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
