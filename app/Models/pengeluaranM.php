<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengeluaranM extends Model
{
    use HasFactory;
    protected $table = 'pengeluaran';
    protected $primaryKey = 'idpengeluaran';
    protected $connection = 'mysql';
    protected $guarded = [];
}
