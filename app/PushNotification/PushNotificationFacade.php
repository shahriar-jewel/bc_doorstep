<?php

namespace App\PushNotification;

use Illuminate\Support\Facades\Facade;

class PushNotificationFacade extends Facade {

    protected static function getFacadeAccessor() {
        return 'PushNotification';
    }

}
?>
