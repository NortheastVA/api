<?php

namespace App;

/**
 * Class Booking
 * @package App
 */
class Booking extends BaseModel
{
    /**
     * Attributes to add to array serialization
     *
     * @var array
     */
    protected $appends = ['routeinfo'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function route() {
        return $this->hasOne("App/Route", "id", "route_id");
    }

    /**
     * @return mixed
     */
    public function getRouteinfoAttribute() {
        return Route::where("id", $this->route_id)->first();
    }
}
