<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = ['name', 'phone', 'id_number'];

    // علاقة المستأجر بالعقود
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}