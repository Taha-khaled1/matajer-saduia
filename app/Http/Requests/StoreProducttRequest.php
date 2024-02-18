<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreProducttRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(Request $request)
    {
        return
            [
                'name_ar' => 'required|unique:products|max:100',
                'name_en' => 'required|unique:products|max:100',
                'category' => 'required|integer',
                'sub_category_id' => 'required|integer',
                'price' => 'required|numeric',
                'quantity' => 'required|integer',
                'discount' => 'nullable|numeric',
                'arrange' => 'nullable|integer',
                'weight' => 'required|numeric',
                'description_ar' => 'required',
                'description_en' => 'required',
                'colors.*' => 'nullable',
                'shipping_fee' => 'nullable|numeric',
                'discount_start' => ($request->filled('discount') ? 'required' : 'nullable'),
                'discount_end' => ($request->filled('discount') ? 'required|after:discount_start' : 'nullable'),
                'colors_price.*' => 'nullable|numeric',
                'sizes.*' => 'nullable',
                'sizes_price.*' => 'nullable|numeric',
                'attribute_size.*' => 'nullable',
                'attribute_color.*' => 'nullable',
                'attribute_price.*' => 'nullable|numeric',
                'images.*' => 'required',
                'image' => 'required',
                'images.*.image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
            ];



    }

       public function messages()
      {
        return [
            'name_ar.required' => 'يرجى إدخال اسم الفئة بالعربية',
            'name_ar.unique' => 'اسم الفئة بالعربية مستخدم بالفعل',
            'name_en.required' => 'يرجى إدخال اسم الفئة بالإنجليزية',
            'name_en.unique' => 'اسم الفئة بالإنجليزية مستخدم بالفعل',
            'category.required' => 'يرجى اختيار الفئة',
            'sub_category_id.required' => 'يرجى اختيار الفئة الفرعية',
            'price.required' => 'يرجى إدخال السعر',  
            'price.weight' => 'يرجى إدخال الوزن',
            'price.numeric' => 'يجب أن يكون السعر رقمًا',
            'quantity.required' => 'يرجى إدخال الكمية',
            'quantity.numeric' => 'يجب أن تكون الكمية رقمًا',
            'discount.required' => 'يرجى إدخال الخصم',
            'discount.numeric' => 'يجب أن يكون الخصم رقمًا',
            'arrange.required' => 'يرجى إدخال الترتيب',
            'arrange.numeric' => 'يجب أن يكون الترتيب رقمًا',
            'description_ar.required' => 'يرجى إدخال الوصف بالعربية',
            'description_en.required' => 'يرجى إدخال الوصف بالإنجليزية',
            // 'colors.*.required' => 'يرجى اختيار الألوان',
            // 'colors_price.*.required' => 'يرجى إدخال أسعار الألوان',
            'colors_price.*.numeric' => 'يجب أن تكون أسعار الألوان أرقامًا',
            // 'sizes.*.required' => 'يرجى اختيار الأحجام',
            // 'sizes_price.*.required' => 'يرجى إدخال أسعار الأحجام',
            'sizes_price.*.numeric' => 'يجب أن تكون أسعار الأحجام أرقامًا',
            // 'attribute_size.*.required' => 'يرجى إدخال الحجم في السمات',
            // 'attribute_color.*.required' => 'يرجى اختيار الون في السمات',
            // 'attribute_price.*.required' => 'يرجى إدخال السعر في السمات',
            // 'attribute_price.*.numeric' => 'يجب أن يكون السعر في السمات رقمًا',
            'images.*.required' => 'يرجى اختيار الصور',
            'images.*.image' => 'الرجاء تحميل صورة صالحة',
            'images.*.mimes' => 'الصور المسموح بها هي jpeg، png، jpg، gif فقط',
            'images.*.max' => 'حجم الصورة يجب أن يكون حتى 2048 كيلوبايت',
        ];
    }
}