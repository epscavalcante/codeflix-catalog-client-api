<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use Core\Application\DTO\FindCategoryUseCaseInput;
use Core\Application\UseCase\FindCategoryUseCase;
use Core\Application\UseCase\ListCategoryUseCase;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        // private ListCategoryUseCase $listCategoryUseCase,
        // private FindCategoryUseCase $findCategoryUseCase,
    ) {
    }

    public function search(Request $request, ListCategoryUseCase $listCategoryUseCase)
    {
        $output = $listCategoryUseCase->execute(
            filter: $request->get('q')
        );

        return CategoryResource::collection($output->categories);
    }

    public function find(string $categoryId, FindCategoryUseCase $findCategoryUseCase)
    {
        $output = $findCategoryUseCase->execute(
            input: new FindCategoryUseCaseInput(($categoryId))
        );

        return new CategoryResource($output);
    }
}
