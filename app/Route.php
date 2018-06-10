<?php
namespace App;

/**
 * Class Route
 * @package App
 */
class Route extends BaseModel
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function departureAirport() {
        return $this->hasOne("App\Airport", "id", "departure");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function arrivalAirport() {
        return $this->hasOne("App\Airport", "id", "arrival");
    }

    /**
     * Get direct distance in nm.
     *
     * @return float
     */
    public function distance() {
        return $this->departureAirport->distanceFrom($this->arrivalAirport);
    }
}
