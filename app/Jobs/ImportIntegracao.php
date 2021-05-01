<?php

namespace App\Jobs;

use App\Actions\Ufvjm\AuthContaInstitucional;
use GraphqlClient\GraphqlQuery\ForwardPaginationQuery;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Importacao;
use Illuminate\Support\Carbon;

/**
 * Class ImportIntegracao
 *
 * Importação de dados através de lib de Integração da UFVJM
 *
 * @package App\Jobs
 */
abstract class ImportIntegracao implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Tamanho máximo da paginação das requisicoes
     * @var int
     */
    public static int $TAM_MAX_PAGINACAO = 100;

    /**
     * Intervalo entre as requisições, em segundos
     * @var int
     */
    public static int $DELAY_REQUEST = 2;

    /**
     * Timeout de cada job, 30 min
     * 30 min x 60 = 1800 segundos
     * @var int
     */
    public $timeout = 1800;

    /**
     * Model de Importacao
     * @var Importacao
     */
    protected Importacao $importacao;

    /**
     * Tipo de model
     * @var string
     */
    protected string $modelType;

    /**
     * Número de registros processados
     * @var int
     */
    protected int $processados;

    /**
     * Número de registros importados
     * @var int
     */
    protected int $importados;

    /**
     * Número de registros ignorados
     * @var int
     */
    protected int $ignorados;

    /**
     * Número de requisicoes
     * @var int
     */
    protected int $requisicoes;

    /**
     * Cursor do final da página, último registro da página
     * @var string
     */
    protected string $endCursor;

    protected $pagination;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Importacao $importacao, string $modelType)
    {
        $this->importacao = $importacao;
        $this->modelType = $modelType;
        $this->processados = 0;
        $this->importados = 0;
        $this->ignorados = 0;
        $this->requisicoes = 0;
        $this->endCursor = '';
    }

    /**
     * Realiza login na Integracao
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function login()
    {
        $loginInfo = new \stdClass();

        $loginInfo->containstitucional = env('LDAP_USERNAME');
        $loginInfo->password = env('LDAP_PASSWORD');

        $authContaInstitucional = new AuthContaInstitucional();
        $authContaInstitucional->logarContaInstitucional($loginInfo);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->login();

            $msg = 'Processando job '.$this->modelType. ' id: '. $this->importacao->id;
            echo $msg.PHP_EOL;

            $this->importacao->update([
                'started' => true,
                'started_at' => Carbon::now(),
            ]);
            $this->importaDados();

            // Marca o processamento como finalizado com sucesso
            $this->importacao->update([
                'success' => true,
                'finished_at' => Carbon::now(),
            ]);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            echo 'Erro ao atualizar importacao' . $this->importacao->id . ': ' . $message . PHP_EOL;
            $this->importacao->update(['success' => false]);
        }
        echo 'Finalizando job '. $this->importacao->id . PHP_EOL;
    }

    /**
     * Exibe o log de processamento dos registros
     */
    protected function showLog()
    {
        echo PHP_EOL;
        echo '-- Requisição ' . $this->requisicoes. ' --' . PHP_EOL;
        echo 'Processados: ' . $this->processados . PHP_EOL;
        echo 'Importados: ' . $this->importados . PHP_EOL;
        echo 'Ignorados: ' . $this->ignorados . PHP_EOL;
    }

    /**
     * Define a paginação, se é primeira página ou a partir de um determinado cursor
     */
    protected function setPagination()
    {
        if (!empty($this->endCursor)) {
            // Segunda pagina em diante
            $this->pagination = new ForwardPaginationQuery(ImportIntegracao::$TAM_MAX_PAGINACAO, $this->endCursor);
        } else {
            // Primeira pagina
            $this->pagination = new ForwardPaginationQuery(ImportIntegracao::$TAM_MAX_PAGINACAO);
        }
    }

    /**
     * Atualiza no banco o andamento do processamento
     */
    protected function updateProgress()
    {
        $this->importacao->update([
            'requisicoes' => $this->requisicoes,
            'processados' => $this->processados,
            'importados' => $this->importados,
            'ignorados' => $this->ignorados,
        ]);
    }

    abstract protected function importaDados();
}
