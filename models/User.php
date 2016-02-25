<?php

namespace app\models;

use Yii;

/**
 * This is the model class for collection "user".
 *
 * @property \MongoId|string $_id
 * @property mixed $username
 * @property mixed $password
 * @property mixed $authKey
 * @property mixed $accessToken
 * @property mixed $createTime
 * @property mixed $updateTime
 */
class User extends \yii\mongodb\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['yii2demo', 'user'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'username',
            'password',
            'authKey',
            'accessToken',
            'createTime',
            'updateTime',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'authKey', 'accessToken', 'createTime', 'updateTime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'authKey' => Yii::t('app', 'Auth Key'),
            'accessToken' => Yii::t('app', 'Access Token'),
            'createTime' => Yii::t('app', 'Create Time'),
            'updateTime' => Yii::t('app', 'Update Time'),
        ];
    }
    
    public static function findIdentity($id)
    {
        echo $id;
        return static::findOne(['_id' => $id]);
    }
    
    public static function findByUsername($username)
    {
        
        return static::findOne(['username' => $username]);
    }
    
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }
    
    public function validatePassword($password, $password_hash)
    {
        /*file_put_contents('/home/worker/data/www/yii2-demo/runtime/logs/log.log', $this->password. ' '.$password. ' ' . $password_hash . PHP_EOL, FILE_APPEND);
        //return Yii::$app->security->validatePassword($password, $password_hash);
        $password = Yii::$app->getSecurity()->generatePasswordHash($password);
        file_put_contents('/home/worker/data/www/yii2-demo/runtime/logs/log.log', $this->password. ' '.$password. ' ' . $password_hash . PHP_EOL, FILE_APPEND);
        return $this->password === $password;
        */
        if (Yii::$app->getSecurity()->validatePassword($password, $this->password)) {
            // all good, logging user in
            return true;
        } else {
            // wrong password
            return false;
        }
    }
    
    public function getAuthKey()
    {
        return $this->authKey;
    }
    
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
    
    public function getId()
    {
        return strval($this->_id);
    }
    
    public function getUsername()
    {
        return strval($this->username);
    }
}
