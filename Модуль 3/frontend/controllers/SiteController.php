<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\User;
use frontend\models\Groups;
use frontend\models\Images;
use frontend\models\Members;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        $user = User::findIdentity(Yii::$app->user->id);
        $userInfo = $user->getUserInfo()->one();

        $groups = array();
        if($userInfo->role)
            $groups =  $user->getGroups()->all();
        else
        {
            foreach ($user->getMembers()->all() as $oneGroup) {
                $groups[] = Groups::findIdentity($oneGroup->group_id);
            }
            
        }


        return $this->render('about', ['user' => $user, 'userInfo' => $userInfo, 'groups' => $groups/*Если пользователь, то где он участвует.. */ ]);
    }

    public function actionEdit()
    {
        if ($post = Yii::$app->request->post())
        {
            $post['UserInfo']['id'] = Yii::$app->user->id;
            $edit = new SignupForm();
            if ($user = $edit->edit($post)) {
                Yii::$app->session->setFlash('success', 'Отлично! Вы успешно изменили профиль!.');
            }
        }

        $userInfo = User::findIdentity(Yii::$app->user->id)->getUserInfo()->one();

        return $this->render('edit', ['userInfo' => $userInfo]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    Yii::$app->session->setFlash('success', 'Отлично! Вы успешно зарегистрировались!.');

                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }





    /**
     * Экскурсии
     */
    public function actionExlist()
    {
        $model = Groups::find()->all();

        return $this->render('exlist', ['groups' => $model]);
    }

    public function actionExadmin()
    {
        $model = User::findIdentity(Yii::$app->user->id)->getGroups()->all();

        return $this->render('exadmin', ['groups' => $model]);
    }

    public function actionExadd ()
    {
        $model = new Groups();

        if ($post = Yii::$app->request->post())
        {
            $post['Groups']['user_id'] = \Yii::$app->user->identity->id;
            if($model->load($post) && $model->save())
            {
                $files = $_FILES["Groups"];
                if(sizeof($files['name']))
                {
                    for($i = 0; $i < sizeof($files['name']["images"]); $i++)
                    {
                        $path_to_upload = $_SERVER['DOCUMENT_ROOT'] . "\\uploads\\";
                        $name = md5(microtime()) . '.' .  end(explode(".", $files['name']['images'][$i]));

                        if(move_uploaded_file($files['tmp_name']['images'][$i], $path_to_upload . $name))
                        {
                            $image = new Images();
                            $data['Images'] = [
                                'group_id' => $model->group_id,
                                'image' => '/uploads/' . $name,
                            ];

                            $image->load($data);
                            $image->save();
                        }
                    }
                }

                Yii::$app->session->setFlash('success', 'Экскурсия успешно добавлена!');

                return $this->goHome();
            }
        }

        return $this->render('exadd', ['model' => $model]);
    }

    public function actionExrec()
    {
       $model = new Members();

        $data['Members'] = [
            'group_id' => intval($_GET['id']),
            'user_id' => Yii::$app->user->id,
            'status' => 0,
        ];
        if($model->load($data) && $model->save())
        {
            Yii::$app->session->setFlash('success', 'Вы успешно записались на экскурсию!');
            return $this->goHome();
        }
    }

    public function actionViewgr ()
    {
        echo "Данный функционал не готов";
    }

    public function actionEditgr ()
    {
        echo "Данный функционал не готов";
    }

    public function actionLeavegr()
    {
        $ex = Members::findStatus(intval($_GET['id']), Yii::$app->user->id);
        $ex->status = 2;
 

        if($ex->save())
            Yii::$app->session->setFlash('success', 'Экскурсия отписались от экскурсии!');
        else
            Yii::$app->session->setFlash('error', 'Ошибка! На сервере что-то пошло не так..');
        return $this->goHome();
    }

    public function actionMemlistgr ()
    {
        $id = intval($_GET['id']);

        $model = Groups::findIdentity($id)->getMembers0()->all();

        return $this->render('viewMembers', ['members' => $model, ]);
    }

    public function actionConfirmadd ()
    {
        $ex = Members::findStatus(intval($_GET['gr_id']), intval($_GET['id']));
        $ex->status = 1;

        Yii::$app->session->setFlash('success', 'Пользователь успешно добавлен в экскурсию!');
        
        if($ex->save())
            return $this->goHome();


    }
    public function actionConfirmdel ()
    {
        $ex = Members::findStatus(intval($_GET['gr_id']), intval($_GET['id']))->delete();

        Yii::$app->session->setFlash('success', 'Пользователь успешно устранен!');

        return $this->goHome();


    }
}
