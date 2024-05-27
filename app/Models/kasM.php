<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kasM extends Model
{
    use HasFactory;
    protected $table = 'kas';
    protected $primaryKey = 'idkas';
    protected $connection = 'mysql';
    protected $guarded = [];

    public function warga()
    {
        return $this->belongsTo(wargaM::class, 'idwarga','idwarga');
    }
    public function pemasukan()
    {
        return $this->belongsTo(pemasukanM::class, 'idpemasukan','idpemasukan');
    }
}
