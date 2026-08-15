<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = ['property_id', 'amount', 'date', 'description', 'received_from'];

    public function property() {
        return $this->belongsTo(Property::class);
    }
}