<?php

class RequireLogin extends CBehavior
{
    public function attach($owner)
        {
            $owner->attachEventHandler('onBeginRequest', array($this, 'handleBeginRequest'));
        }
        
    public function handleBeginRequest($event)
        {
            $app = Yii::app();
            $user = $app->user;
            $request = trim($app->urlManager->parseUrl($app->request), '/');
            $login = 'site/login';

            // a vendégek (belépés nélküli user) csak az itt definiált oldalakhoz férnek hozzá
            $allowed = array($login);
            if ($user->isGuest && !in_array($request, $allowed))
				$user->loginRequired();

            // a már belépett felhasználó ne láthassa a login oldalt
            $request = substr($request, 0, strlen($login));
            if (!$user->isGuest && $request == $login)
            {
				$url = $app->createUrl($app->homeUrl[0]);
				$app->request->redirect($url);
			}
    }
}

?>