<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProducttRequest;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Size;
use App\Models\SubCategory;

use Illuminate\Http\Request;
use App\Traits\ImageProcessing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use ImageProcessing;
    // 'المنتجات الغير مفعله'
    // php artisan make:model Popular -mcr
    function __construct()
    {
        $this->middleware('permission:جميع المنتجات', ['only' => ['index']]);
        $this->middleware('permission:المنتجات الغير مفعله', ['only' => ['productsInactive']]);
        $this->middleware('permission:اضافة منتج', ['only' => ['store', 'create']]);
        $this->middleware('permission:تعديل منتج', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف منتج', ['only' => ['destroy']]);
        $this->middleware('permission:حالة منتج', ['only' => ['updateStatusProduct']]);
        $this->middleware('permission:نسخ المنتج', ['only' => ['editFork']]);
    }



    public function index()
    {
        $products = Product::all();

        return view('dashboard.product.index', compact('products'));
    }
    public function productSpacial()
    {
        $products = Product::where('user_id', Auth::user()->id)->get();

        return view('dashboard.product.products-special', compact('products'));
    }

    public function productsInactive()
    {
        $products = Product::where('status', 0)->get();

        return view('dashboard.product.products-inactive', compact('products'));
    }

    public function create()
    {
        $colors = Color::all();
        $sizes = Size::all();
        $categories = Category::all();
        return view('dashboard.product.store', compact('categories', 'colors', 'sizes'));
    }


    public function store(StoreProducttRequest $request)
    {

        DB::beginTransaction();
        try {


            $user = Auth::User();
            $product = new Product;
            // $product->is_gift = $request['is_gift'];
            $product->name_ar = $request['name_ar'];
            $product->name_en = $request['name_en'];
            // $product->category = $request['category'];
            $product->sub_category_id = $request['sub_category_id'];
            $product->price = $request['price'];
            $product->shipping_fee = $request['shipping_fee'];
            $product->quantity = $request['quantity'];
            $product->description_measurement_guide = $request['description_measurement_guide'];
            // $product->arrange = $request['arrange'];
            $product->weight = $request['weight'];
            $product->sku = $request['sku'];






            $product->type_attribute = $request['sectionChoice'];
            $product->description_ar = $request['description_ar'];
            $product->description_en = $request['description_en'];
            $data['image'] = $this->saveImage($request->file('image'), 'product');
            $product->image = 'imagesfp/product/' . $data['image'];
            if ($request->hasFile('measurement_guide')) {
                $data['measurement_guide'] = $this->saveImage($request->file('measurement_guide'), 'product');
                $product->measurement_guide = 'imagesfp/product/' . $data['measurement_guide'];
            }




            $product->user_id =  $user->id;
            $product->weight = $request['weight'];
            if ($product->discount != null && $product->discount > 0) {
                $product->discount = $request['discount'];
                $product->discount_start = $request['discount_start'];
                $product->discount_end = $request['discount_end'];
            }
            $product->save();

            if ($user->hasRole('admin')) {
                $product->status = true;
            } else if ($user->hasRole('vendor')) {
                $product->status = false;
                sendNotificationToAdmin('اضافة منتج', ' البائع ' . $user->name . ' قام باضافة منتج جديد اسم المنتج ' . $request['name_ar'], env("BASE_URL") . "/dashboard/products/edit/" . $product->id);
            } else {
                session()->flash('delete', 'فشلة العمليه');
                return redirect()->back()->withSuccess('error');
            }


            if ($request['sectionChoice'] == "colors") {

                $colors = $request->input('colors') ?? [];
                $colorsPrice = $request->input('colors_price') ?? [];

                if (!empty($colors) && !empty($colorsPrice)) {
                    foreach ($colors as $index => $color) {
                        //  && $colorsPrice[$index] !== null
                        if ($color !== null) {
                            $attribute = new Attribute();
                            $attribute->color_id = $colors[$index];
                            $attribute->price = ($colorsPrice[$index] ?? $request['price']);
                            $attribute->size_id = null;
                            $attribute->product_id = $product->id;
                            $attribute->quantity = 2;
                            $attribute->sku = 'zxc';
                            $attribute->save();
                        }
                    }
                }
            } else if ($request['sectionChoice'] == "sizes") {

                $sizes = $request->input('sizes') ?? [];
                $sizesPrice = $request->input('sizes_price') ?? [];

                if (!empty($sizes) && !empty($sizesPrice)) {
                    foreach ($sizes as $index => $size) {
                        //  && $sizesPrice[$index] !== null
                        if ($size !== null) {
                            $attribute = new Attribute();
                            $attribute->size_id = $sizes[$index]; // Set size_id to null since it's a size only attribute
                            $attribute->price = ($sizesPrice[$index] ?? $request['price']);
                            $attribute->color_id = null;
                            $attribute->product_id = $product->id;
                            $attribute->quantity = 2;
                            $attribute->sku = 'zxc';
                            $attribute->save();
                        }
                    }
                }
            } else if ($request['sectionChoice'] == "both") {

                $attributeSizes = $request->input('attribute_size') ?? [];
                $attributeColors = $request->input('attribute_color') ?? [];
                $attributePrices = $request->input('attribute_price') ?? [];

                if (!empty($attributeSizes) && !empty($attributeColors) && !empty($attributePrices)) {
                    foreach ($attributeSizes as $index => $attributeSize) {
                        //  && $attributePrices[$index] !== null
                        if ($attributeSize !== null && $attributeColors[$index] !== null) {
                            $attribute = new Attribute();
                            $attribute->size_id = $attributeSize;
                            $attribute->color_id = $attributeColors[$index];
                            $attribute->price = ($attributePrices[$index] ?? $request['price']);
                            $attribute->product_id = $product->id;
                            $attribute->quantity = 2;
                            $attribute->sku = 'zxc';
                            $attribute->save();
                        }
                    }
                }
            }



            $images = $request->file('images');
            $imagePaths = [];
            foreach ($images as $image) {
                $imageName = $this->saveImage($image, 'product');
                $imagePaths[] = ['image' => 'imagesfp/product/' . $imageName];
            }


            foreach ($imagePaths as &$imagePath) {
                $imagePath['product_id'] = $product->id;
            }

            ProductImage::insert($imagePaths);
            DB::commit();
            session()->flash('Add', 'تم اضافة المنتج بنجاح ');
            return redirect()->route('products.special')->with('success', 'Category created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    public function show($id)
    {
        //
    }
    public function affiliateProduct(Request $request)
    {
        $id = $request->input('id');
        $locale = $request->input('locale');
        $product = Product::with('images', 'attribute.size', 'attribute.color')
            ->select('id', 'name_' . $locale . ' AS name', 'price', 'image', 'discount_start', 'discount_end', 'discount', 'description_' . $locale . ' AS description', 'quantity', 'sub_category_id', 'views')
            ->findOrFail($id);

        $product->each(function ($product) {
            $product->final_price;
        });

        $relatedProducts = Product::where('sub_category_id', $product->sub_category_id)->where('id', '!=', $product->id)->activeAndSorted()->take(5)->get();

        $relatedProducts->each(function ($product) {
            $product->final_price;
        });

        return view('dashboard.product.product-detalis', compact('product', 'locale'));
    }

    public function edit(int $id)
    {
        $product = Product::with(['images'])->findOrFail($id);

        $category = Category::findOrFail($product->subCategory->category_id);
        $subcategories = SubCategory::where('category_id', $category->id)->get();

        $categories = Category::all();
        $attributes = Attribute::where('product_id', $product->id)->get();
        $colors = Color::all();
        $sizes = Size::all();
        $attributeSizes = [];
        $attributeColors = [];
        $sizes_colors = [];
        foreach ($attributes as $index => $value) {
            if ($value->size_id == null) {
                $attributeColors[] = $value;
            } else if ($value->color_id == null) {
                $attributeSizes[] = $value;
            } else {
                $sizes_colors[] = $value;
            }
        }
        // return $sizes_colors;
        //     return response()->json([
        //         'product' => $product,  'category' => $category,
        //         'subcategories' => $subcategories, 
        //         'categories' => $categories, 
        //         'attributeSizes' => $attributeSizes,
        //         'attributeColors' => $attributeColors,
        //         'colors' => $colors,'sizes' => $sizes,
        // ]);
        return view('dashboard.product.update', compact('product', 'category', 'subcategories', 'categories', 'attributeSizes', 'attributeColors', 'sizes_colors', 'sizes', 'colors'));
    }
    public function editFork(int $id)
    {
        DB::beginTransaction();
        try {
            $originalProduct = Product::findOrFail($id);

            // Create a clone of the original product with some modifications
            $clonedProduct = $originalProduct->replicate();
            $clonedProduct->name_ar = $originalProduct->name_ar . ' (Clone)';
            $clonedProduct->name_en = $originalProduct->name_en . ' (Clone)';
            $clonedProduct->user_id = Auth::user()->id;
            $clonedProduct->created_at = now();
            $clonedProduct->save();

            // Clone attributes
            if ($originalProduct->attribute) {
                foreach ($originalProduct->attribute as $originalAttribute) {
                    $clonedAttribute = $originalAttribute->replicate();
                    $clonedAttribute->product_id = $clonedProduct->id;
                    $clonedAttribute->save();
                }
            }

            // Clone images if they exist
            if ($originalProduct->images) {
                foreach ($originalProduct->images as $originalImage) {
                    $clonedImage = $originalImage->replicate();
                    $clonedImage->product_id = $clonedProduct->id;
                    $clonedImage->save();
                }
            }

            DB::commit();
            session()->flash('Add', 'تم نسخ المنتج بنجاح');
            return redirect()->route('products.special', ['product' => $clonedProduct->id]);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update(Request $request)
    {
        // return $request;
        DB::beginTransaction();
        try {
            $user = Auth::User();
            $product = Product::findOrFail($request->product_id);
            $product->name_ar = $request->input('name_ar');
            $product->name_en = $request->input('name_en');
            // $product->is_gift = $request->input('is_gift');
            $product->sku = $request->input('sku');
            $product->description_measurement_guide =
                $request->input('description_measurement_guide');
            $product->sub_category_id = $request->input('sub_category_id');
            $product->price = $request->input('price');
            $product->quantity = $request->input('quantity');
            $product->weight = $request->input('weight');
            $product->shipping_fee = ($request['shipping_fee']);
            $product->type_attribute = $request['sectionChoice'];
            if ($request->input('discount') == "0.0" || $request->input('discount') == null || $request->input('discount') == 0.0 || $request->input('discount') == 0) {

                $product->discount = 0;
                $product->discount_start = null;
                $product->discount_end = null;
            } else {
                $product->discount = ($request->input('discount'));
                $product->discount_start = $request->input('discount_start');
                $product->discount_end = $request->input('discount_end');
            }




            // $product->arrange = $request->input('arrange');
            $product->description_ar = $request->input('description_ar');
            $product->description_en = $request->input('description_en');
            $product->user_id = $user->id;
            if ($user->hasRole('admin')) {
                $product->status = true;
            } else if ($user->hasRole('vendor')) {
                $product->status = false;
                sendNotificationToAdmin('تعديل علي المنتج', ' البائع ' . $user->name . ' قام بتعديل منتج خاص به اسم المنتج ' . $request->input('name_ar'), env("BASE_URL") . "/dashboard/products/edit/" . $product->id);
            } else {
                session()->flash('delete', 'فشلة العمليه');
                return redirect()->back()->withSuccess('error');
            }
            // Check if user can update product
            if ($user->hasRole('admin') || (true && $user->hasRole('vendor'))) {
                if ($request->hasFile('image')) {
                    $data['image'] = $this->saveImage($request->file('image'), 'product');
                    $product->image = 'imagesfp/product/' . $data['image'];
                }
                if ($request->hasFile('measurement_guide')) {
                    $data['measurement_guide'] = $this->saveImage($request->file('measurement_guide'), 'product');
                    $product->measurement_guide = 'imagesfp/product/' . $data['measurement_guide'];
                }
                $product->save();


                if ($request['sectionChoice'] == "colors") {
                    // Update product attributes
                    $colors = $this->arrayWithoutNull($request->input('colors', []));
                    $colorsPrice = $request->input('colors_price', []);

                    foreach ($colors as $index => $color) {
                        $attribute = Attribute::updateOrCreate(
                            ['product_id' => $product->id, 'color_id' => $colors[$index], 'size_id' => null],
                            ['price' => $colorsPrice[$index] ?? $request->input('price'), 'quantity' => 1, 'sku' => 'zxc', 'color_id' => $colors[$index]]
                        );
                    }
                }
                if ($request['sectionChoice'] == "sizes") {

                    $sizes = $this->arrayWithoutNull($request->input('sizes', []));
                    $sizesPrice = $request->input('sizes_price', []);

                    foreach ($sizes as $index => $size) {

                        $attribute = Attribute::updateOrCreate(
                            ['product_id' => $product->id, 'size_id' => $sizes[$index], 'color_id' => null],
                            ['price' => $sizesPrice[$index] ?? $request->input('price'), 'quantity' => $index, 'sku' => 'zxc']
                        );
                    }
                }
                if ($request['sectionChoice'] == "both") {

                    $attributeSizes = $this->arrayWithoutNull($request->input('attribute_size', []));
                    $attributeColors = $this->arrayWithoutNull($request->input('attribute_color', []));
                    $attributePrices = $this->arrayWithoutNull($request->input('attribute_price', []));

                    foreach ($attributeSizes as $index => $attributeSize) {
                        $attribute = Attribute::updateOrCreate(
                            ['product_id' => $product->id, 'size_id' => $attributeSize, 'color_id' => $attributeColors[$index]],
                            ['price' => $attributePrices[$index] ?? $request->input('price'), 'quantity' => 1, 'sku' => 'zxc']
                        );
                    }
                }



                // Update product images
                if ($request->hasFile('images')) {
                    $images = $request->file('images');
                    foreach ($images as $index => $image) {
                        $data['image'] = $this->saveImage($image, 'product');
                        $productImage = new ProductImage;
                        $productImage->product_id = $product->id;
                        $productImage->image = 'imagesfp/product/' . $data['image'];
                        $productImage->save();
                    }
                }
                session()->flash('Add', 'تم تعديل المنتج بنجاح');
                DB::commit();
                return redirect()->back()->with('success', 'Product updated successfully.');
            } else {
                DB::rollback();
                session()->flash('Add', 'لا يمكنكك التعديل علي المنتج');
                return redirect()->back()->with('error', 'You are not authorized to update this product.');
            }
        } catch (\Exception $e) {

            DB::rollback();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            // Retrieve the product
            $product = Product::findOrFail($request->id);
            $this->deleteImage($product->image);

            // Delete the product images and remove the images from storage
            $product->images()->each(function ($image) {
                $this->deleteImage($image->image);
            });

            // Delete the product
            $product->delete();

            DB::commit();
            session()->flash('delete', 'تم الحذف  ');
            return redirect()->back()->withSuccess('Product deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteImage($id)
    {
        $image = ProductImage::find($id);

        if (!$image) {
            return response()->json(['success' => false, 'message' => 'Image not found.'], 404);
        }
        $productImagesCount = ProductImage::where('product_id', $image->product_id)->count();

        // Check if it's the last image
        if ($productImagesCount <= 1) {
            return response()->json(['success' => false, 'message' => 'You cannot delete the last image.'], 400);
        }
        // $this->deleteImage($image->image);
        $image->delete();
        return response()->json(['success' => true, 'message' => 'Image deleted successfully.'], 200);
    }



    public function destroyAttr(Request $request)
    {
        DB::beginTransaction();
        try {
            // Retrieve the product
            $attribute = Attribute::findOrFail($request->id);
            // Delete the product
            $attribute->delete();

            DB::commit();
            return redirect()->back()->withSuccess('attribute deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    public function updateStatusProduct(Request $request)
    {
        $isToggleOnString = (string) $request->isToggleOn;
        $status = true;
        $productId = $request->input('productId');
        if ($isToggleOnString == "true") {
            $status = true;
        } else {
            $status = false;
        }



        $product = Product::find($productId);

        if ($product) {
            // Update the status field
            $product->status = $status;
            $product->save();

            return response()->json(['success' => true, 'message' => 'product status  updated successfully']);
        }

        return response()->json(['success' => false, 'message' => 'product not found']);
    }

    public function getSubsections(Request $request)
    {
        $categoryId = $request->input('category');

        // Retrieve subsections based on the selected category ID
        $subcategory = SubCategory::where('category_id', $categoryId)->pluck('name_ar', 'id');

        return response()->json($subcategory, 200);
    }


    public function arrayWithoutNull($array)
    {
        $arrayValues = array_filter($array, function ($value) {
            return $value !== null;
        });

        return array_values($arrayValues);
    }
}
