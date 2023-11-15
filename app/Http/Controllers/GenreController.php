<?php

namespace App\Http\Controllers;

use App\Http\Resources\GenreResource;
use Core\Application\DTO\Genre\FindGenreUseCaseInput;
use Core\Application\DTO\Genre\ListGenreUseCaseInput;
use Core\Application\UseCase\Genre\FindGenreUseCase;
use Core\Application\UseCase\Genre\ListGenreUseCase;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function search(Request $request, ListGenreUseCase $listGenreUseCase)
    {
        $input = new ListGenreUseCaseInput(
            filter: $request->get('q')
        );
        $output = $listGenreUseCase->execute(
            input: $input
        );

        return GenreResource::collection($output->items)
            ->additional([
                'total' => $output->total,
            ]);
    }

    public function find(string $categoryId, FindGenreUseCase $findGenreUseCase)
    {
        $output = $findGenreUseCase->execute(
            input: new FindGenreUseCaseInput($categoryId)
        );

        return new GenreResource($output);
    }
}
