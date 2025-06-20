<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /** @use HasFactory<\Database\Factories\MenuFactory> */
    use HasFactory;

    protected $primaryKey = 'id_menu';
    protected $fillable = [
        'name',
        'descricao',
        'price',
        'categories',
    ];

}
