<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Importacao extends Model
{
    use HasFactory;

    protected $table = 'importacoes';

    protected $fillable = [
        'model_type',
        'started',
        'success',
        'requisicoes',
        'processados',
        'importados',
        'ignorados',
        'started_at',
        'finished_at',
    ];

    public function getDuracaoAttribute($value)
    {
        if (!is_null($this->started_at) && !is_null($this->finished_at)) {
            $start = Carbon::parse($this->started_at);
            $end = Carbon::parse($this->finished_at);
            return $end->diffInMinutes($start);
        } else {
            return null;
        }
    }
}
