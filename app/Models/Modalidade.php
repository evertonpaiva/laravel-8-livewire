<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GraphqlClient\GraphqlRequest\Ensino\ModalidadeGraphqlRequest;

class Modalidade extends Model
{
    use HasFactory;

    protected $primaryKey = 'idmodalidade';

    public $incrementing = false;

    protected $fillable = [ 'idmodalidade', 'modalidade'];

    public static function idModalidadeToEnum($idModalidade)
    {
        switch ($idModalidade) {
            case 1:
                return ModalidadeGraphqlRequest::PRESENCIAL;
            case 2:
                return ModalidadeGraphqlRequest::EAD;
            case 3:
                return ModalidadeGraphqlRequest::LEC;
        }
    }
}
