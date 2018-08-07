<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model
{

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function offers()
    {
        return $this->hasMany(Offers::class);
    }

    public function requests()
    {
        return $this->hasMany(Requests::class);
    }

    public function reviews()
    {
        return $this->hasMany(Reviews::class);
    }


    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function charities()
    {
        return $this->hasOne(Charities::class);
    }

    /**
    * geometry attribute method
    */
    public function setLocationAttribute(array $value)
    {
        $this->attributes['salon_location'] = DB::raw("(GeomFromText('POINT(" . $value['lat'] . " " . $value['lng'] . ")'))");
    }

    static function getLocationAttribute(string $value)
    {
        $value = substr($value, strlen('POINT('), strlen($value) - (strlen('POINT(') + 1));
        $value = explode(" ", $value);
        $ret = [];
        $ret['lat'] = $value[0];
        $ret['lng'] = $value[1];
        return $ret;
    }

    public function newQuery($excludeDeleted = true)
    {
        $raw='';
        foreach(array('salon_location') as $column){
            $raw .= ' astext('.$column.') as '.$column.' ';
        }

        return parent::newQuery($excludeDeleted)->addSelect('*',DB::raw($raw));
    }
}
