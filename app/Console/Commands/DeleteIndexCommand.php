<?php

namespace App\Console\Commands;

use Core\Infra\ElasticsearchClientInterface;
use Illuminate\Console\Command;
use function Laravel\Prompts\select;

class DeleteIndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(
        protected ElasticsearchClientInterface $elasticsearchClient
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $indices = $this->elasticsearchClient->getIndices();

        if (count($indices) === 0) {
            $this->warn('Não há indices registrados.');

            return 1;
        }

        $index = select(
            'Qual index será removido?',
            $indices,
        );

        $this->elasticsearchClient->raw()->indices()->delete([
            'index' => $index,
        ]);
    }
}//:
