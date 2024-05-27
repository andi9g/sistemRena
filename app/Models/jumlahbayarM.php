<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jumlahbayarM extends Model
{
    use HasFactory;
    protected $table = 'jumlahbayar';
    protected $primaryKey = 'idjumlahbayar';
    protected $connection = 'mysql';
    protected $guarded = [];
}
