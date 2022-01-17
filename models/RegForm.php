<?php
/**
 * Yii app
 *
 * @link http://ktk40.ru/
 * @license  http://www.yiiframefork.com/license
 */

namespace app\models;

use yii\base\Model;
use Yii;

/**
 * Форма регистрации
 *
 * @since 1.0
 */
class RegForm extends Model
{
    /**
     * @var string ФИО
     */
    public $fio;
    /**
     * @var string Логин
     */
    public $login;
    /**
     * @var string E-mail
     */
    public $email;
    /**
     * @var string Пароль
     */
    public $password;
    /**
     * @var string Повторите пароль
     */
    public $password2;
    /**
     * @var bool согласие на обработку персональных данных
     */
    public $approval;

    /**
     * Возвращает правила проверки атрибутов.
     *
     * @return array правила проверки
     */
    public function rules()
    {
        return [
            [['fio', 'login', 'email', 'password', 'password2', 'approval'], 'required'],
            [['fio', 'login', 'email', 'password', 'password2', 'approval'], 'trim'],
            ['fio', 'match', 'pattern' => '/^([а-яa-zё]+-?[а-яa-zё]+)( [а-яa-zё]+-?[а-яa-zё]+){1,2}$/Diu', 'message' => 'Вы некорректно ввели ФИО'],
            ['login', 'match', 'pattern' => '/^[a-z]{1}[a-z0-9_-]{4,20}$/i', 'message' => 'Только латинские буквы, цифры, дефис и от 5 до 20 символов'],
            ['email', 'email'],
            ['password2', 'compare', 'compareAttribute' => 'password'],
            ['approval', 'boolean'],
            ['approval', 'compare', 'compareValue' => true, 'message' => 'Необходимо согласиться'],
            ['fio', 'string', 'length' => [5, 100]],
            ['login', 'string', 'length' => [5, 20]],
            ['password', 'string', 'length' => [6, 32]],
            ['login', 'unique', 'targetAttribute' => 'login', 'targetClass' => '\app\models\Users'],
            ['email', 'unique', 'targetAttribute' => 'email', 'targetClass' => '\app\models\Users']
        ];
    }

    /**
     * Возращает метки атрибутов
     *
     * @return array метки атрибутов (name => label)
     */
    public function attributeLabels()
    {
        return [
            'fio' => Yii::t('table', 'Fio'),
            'login' => Yii::t('table', 'Login'),
            'email' => Yii::t('table', 'Email'),
            'password' => Yii::t('table', 'Password'),
            'password2' => Yii::t('app', 'Repeat the password'),
            'approval' => Yii::t('app', 'Consent to the processing of personal data'),
        ];
    }

    /**
     * Сохранение пользователя в БД
     *
     * @return bool результат сохранения
     * @thorws \yii\base\Exception
     */
    public function reg()
    {
        $user = new Users();
        $user->fio = $this->fio;
        $user->login = $this->login;
        $user->email = $this->email;
        $user->password = Yii::$app->security->generatePasswordHash($this->password);
        $user->auth_key = md5(microtime() . uniqid());
        $user->access_token = md5(microtime() . uniqid());
        $user->role = 0;
        return $user->save();
    }

}