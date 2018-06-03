<?php
namespace App;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 * @package App
 */
class BaseModel extends Model
{
    /**
     * Converts date and times to RFC 3339 defined format.
     *
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date) {
        return $date->format(\DateTime::RFC3339);
    }
}
