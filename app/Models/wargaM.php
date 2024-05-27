<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wargaM extends Model
{
    use HasFactory;
    protected $table = 'warga';
    protected $primaryKey = 'idwarga';
    protected $connection = 'mysql';
    protected $guarded = [];

    public function kas()
    {
        return $this->hasOne(kasM::class, 'idwarga','idwarga');
    }
}
