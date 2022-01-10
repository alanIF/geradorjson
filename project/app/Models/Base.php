<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    use HasFactory;
    protected $table= "base";
    protected $fillable= ['descricao','nome', 'arquivo_csv' ,'user_id'];
}
