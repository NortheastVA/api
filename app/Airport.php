<?php

namespace App;

class Airport extends BaseModel
{
    /**
     * ID is the ICAO identifier of the airport
     *
     * @var bool
     */
    public $incrementing = false;

    public static function byIcao($icao) {
        return Airport::find(strtoupper($icao));
    }

    /**
     * Calculates great circle distance between two airports using the Vincenty formula.
     *
     * @param Airport|string|array $target
     * @return float Distance in nm
     */
    public function distanceFrom($target) {
        $lat1 = $this->latitude;
        $lon1 = $this->longitude;
        if ($target instanceof Airport) {
            $lat2 = $target->latitude;
            $lon2 = $target->longitude;
        } elseif (is_array($target)) {
            $lat2 = $target[0];
            $lon2 = $target[1];
        } else {
            $a = Airport::find($target);
            if (!$a) throw new Exception("Airport $target not found");
            $lat2 = $a->latitude;
            $lon2 = $a->longitude;
        }

        $lat1 = deg2rad($lat1); $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2); $lon2 = deg2rad($lon2);
        $lonDelta = $lon1 - $lon2;
        $a = pow(cos($lat2) * sin($lonDelta), 2) +
             pow(cos($lat2) * sin($lat2) - sin($lat1) * cos($lat1) * cos($lonDelta), 2);
        $b = sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($lonDelta);
        $angle = atan2(sqrt($a), $b);

        return round($angle * 3440, 1);
    }

    // When running find, make sure we capitalize the identifier.
    public function __call($method, $parameters) {
        if ($method == "find") {
            $parameters[0] = strtoupper($parameters[0]);
        }

        return parent::__call($method, $parameters);
    }
}
