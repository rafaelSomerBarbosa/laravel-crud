<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'Produto';
    
    protected $primaryKey = 'idProduto';
    
    public $timestamps = false;

    protected $fillable = [
        'nmProduto',
        'dsProduto',
        'idCategoria',
    ];

    public function category() {
        return $this->hasOne(Category::class, 'idCategoria', 'idCategoria');
    }

    public function images() {
        return $this->hasMany(Image::class, 'idProduto', 'idProduto');
    }
}
