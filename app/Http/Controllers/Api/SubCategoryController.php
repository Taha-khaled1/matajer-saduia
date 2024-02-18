<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSubcategories($categoryId): JsonResponse
    {
        try {
            $validator = Validator::make(['categoryId' => $categoryId], [
                'categoryId' => 'required|integer|exists:categories,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Validation error', 'errors' => $validator->errors(), 'status_code' => 400], 400);
            }


            $subcategories = SubCategory::where('category_id', $categoryId)->where('status', 1) // category id
                ->orderByDesc('created_at')
                ->select('id', 'image', DB::raw("name_" . app()->getLocale() . " AS name"))
                ->paginate(10);


            $products = Product::whereHas('subCategory', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })->activeAndSorted()->get();

        $products->each(function ($product) {
            // The 'final_price' attribute will be automatically accessed using the accessor
            $product->final_price;
        });

            return response()->json([
                'message' => 'Success',
                'status_code' => 200,
                'subcategories' => [
                    'current_page' => $subcategories->currentPage(),
                    'data' => $subcategories->items(),
                    'first_page_url' => $subcategories->url(1),
                    'from' => $subcategories->firstItem(),
                    'last_page' => $subcategories->lastPage(),
                    'last_page_url' => $subcategories->url($subcategories->lastPage()),
                    'links' => $subcategories->links()->elements,
                    'next_page_url' => $subcategories->nextPageUrl(),
                    'path' => $subcategories->path(),
                    'per_page' => $subcategories->perPage(),
                    'prev_page_url' => $subcategories->previousPageUrl(),
                    'to' => $subcategories->lastItem(),
                    'total' => $subcategories->total(),
                ],                
                'products' => $products,

            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => __('custom.failed_to_retrieve_data'), 'status_code' => 500], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $subCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subCategory)
    {
        //
    }
}