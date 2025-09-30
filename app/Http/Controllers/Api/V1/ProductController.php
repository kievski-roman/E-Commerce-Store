<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //

    public function index()
    {
        $maxDepth = 6;
        $rels = [];
        $chain = 'parent';

        for ($i = 1; $i < $maxDepth; $i++) {
            $rels[] = $chain;
            $chain .= '.parent';
        }
        $query = Product::query()
            ->with([
                'category' => fn($query) => $query->with($rels)
            ])
            ->paginate(10);
        return ProductResource::collection($query);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    // add to police for autorize and admin
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }else{
            $data['image'] = 'products/placeholder.jpg';
        }
        $product = Product::create($data);

        return (new ProductResource($product))
            ->response()
            ->setStatusCode(201);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }else{
            $data['image'] = 'products/placeholder.jpg';
        }
        $product->update($data);
        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }
}
