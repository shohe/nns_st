<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Offers extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo(Users::class);
    }

    /**
    * geometry attribute method
    */
    public function setLocationAttribute(array $value)
    {
        $this->attributes['user_location'] = DB::raw("(GeomFromText('POINT(" . $value['lat'] . " " . $value['lng'] . ")'))");
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
        foreach(array('user_location') as $column){
            $raw .= ' astext('.$column.') as '.$column.' ';
        }

        return parent::newQuery($excludeDeleted)->addSelect('*',DB::raw($raw));
    }
}
