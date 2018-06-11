<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    public static function log($user = 0, $data) {
        $log = new ActionLog();
        $log->user_id = $user;
        $log->data = $data;
        $log->save();
        return $log;
    }
}
