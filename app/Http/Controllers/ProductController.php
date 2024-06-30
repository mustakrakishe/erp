<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\IndexProductRequest;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(IndexProductRequest $request): JsonResponse
    {
        $products = Product::where(
            'owner_id',
            $request->validated('owner_id')
        )->paginate(
            perPage: $request->validated('per_page'),
            page: $request->validated('page'),
        );

        return (new ProductCollection($products))->response();
    }
}
