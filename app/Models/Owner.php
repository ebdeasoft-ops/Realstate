<?php
namespace App\Models;



use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $fillable = ['name', 'phone', 'email'];

    public function properties() {
        return $this->hasMany(Property::class);
    }
}