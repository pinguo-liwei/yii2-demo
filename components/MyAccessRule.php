<?php
namespace app\components;

use yii\filters\AccessRule;

class MyAccessRule extends AccessRule
{
    public $pgips;
    
    public function allows($action, $user, $request)
    {
        if ($this->matchAction($action)
            && $this->matchRole($user)
            && $this->matchIP($request->getUserIP())
            && $this->matchVerb($request->getMethod())
            && $this->matchController($action->controller)
            && $this->matchCustom($action)
            && $this->matchPgIP($request->getUserIP())
        ) {
            
            $allow = $this->allow ? true : false;
            //echo json_encode($allow).'<br>';
            return $allow;
        } else {
            //echo 'null';
            return null;
        }
    }
    
    protected function matchPgIP($ip)
    {
        if (empty($this->pgips)) {
            return true;
        }
        if ($ip == $this->pgips) {
            return true;
        }
        return false;
    }
}
