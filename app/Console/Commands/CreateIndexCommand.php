<?php

namespace App\Console\Commands;

use Core\Infra\ElasticsearchClientInterface;
use Illuminate\Console\Command;
use function Laravel\Prompts\text;

class CreateIndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-index';

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
        $prefix = Config('services.elasticsearch.default_index');

        $index = text(
            label: 'Qual o nome do indice?',
            placeholder: 'E.g videos, genres, users...',
            hint: "Final name: {$prefix} + newName"
        );

        $this->elasticsearchClient->raw()->indices()->create([
            'index' => "{$prefix}.{$index}",
        ]);
    }
}
