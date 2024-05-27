<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tambahanM extends Model
{
    use HasFactory;
    protected $table = 'tambahan';
    protected $primaryKey = 'idtambahan';
    protected $connection = 'mysql';
    protected $guarded = [];

    public function pemasukan()
    {
        return $this->hasOne(pemasukanM::class, 'idpemasukan','idpemasukan');
    }
}
