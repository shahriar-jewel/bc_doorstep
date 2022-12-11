<?php

namespace App\SMSSend;

use Illuminate\Support\Facades\Facade;

class SMSSendFacade extends Facade {

    protected static function getFacadeAccessor() {
        return 'SMSSend';
    }

}
?>
