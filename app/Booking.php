<?php

namespace App;

/**
 * Class Booking
 * @package App
 */
class Booking extends BaseModel
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function routeInfo() {
        return $this->hasOne("App\Route", "id", "route_id");
    }
}
