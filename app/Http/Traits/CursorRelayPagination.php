<?php

namespace App\Http\Traits;

use GraphqlClient\GraphqlQuery\BackwardPaginationQuery;
use GraphqlClient\GraphqlQuery\ForwardPaginationQuery;

trait CursorRelayPagination
{
    /**
     * Cursor para início da página
     */
    public $navStartCursor;

    /**
     * Cursor para fim da página
     */
    public $navEndCursor;

    /**
     * Direcao da paginacao: next/previous
     */
    public $navAction;

    /**
     * Tem proxima pagina?
     */
    public $navHasNextPage;

    /**
     * Tem pagina anterior?
     */
    public $navHasPreviousPage;

    /**
     * Controla a paginacao
     */
    private $pagination;

    /**
     * Navega para próxima pagina
     */
    public function nextPage()
    {
        $this->navAction = 'next';
    }

    /**
     * Navega para página anterior
     */
    public function previousPage()
    {
        $this->navAction = 'previous';
    }

    /**
     * Atualiza as informacoes de paginação
     * @param $pageInfo
     */
    public function setPageInfo($pageInfo)
    {
        $this->navHasNextPage = $pageInfo->hasNextPage;
        $this->navHasPreviousPage = $pageInfo->hasPreviousPage;
        $this->navStartCursor = $pageInfo->startCursor;
        $this->navEndCursor = $pageInfo->endCursor;

        $this->navAction = null;
    }

    /**
     * Monta a navegação na paginação baseado em sua direção
     */
    public function setPaginationDirection()
    {
        // Paginacao para frente, partindo de um determinado registro
        if (($this->navAction == 'next')) {
            $this->pagination = new ForwardPaginationQuery(self::TAMANHOPAGINA, $this->navEndCursor);
            // Paginacao para tras, partindo de um determinado registro
        } elseif ($this->navAction == 'previous') {
            $this->pagination = new BackwardPaginationQuery(self::TAMANHOPAGINA, $this->navStartCursor);
            // Sem paginacao, primeiros registros
        } else {
            $this->pagination = new ForwardPaginationQuery(self::TAMANHOPAGINA);
        }
    }
}
