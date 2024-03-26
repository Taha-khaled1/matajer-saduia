<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllProducts(): JsonResponse
    {
        try {
            $products = Product::activeAndSorted()->paginate(10);
            return response()->json([
                'products' => [
                    'current_page' => $products->currentPage(),
                    'data' => $products->items(),
                    'first_page_url' => $products->url(1),
                    'from' => $products->firstItem(),
                    'last_page' => $products->lastPage(),
                    'last_page_url' => $products->url($products->lastPage()),
                    'next_page_url' => $products->nextPageUrl(),
                    'path' => $products->path(),
                    'per_page' => $products->perPage(),
                    'prev_page_url' => $products->previousPageUrl(),
                    'to' => $products->lastItem(),
                    'total' => $products->total(),
                ],
                'message' => 'Success',
                'status_code' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' =>  __('custom.failed_to_retrieve_data'), 'status_code' => 500], 500);
        }
    }

    public function getAllProductsHotItem(): JsonResponse
    {
        try {
            $products = Product::ActiveAndSortedHotitem()->paginate(10);
            return response()->json([
                'productsHotItem' => [
                    'current_page' => $products->currentPage(),
                    'data' => $products->items(),
                    'first_page_url' => $products->url(1),
                    'from' => $products->firstItem(),
                    'last_page' => $products->lastPage(),
                    'last_page_url' => $products->url($products->lastPage()),
                    'next_page_url' => $products->nextPageUrl(),
                    'path' => $products->path(),
                    'per_page' => $products->perPage(),
                    'prev_page_url' => $products->previousPageUrl(),
                    'to' => $products->lastItem(),
                    'total' => $products->total(),
                ],
                'message' => 'Success',
                'status_code' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' =>  __('custom.failed_to_retrieve_data'), 'status_code' => 500], 500);
        }
    }




    public function getProducts(): JsonResponse
    {
        try {
            $products = Product::activeAndSorted()->paginate(4);
            $productshot = Product::ActiveAndSortedHotitem()->paginate(4);
            $now = Carbon::now();

            // Query products with an active discount
            $products = Product::whereNotNull('discount')
                ->where('discount_start', '<=', $now)
                ->where('discount_end', '>=', $now)
                ->activeAndSorted()
                ->paginate(4);


            return response()->json([
                'products' => [
                    'current_page' => $products->currentPage(),
                    'data' => $products->items(),
                    'first_page_url' => $products->url(1),
                    'from' => $products->firstItem(),
                    'last_page' => $products->lastPage(),
                    'last_page_url' => $products->url($products->lastPage()),
                    'next_page_url' => $products->nextPageUrl(),
                    'path' => $products->path(),
                    'per_page' => $products->perPage(),
                    'prev_page_url' => $products->previousPageUrl(),
                    'to' => $products->lastItem(),
                    'total' => $products->total(),
                ],


                'products_offer' => [
                    'current_page' => $products->currentPage(),
                    'data' => $products->items(),
                    'first_page_url' => $products->url(1),
                    'from' => $products->firstItem(),
                    'last_page' => $products->lastPage(),
                    'last_page_url' => $products->url($products->lastPage()),
                    'next_page_url' => $products->nextPageUrl(),
                    'path' => $products->path(),
                    'per_page' => $products->perPage(),
                    'prev_page_url' => $products->previousPageUrl(),
                    'to' => $products->lastItem(),
                    'total' => $products->total(),
                ],

                'productsHotItem' => [
                    'current_page' => $productshot->currentPage(),
                    'data' => $productshot->items(),
                    'first_page_url' => $productshot->url(1),
                    'from' => $productshot->firstItem(),
                    'last_page' => $productshot->lastPage(),
                    'last_page_url' => $productshot->url($products->lastPage()),
                    'next_page_url' => $productshot->nextPageUrl(),
                    'path' => $productshot->path(),
                    'per_page' => $productshot->perPage(),
                    'prev_page_url' => $productshot->previousPageUrl(),
                    'to' => $productshot->lastItem(),
                    'total' => $productshot->total(),
                ],


                'message' => 'Success',
                'status_code' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' =>  __('custom.failed_to_retrieve_data'), 'status_code' => 500], 500);
        }
    }







    // __('custom.failed')
    /**
     * Show the form for creating a new resource.
     *: JsonResponse
     * @return \Illuminate\Http\Response
     */
    public function getProductsBysubCatogery($subCatogeryId)
    {
        try {
            $validator = Validator::make(['subCategoryId' => $subCatogeryId], [
                'subCategoryId' => 'required|integer|exists:sub_categories,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => __('custom.validation_error'), 'errors' => $validator->errors(), 'status_code' => 400], 400);
            }

            $products = Product::where('sub_category_id', '=', $subCatogeryId)->activeAndSorted()->paginate(10);


            return response()->json([
                'products' => [
                    'current_page' => $products->currentPage(),
                    'data' => $products->items(),
                    'first_page_url' => $products->url(1),
                    'from' => $products->firstItem(),
                    'last_page' => $products->lastPage(),
                    'last_page_url' => $products->url($products->lastPage()),
                    'next_page_url' => $products->nextPageUrl(),
                    'path' => $products->path(),
                    'per_page' => $products->perPage(),
                    'prev_page_url' => $products->previousPageUrl(),
                    'to' => $products->lastItem(),
                    'total' => $products->total(),
                ],


                'message' => 'Success',
                'status_code' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => __('custom.failed_to_retrieve_data'), 'status_code' => 500], 500);
        }
    }



    public function getProductsByOffer(): JsonResponse
    {
        try {
            // Get the current date and time
            $now = Carbon::now();

            // Query products with an active discount
            $products = Product::whereNotNull('discount')
                ->where('discount_start', '<=', $now)
                ->where('discount_end', '>=', $now)
                ->activeAndSorted()
                ->paginate(10);

            $products->each(function ($product) {
                // The 'final_price' attribute will be automatically accessed using the accessor
                $product->final_price;
            });

            return response()->json([
                'products' => [
                    'current_page' => $products->currentPage(),
                    'data' => $products->items(),
                    'first_page_url' => $products->url(1),
                    'from' => $products->firstItem(),
                    'last_page' => $products->lastPage(),
                    'last_page_url' => $products->url($products->lastPage()),
                    'next_page_url' => $products->nextPageUrl(),
                    'path' => $products->path(),
                    'per_page' => $products->perPage(),
                    'prev_page_url' => $products->previousPageUrl(),
                    'to' => $products->lastItem(),
                    'total' => $products->total(),
                ],
                'message' => 'Success',
                'status_code' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => __('custom.failed_to_retrieve_data'), 'status_code' => 500], 500);
        }
    }

    public function getProductsGift(): JsonResponse
    {
        try {
            $products = Product::ActiveAndSortedGift()->paginate(50);

            return response()->json([
                'products' => [
                    'current_page' => $products->currentPage(),
                    'data' => $products->items(),
                    'first_page_url' => $products->url(1),
                    'from' => $products->firstItem(),
                    'last_page' => $products->lastPage(),
                    'last_page_url' => $products->url($products->lastPage()),
                    'next_page_url' => $products->nextPageUrl(),
                    'path' => $products->path(),
                    'per_page' => $products->perPage(),
                    'prev_page_url' => $products->previousPageUrl(),
                    'to' => $products->lastItem(),
                    'total' => $products->total(),
                ],
                'message' => 'Success',
                'status_code' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => __('custom.failed_to_retrieve_data') . $e, 'status_code' => 500], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getProductById($productId): JsonResponse
    {
        try {
            // $attributeColors = [];
            $attributeOnly = [];
            // $attributeSizes=[];
            $validator = Validator::make(
                ['productId' => $productId],
                ['productId' => 'required|integer|exists:products,id'],
            );


            if ($validator->fails()) {
                return response()->json([
                    'message' => __('custom.validation_error'),
                    'errors' => $validator->errors(),
                    'status_code' => 400,
                ], 400);
            }

            $products = Product::ProductById()->findOrFail($productId);

            $products->each(function ($product) {
                $product->final_price;
            });

            if ($products->type_attribute == "colors") {

                foreach ($products->attribute as $attr) {
                    if ($attr->color_id && !$attr->size_id) {
                        $s = $attr->color;
                        $attributeOnly[] = $attr;
                    }
                }
            } else if ($products->type_attribute == "sizes") {

                foreach ($products->attribute as $attr) {
                    if ($attr->size_id && !$attr->color_id) {
                        $s = $attr->size;
                        $attributeOnly[] = $attr;
                    }
                }
            } else if ($products->type_attribute == "both") {


                // Organize the data
                foreach ($products->attribute as $variant) {
                    $sizeName = $variant->size->name_en;  // Assuming you have relationships set up
                    $colorName = $variant->color ? $variant->color->name_en : null;
                    $color_code = $variant->color ? $variant->color->color_code : null;

                    // Check if size already exists in our response list
                    $sizeKey = array_search($sizeName, array_column($attributeOnly, 'size_name_en'));

                    // If size doesn't exist yet, add it
                    if ($sizeKey === false) {
                        $sizeKey = count($attributeOnly);
                        $attributeOnly[$sizeKey] = [
                            'size_name_en' => $sizeName,
                            'colors' => []
                        ];
                    }

                    // Add the color details to the size
                    if ($colorName) {
                        $attributeOnly[$sizeKey]['colors'][] = [
                            'sku' => $variant->sku,
                            'attribute_id' => $variant->id,
                            'price' => $variant->price,
                            'quantity' => $variant->quantity,
                            'image' => $variant->image,
                            'colorName' => $colorName,
                            'color_code' => $color_code,
                        ];
                    }
                }
            }



            $relatedProducts = Product::where('sub_category_id', $products->sub_category_id)->where('id', '!=', $products->id)->activeAndSorted()->take(5)->get();

            $relatedProducts->each(function ($product) {
                $product->final_price;
            });



            // if (!empty($attributeOnly)) {
            return response()->json([
                'product' => $products,
                'related_products' => $relatedProducts,
                'attributes' => $attributeOnly,
                'message' => 'Success',
                'status_code' => 200,
            ], 200);
            // } else {
            //     return response()->json([
            //         'product' => $products,
            //         'related_products' => $relatedProducts, 
            //         'message' => 'Success',
            //         'status_code' => 200,
            //     ], 200);
            // }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => __('custom.failed_to_retrieve_data'),
                'status_code' => 500,
                'error' => $th->getMessage(),
            ], 500);
        }
    }
    public function updateViews($id)
    {


        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => __('custom.product_not_found'), 'status_code' => 404,], 404);
        }

        $product->views += 1;
        $product->save();

        return response()->json(['message' => 'Success', 'status_code' => 200,], 200);
    }

    public function searchProduct(Request $request): JsonResponse
    {
        try {
            // Validate the request parameters
            $validator = Validator::make($request->all(), [
                'keyword' => 'required|min:1',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->first(), 'errors' => $validator->errors(), 'status_code' => 400], 400);
            }
            $keyword = $request->input('keyword');

            // if (is_numeric($keyword)) {
            //     $products = Product::ActiveAndSortedForSearchById($keyword)->paginate(10);
            // } else {
            //     $products = Product::ActiveAndSortedForSearch($keyword)->paginate(10);
            // }

            $products = Product::ActiveAndSortedForSearch($keyword)->paginate(10);
            return response()->json([
                'products' => [
                    'current_page' => $products->currentPage(),
                    'data' => $products->items(),
                    'first_page_url' => $products->url(1),
                    'from' => $products->firstItem(),
                    'last_page' => $products->lastPage(),
                    'last_page_url' => $products->url($products->lastPage()),
                    'next_page_url' => $products->nextPageUrl(),
                    'path' => $products->path(),
                    'per_page' => $products->perPage(),
                    'prev_page_url' => $products->previousPageUrl(),
                    'to' => $products->lastItem(),
                    'total' => $products->total(),
                ],
                'message' => 'Success',
                'status_code' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' =>  __('custom.failed_to_retrieve_data'), 'status_code' => 500], 500);
        }
    }

    // : JsonResponse
    public function getSortedProducts(Request $request)
    {
        try {
            // Validate the request parameters
            $validator = Validator::make($request->all(), [
                'sort_type' => 'required|integer|min:1|max:5',
                'category_id' => 'integer',  // Add validation for category_id
                'sub_category_id' => 'integer',  // Add validation for sub_category_id
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => __('custom.validation_error'),
                    'errors' => $validator->errors(),
                    'status_code' => 400
                ], 400);
            }

            $sortType = $request->input('sort_type');
            $categoryId = $request->input('category_id');  // Get category_id from the request
            $subCategoryId = $request->input('sub_category_id');  // Get sub_category_id from the request


            $query = Product::query()->active();
            if ($subCategoryId) {

                // Filtering at the subsection level
                $query->where('sub_category_id', $subCategoryId);
            } elseif ($categoryId) {
                // return "afdsaf";
                // Filtering at the main section level
                $query->whereIn('sub_category_id', function ($query) use ($categoryId) {
                    $query->select('id')
                        ->from('sub_categories')
                        ->where('category_id', $categoryId)
                        ->get();
                });
            }
            switch ($sortType) {
                case 1:
                    $query->orderBy('arrange', 'asc');
                    break;
                case 2:
                    $query->orderBy('price', 'desc');
                    break;
                case 3:
                    $query->orderBy('price', 'asc');
                    break;
                case 4:
                    $query->latest();
                    break;
                case 5:
                    $query->whereNotNull('discount')->orderBy('discount', 'desc');
                    break;
            }
            $query->select([
                'id',
                DB::raw("name_" . app()->getLocale() . " AS name"), DB::raw("name_" . ReverseLanguage(app()->getLocale()) . " AS favorite_name"),
                'price',
                'image',
                'discount_start',
                'discount_end',
                'discount',
                'arrange',
            ]);
            $products = $query->paginate(10);

            $products->each(function ($product) {
                $product->final_price;
            });

            return response()->json([
                'products' => [
                    'current_page' => $products->currentPage(),
                    'data' => $products->items(),
                    'first_page_url' => $products->url(1),
                    'from' => $products->firstItem(),
                    'last_page' => $products->lastPage(),
                    'last_page_url' => $products->url($products->lastPage()),
                    'next_page_url' => $products->nextPageUrl(),
                    'path' => $products->path(),
                    'per_page' => $products->perPage(),
                    'prev_page_url' => $products->previousPageUrl(),
                    'to' => $products->lastItem(),
                    'total' => $products->total(),
                ],
                'message' => 'success',
                'status_code' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => __('custom.failed_to_retrieve_data') . $e,
                'status_code' => 500
            ], 500);
        }
    }


















    //  DB::raw("name_" . app()->getLocale() . " AS name"),



}

//    $attributeSizes = [];
//                 $attributeColors = [];
//                 $attributeOnly = [];

                // foreach ($product->attribute as $attr) {
                //     if ($attr->size_id && !$attr->color_id) {
                //         $attributeSizes[] = $attr;
                //     } elseif ($attr->color_id && !$attr->size_id) {
                //         $attributeColors[] = $attr;
                //     } elseif ($attr->color_id && $attr->size_id) {
                //         $attributeOnly[] = $attr;
                //     }
                // }

//                 $response = array_merge($product->toArray(), [
//                     'attributeSizes' => $attributeSizes,
//                     'attributeColors' => $attributeColors,
//                     'sizes_colors' => $attributeOnly,
//                 ]);





                // foreach ($products->attribute as $attr) {
                //     if ($attr->size_id && !$attr->color_id) {
                //       $s = $attr->size;
                //        $attributeSizes[] = $attr;
                //     } elseif ($attr->color_id && !$attr->size_id) {   
                //         $c = $attr->color;
                //         $attributeColors[] =  $attr;
                //     } elseif ($attr->color_id && $attr->size_id) { 
                //         $c = $attr->color;   $s = $attr->size;
                //         $attributeOnly[] = $attr;
                //     }
                // }

                // $response = array_merge($products->toArray(), [
                //     'attributeSizes' => $attributeSizes,
                //     'attributeColors' => $attributeColors,
                //     'sizes_colors' => $attributeOnly,
                // ]);