<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = Yii::t('app', 'Personal account');
$this->params['breadcrumbs'][] = $this->title;

$GLOBALS['script'] = '';
?>
<div class="site-my">

    <h1><?= Html::encode($this->title) ?></h1>

    <select class="form-control" onchange="javascript:location.href = this.value;">
        <option value="/my">Выберите статус...</option>
        <option value="/my?status=0"
            <?php if (Yii::$app->request->get('status') == '0'): ?> selected<?php endif ?>>Новая</option>
        <option value="/my?status=1"
            <?php if (Yii::$app->request->get('status') == '1'): ?> selected<?php endif ?>>Обработка данных</option>
        <option value="/my?status=2"
            <?php if (Yii::$app->request->get('status') == '2'): ?> selected<?php endif ?>>Услуга оказана</option>
    </select>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'pager' => [
            'options' => [
                'tag' => 'div',
                'class' => 'pagination',
            ],
            'linkOptions' => ['class' => 'page-link'],
            'activePageCssClass' => 'page-item active',
            'prevPageCssClass' => 'page-item',
            'nextPageCssClass' => 'page-item',
        ],
        'itemOptions' => ['class' => 'card mb-3'],
        'itemView' => function ($model, $key, $index, $widget) {
            $data = date('d.m.Y H:i:s', $model->datetime);
            $category = \app\models\Categories::findOne($model->id_category);
            $status = '<span style="color:#b50505">Новая</span>';
            if ($model->post_status == 1) $status = '<span style="color:#b56605">Обработка данных</span>';
            elseif ($model->post_status == 2) $status = '<span style="color:#297a1a">Услуга оказана</span>';

            $GLOBALS['script'] .= 'imageComparison("#image-comparison' . $model->id . '");';
            $str = <<<_HTML
<div class="row">
    <div class="col-md-4">
        <div id="image-comparison{$model->id}">
            <img height="200px" width="200px" src="/uploads/{$model->img_before}" alt="{$model->title}" />
            <img src="/uploads/{$model->img_after}" alt="{$model->title}" />
        </div>
    </div>
    <div class="col-md-8">
        <div class="card-body">
            <div class="row text-muted">
                <div class="col-md-4"><b>Дата создания:</b> {$data}</div>
                <div class="col-md-4"><b>Категория:</b> {$category->title}</div>
                <div class="col-md-4"><b>Статус:</b> {$status}</div>
            </div>
            <h5 class="card-title">{$model->title}</h5>
            <p class="card-text">{$model->desc}</p>
        </div>
    </div>
</div>
_HTML;
            return $str;
        },
    ]) ?>

</div>
<script>window.onload=function(){<?= $GLOBALS['script'] ?>}</script>