<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

/**
 * форма создание заявки
 *
 * @since 1.0
 */

class ArticleForm extends Model
{
    /**
     * @var string Кличка
     */
    public $title;
    /**
     * @var string Описание запрашиваемых работ
     */
    public $desc;
    /**
     * @var int Категория
     */
    public $category;
    /**
     * @var mixed Фото
     */
    public $img_before;

    /**
     * Возращает правила проверки атрибутов
     *
     * @return array правила проверки
     */
    public function rules()
    {
        return [
            [['title','desc','category'],'required'],
            [['title','desc'],'trim'],
            ['category','integer'],
            ['title','string','length' => [2,200]],
            ['category','unique','targetAttribute' => 'title','targetClass' => '\app\models\Categories'],
            ['img_before','file','extensions' => 'png, jpg, jpeg, bmp', 'maxSize' => 2 * 1024 * 1024],
        ];
    }
    /**
     * Возращаем метки атрибутов
     *
     * @return array метки атрибутов (name => label)
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('table','title'),
            'desc' => Yii::t('table','Desc'),
            'category' => Yii::t('table','Id Category'),
            'img_before' => Yii::t('table','Img Before'),
        ];
    }
    public function newArticle()
    {
        $file = UploadedFile::getInstance($this,'img_before');
        if($file && $file->tempName){
            $dir = Yii::getAlias('@webroot').'/uploads';
            if(!is_dir($dir)) mkdir($dir,0777);
            $file_name = md5(microtime().uniqid().'.'.$file->extension);
            $file->saveAs($dir.$file_name);
            $article = new Articles();
            $article->title = $this->title;
            $article->desc = $this->desc;
            $article->id_author = Yii::$app->user->identity->id;
            $article->id_category = $this->category;
            $article->img_before = $file_name;
            $article->img_after = 'default.jpg';
            $article->datetime = time();
            $article->post_status = 0;
            return $article->save();
        }
        return false;
    }
}