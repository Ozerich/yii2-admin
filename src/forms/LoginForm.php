<?php

namespace ozerich\admin\forms;

use ozerich\admin\interfaces\IAdminUser;
use ozerich\admin\Module;
use yii\base\Model;

class LoginForm extends Model
{
    public $login;

    public $password;

    public function attributeLabels()
    {
        return [
            'login' => 'Login'
        ];
    }

    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            ['password', 'validatePassword']
        ];
    }

    public function validatePassword($attribute)
    {
        /** @var Module $module */
        $module = \Yii::$app->controller->module;
        $userClass = $module->userIdentityClass;

        /** @var IAdminUser $model */
        $model = \Yii::createObject($userClass);
        $model = $model->checkAdminLogin($this->login, $this->password);

        if (!$model) {
            $this->addError('password', 'Invalid Password');
            return false;
        }

        return true;
    }
}