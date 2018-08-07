<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo(Users::class);
    }
}
