<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'Categoria';
    
    protected $primaryKey = 'idCategoria';

    public $incrementing = false;
    
    public $timestamps = false;

    protected $fillable = [
        'dsCategoria',
    ];
}
