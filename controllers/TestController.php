<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use yii\filters\AccessControl;
class TestController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'ruleConfig' => [
                    'class' => 'app\components\MyAccessRule',
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        //'roles' => ['?'],
                        //'verbs' => ['GET', 'POST'],
                        'pgips' => '192.168.99.1',
                        //'ips' => ['192.168.99.1'],
                        /*'denyCallback' => function ($rule, $action) {
                        throw new \yii\web\ForbiddenHttpException('rule access');
                        }*/
                        'matchCallback' => function ($rule, $action) {
                            //return false;
                            $request = Yii::$app->getRequest();
                            if ($request->getUserIP() == '192.168.99.1') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['add'],
                        'roles' => ['?'],
                    ],
                ],
                /*'denyCallback' => function ($rule, $action) {
                    //var_dump($rule, true);
                    //var_dump($action, true);
                    throw new \yii\web\ForbiddenHttpException('access');
                    //return $action;
                }*/
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('index');
        //$hash = Yii::$app->getSecurity()->generatePasswordHash('admin');
        $str = '';
        $str .= 'id: ' . Yii::$app->user->id;
        $str .= 'username: ' . Yii::$app->user->username;
        //$str .= 'password: ' . Yii::$app->user->password;
        //$str .= 'authKey: ' . Yii::$app->user->authKey;
       // $str .= 'accessToken: ' . Yii::$app->user->accessToken;
        $secretKey = 'test';
        $data = array(
            'a' => 'b'
        );
        //$encryptedData = Yii::$app->security->encryptByPassword($data, $secretKey);
        //return $encryptedData;
        echo '<pre>';
        $identity = Yii::$app->user->identity;
        //print_r($identity);
        echo '</pre>';
        echo $identity->id . '<br>';
        echo $identity->username . '<br>';
        return Yii::$app->security->generateRandomString();
        $user = Yii::$app->user;
        return $user->username;
        return var_dump(Yii::$app->user, true);
        
        $member = new User();
        $member->username = 'admin';
        $member->password = 'admin';
        
        $res = $member->save();
        return $res;
    }
    
    public function actionAdd()
    {
        $user = new User();
        
        $time = time();
        $passwd = Yii::$app->getSecurity()->generatePasswordHash('admin');
        $user->username = 'admin';
        $user->password = $passwd;
        $user->authKey = 'admin';
        $user->accessToken = 'admin';
        $user->createTime = $time;
        $user->updateTime = $time;
        
        $res = false;//$user->save();
        
        if ($res) {
            return '添加成功';
        } else {
            return '添加失败';
        }
    }
}
