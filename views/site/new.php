<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\ArticleForm */
/* @var $categories app\models\Categories */
/* @var $form ActiveForm */

$this->title = Yii::t('app', 'New application');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-new">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title') ?>
    <?= $form->field($model, 'desc')->textarea() ?>
    <?= $form->field($model, 'category')->dropDownList(ArrayHelper::map($categories, 'id', 'title'), ['prompt' => 'Выберите категорию...']) ?>
    <?= $form->field($model, 'img_before')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-new -->
