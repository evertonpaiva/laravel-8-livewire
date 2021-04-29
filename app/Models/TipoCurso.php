<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GraphqlClient\GraphqlRequest\Ensino\TipoCursoGraphqlRequest;

class TipoCurso extends Model
{
    use HasFactory;

    protected $table = 'tipo_curso';

    protected $primaryKey = 'idtipocurso';

    public $incrementing = false;

    protected $fillable = [ 'idtipocurso', 'tipocurso'];

    public static function idTipoCursoToEnum($idTipoCurso)
    {
        switch ($idTipoCurso) {
            case '01':
                return TipoCursoGraphqlRequest::GRADUACAO;
            case '02':
                return TipoCursoGraphqlRequest::ESPECIALIZACAO;
            case '03':
                return TipoCursoGraphqlRequest::MESTRADO;
            case '04':
                return TipoCursoGraphqlRequest::DOUTORADO;
            case '12':
                return TipoCursoGraphqlRequest::DISCIPLINA_ISOLADA;
            case '13':
                return TipoCursoGraphqlRequest::POS_DOUTORADO;
        }
    }
}
