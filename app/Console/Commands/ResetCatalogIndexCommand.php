<?php

namespace App\Console\Commands;

use Core\Infra\ElasticsearchClientInterface;
use Database\Factories\CastMemberFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\GenreFactory;
use Exception;
use Illuminate\Console\Command;

class ResetCatalogIndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-catalog-index-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(
        protected ElasticsearchClientInterface $elasticsearchClient,
        protected array $defaultIndexes = ['categories', 'genres', 'cast_members']
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach ($this->defaultIndexes as $index) {
            $this->removeIndex($index);

            $this->seedIndex($index);
        }
    }

    private function removeIndex($index)
    {
        $prefix = Config('elasticsearch.default_index');

        try {
            $this->elasticsearchClient->raw()->indices()->delete([
                'index' => "{$prefix}.{$index}"
            ]);
        } catch (\Throwable $th) {
            $this->error("Erro ao remover index {$index}");
        }
    }

    private function seedIndex($index)
    {
        $prefix = Config('elasticsearch.default_index');
        $index = "{$prefix}.{$index}";
        $data = [];

        switch ($index) {
            case 'codeflix.catalog.categories':
                $data = $this->indexCategoriesData($index);
                break;

            case 'codeflix.catalog.genres':
                $data = $this->indexGenresData($index);
                break;

            case 'codeflix.catalog.cast_members':
                $data = $this->indexGenresData($index);
                break;
            default:
                throw new Exception("{$index} não definido");
                break;
        }

        $prefix = Config('elasticsearch.default_index');

        // $this->elasticsearchClient->raw()->indices()->create([
        //     'index' => $index

        // ]);

        $this->elasticsearchClient->raw()->bulk($data);
    }

    private function indexCategoriesData($index)
    {
        $total = rand(10, 30);

        for ($i = 1; $i <= $total; $i++) {
            $params['body'][] = [
                'index' => [
                    '_index' => $index,
                ]
            ];

            $params['body'][] = (new CategoryFactory())->definition();
        }

        return $params;
    }

    private function indexGenresData($index)
    {
        $total = rand(10, 30);

        for ($i = 1; $i <= $total; $i++) {
            $params['body'][] = [
                'index' => [
                    '_index' => $index,
                ]
            ];

            $params['body'][] = (new GenreFactory())->definition();
        }

        return $params;
    }

    private function indexCastMembersData($index)
    {
        $total = rand(10, 30);

        for ($i = 1; $i <= $total; $i++) {
            $params['body'][] = [
                'index' => [
                    '_index' => $index,
                ]
            ];

            $params['body'][] = (new CastMemberFactory())->definition();
        }

        return $params;
    }
}
