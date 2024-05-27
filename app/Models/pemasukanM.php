<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pemasukanM extends Model
{
    use HasFactory;
    protected $table = 'pemasukan';
    protected $primaryKey = 'idpemasukan';
    protected $connection = 'mysql';
    protected $guarded = [];

    public function kas()
    {
        return $this->hasOne(kasM::class, 'idpemasukan','idpemasukan');
    }
    public function tambahan()
    {
        return $this->hasOne(tambahanM::class, 'idpemasukan','idpemasukan');
    }
    public function pengeluaran()
    {
        return $this->hasOne(pengeluaranM::class, 'idpemasukan','idpemasukan');
    }
}
