<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use Core\Application\DTO\FindCategoryUseCaseInput;
use Core\Application\DTO\ListCategoryUseCaseInput;
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
        $input = new ListCategoryUseCaseInput(
            filter: $request->get('q')
        );
        $output = $listCategoryUseCase->execute(
            input: $input
        );

        return CategoryResource::collection($output->items)
            ->additional([
                'total' => $output->total,
            ]);
    }

    public function find(string $categoryId, FindCategoryUseCase $findCategoryUseCase)
    {
        $output = $findCategoryUseCase->execute(
            input: new FindCategoryUseCaseInput($categoryId)
        );

        return new CategoryResource($output);
    }
}
