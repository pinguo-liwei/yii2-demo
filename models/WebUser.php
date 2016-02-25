<?php
namespace app\models;

class WebUser extends \yii\web\User
{
    public function getUserName()
    {
        $identity = $this->getIdentity();
    
        return $identity !== null ? $identity->getUsername() : null;
    }
}
