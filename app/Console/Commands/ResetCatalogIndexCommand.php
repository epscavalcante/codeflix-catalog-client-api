<?php

namespace App\Console\Commands;

use App\Adapters\ElasticsearchClientAdapter;
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
    protected $signature = 'app:reset-catalog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(
        protected ElasticsearchClientAdapter $elasticsearchClient,
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
        $prefix = Config('services.elasticsearch.default_index');

        try {
            $this->elasticsearchClient->raw()->indices()->delete([
                'index' => "{$prefix}.{$index}",
            ]);
        } catch (\Throwable $th) {
            $this->error("Erro ao remover index {$index}");
        }
    }

    private function seedIndex($index)
    {
        $prefix = Config('services.elasticsearch.default_index');
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
                $data = $this->indexCastMembersData($index);
                break;
            default:
                throw new Exception("{$index} não definido");
                break;
        }

        $prefix = Config('services.elasticsearch.default_index');

        $this->elasticsearchClient->raw()->bulk($data);
    }

    private function indexCategoriesData($index)
    {
        $categories = json_decode(file_get_contents(database_path('mocks/categories.json')), true);
        return $this->mountData($categories, $index);
    }

    private function indexGenresData($index)
    {
        $genres = json_decode(file_get_contents(database_path('mocks/genres.json')), true);
        return $this->mountData($genres, $index);
    }

    private function indexCastMembersData($index)
    {
        $castMembers = json_decode(file_get_contents((database_path('mocks/cast-members.json'))), true);
        return $this->mountData($castMembers, $index);
    }

    private function mountData(array $items, $index) {
        for ($i = 1; $i <= count($items); $i++) {
            $params['body'][] = [
                'index' => [
                    '_index' => $index,
                ],
            ];
            $params['body'][] = $items[$i - 1];
        }

        return $params;
    }
}
