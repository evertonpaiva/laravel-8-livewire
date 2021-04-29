<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modalidade extends Model
{
    use HasFactory;

    protected $primaryKey = 'idmodalidade';

    public $incrementing = false;

    protected $fillable = [ 'idmodalidade', 'modalidade'];
}
