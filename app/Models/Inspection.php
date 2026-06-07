<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    public function production()
    {
        return $this->belongsTo(Production::class);
    }

    protected $fillable = [
        'production_id',
        'production_date',
        'user_id',
        'shipment_date',
        'inspection_date',
        'measurement'
        ];
}
