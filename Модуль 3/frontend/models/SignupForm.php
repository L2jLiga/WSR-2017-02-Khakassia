<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use frontend\models\UserInfo;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $name;
    public $role;
    public $genre;
    public $phone;
    public $about;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 5],

            ['name', 'string', 'min' => 10, 'max' => 80],
            [['role', 'genre', 'name'], "required"],
            [['role', 'genre'], "integer"],
            ['phone', 'integer', 'max' => 100000000000],
            ['about', 'string', 'max' => 1024],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        if($user->save()) {
        	$user_info = new UserInfo();

        	$user_info->id = $user->id;
        	$user_info->name = $this->name;
        	$user_info->genre = $this->genre;
        	$user_info->phone = $this->phone;
        	$user_info->about = $this->about;
        	$user_info->role = $this->role;

        	return $user_info->save() ? $user : null;
        }
        return null;
    }

    /**
     * Edit exists user profile
     *
     * @return User|null the saved model or null if saving fails
     */
    public function edit($info)
    {
        $user_info = UserInfo::findIdentity(Yii::$app->user->id);
		return $user_info->load($info) && $user_info->save(true) ? true : false;
    }

    /**
     * Labels
     */
    public function attributeLabels () {
    	return [
    		"username" => "Ваш логин",
    		"email" => "Ваш адрес электронной почты",
    		"password" => "Ваш пароль",
    		"name" => "Ваши фамилия, имя и отчество",
    		"genre" => "Ваш пол",
    		"role" => "Кем вы являетесь?",
    		"phone" => "Ваш номер телефона",
    		"about" => "Расскажите о себе",
    	];
    }
}
