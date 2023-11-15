<?php

namespace App\Console\Commands;

use App\Adapters\ElasticsearchClientAdapter;
use Database\Factories\GenreFactory;
use Illuminate\Console\Command;
use function Laravel\Prompts\select;

class SeedIndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed-index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(
        protected ElasticsearchClientAdapter $elasticsearchClient
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
            $this->warn('Não há indices registrados. Runs php artisan app:create-index');

            return 1;
        }

        $index = select(
            'Escolha o index a ser populado?',
            $indices,
        );

        $total = rand(10, 30);

        for ($i = 1; $i <= $total; $i++) {
            $params['body'][] = [
                'index' => [
                    '_index' => $index,
                ],
            ];

            $params['body'][] = (new GenreFactory())->definition();
        }

        $this->elasticsearchClient->raw()->bulk($params);
    }
}
