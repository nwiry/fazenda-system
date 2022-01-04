<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallFarm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:farm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Instala o sistema, gerando o arquivo .env e o database a partir de seus arquivos backup para o uso oficial. (Não utilizar em modo produção)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            copy(database_path('farm.sql.backup'), database_path(env('DB_DATABASE', 'farm.sqlite3'))); // Faz uma cópia do sqlite backup renomeando o novo arquivo ou sobrescrevendo caso já exista.
            copy(base_path('.env.example'), base_path('.env')); // Faz uma cópia do arquivo .env.example renomeando o novo arquivo para o .env produção.
            $this->info('Instalação concluida com sucesso!'); // Retorna a mensagem de instalação concluída
            return Command::SUCCESS;
        } catch (\Exception $e) {
            // Caso a operação falhe, retorne a mensagem de erro com os detalhes
            $this->info('Falha ao executar instalação.\n' . 'Código de Erro: ' . $e->getMessage() . '\n' . 'Linha: ' . $e->getLine() . '\n' . 'Arquivo: ' . $e->getFile());
            return Command::INVALID;
        }
    }
}
