<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "articles".
 *
 * @property int $id
 * @property int $id_category
 * @property int $id_author
 * @property string $title
 * @property string $desc
 * @property string $img_before
 * @property string $img_afrer
 * @property int $datetime
 * @property int $post_status
 *
 * @property Users $author
 * @property Categories $category
 */
class Articles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_category', 'id_author', 'title', 'desc', 'img_before', 'img_afrer', 'datetime', 'post_status'], 'required'],
            [['id_category', 'id_author', 'datetime', 'post_status'], 'integer'],
            [['desc'], 'string'],
            [['title', 'img_before', 'img_afrer'], 'string', 'max' => 255],
            [['id_category'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['id_category' => 'id']],
            [['id_author'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_author' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_category' => Yii::t('app', 'Id Category'),
            'id_author' => Yii::t('app', 'Id Author'),
            'title' => Yii::t('app', 'Title'),
            'desc' => Yii::t('app', 'Desc'),
            'img_before' => Yii::t('app', 'Img Before'),
            'img_afrer' => Yii::t('app', 'Img Afrer'),
            'datetime' => Yii::t('app', 'Datetime'),
            'post_status' => Yii::t('app', 'Post Status'),
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Users::className(), ['id' => 'id_author']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'id_category']);
    }
}
