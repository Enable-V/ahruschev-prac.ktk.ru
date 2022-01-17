<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RegForm */
/* @var $form ActiveForm */

$this->title = Yii::t('app', 'Registration');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reg">

    <h1><?= Html::encode($this->title)?></h1>

    <?php Pjax::begin(['id'=>'reg_form'])?>

        <?php $form = ActiveForm::begin(['options' => ['data-pjax'=>true]]); ?>

            <?= $form->field($model, 'fio') ?>
            <?= $form->field($model, 'login') ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'password2')->passwordInput() ?>
            <?= $form->field($model, 'approval')->checkbox() ?>
    
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
    <?php Pjax::end()?>

</div><!-- site-reg -->
