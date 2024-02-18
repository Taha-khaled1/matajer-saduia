<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Product;

use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductSizeColor;
use App\Models\Size;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    public function run()
    {

        Product::create([
            'name_en' => 'Classic White T-Shirt',
            'name_ar' => 'قميص أبيض كلاسيكي',
            'description_en' => 'A comfortable and stylish white t-shirt made from premium cotton.',
            'description_ar' => 'قميص أبيض مريح وأنيق مصنوع من القطن الفاخر.',
            'image' => 'imagesfp/product/a.jpg',
            'arrange' => 1,
            'quantity' => 100,
            'price' => 700.0,
            'status' => true,
            'type_attribute' => "both",
            'discount' => 0.0,
            'weight' => 1,
            'shipping_fee' => 5.0,
            'discount_start' => null,
            'discount_end' => null,
            'offer' => null,
            'sku' => 'TS001',
            'sub_category_id' => 1,
            'user_id' => 1,
        ]);

        // Product 2
        Product::create([
            'name_en' => 'Leather Crossbody Bag',
            'name_ar' => 'حقيبة جلدية عبر الجسم',
            'description_en' => 'A stylish and practical leather crossbody bag for everyday use.',
            'description_ar' => 'حقيبة عبر الجسم من الجلد أنيقة وعملية للاستخدام اليومي.',
            'image' => 'imagesfp/product/s.jpg',
            'arrange' => 2,
            'quantity' => 50,
            'price' => 350.0,
            'status' => true,
            'discount' => 10.0,
            'shipping_fee' => 8.0,
            'discount_start' => '2023-07-25 00:00:00',
            'discount_end' => '2023-08-05 23:59:59',
            'offer' => 'Get 10% off on this item for a limited time!',
            'sku' => 'BG002',
            'sub_category_id' => 2,
            'user_id' => 1,
            'weight' => 2, 'type_attribute' => "sizes",
        ]);

        // Product 3
        Product::create([
            'name_en' => 'Wireless Bluetooth Earbuds',
            'name_ar' => 'سماعات لاسلكية بلوتوث',
            'description_en' => 'High-quality wireless Bluetooth earbuds for an immersive audio experience.',
            'description_ar' => 'سماعات لاسلكية بلوتوث عالية الجودة لتجربة صوتية مدهشة.',
            'image' => 'imagesfp/product/d.jpg',
            'arrange' => 3,
            'quantity' => 75,
            'price' => 100.0,
            'status' => true,
            'discount' => 0.0,
            'shipping_fee' => 4.0,
            'discount_start' => null,
            'discount_end' => null,
            'offer' => null,
            'sku' => 'EB003',
            'sub_category_id' => 3,
            'user_id' => 2,
            'weight' => 1, 'type_attribute' => "sizes",
        ]);

        // Product 4
        Product::create([
            'name_en' => 'Gaming Mechanical Keyboard',
            'name_ar' => 'لوحة مفاتيح ميكانيكية للألعاب',
            'description_en' => 'A high-performance gaming mechanical keyboard with RGB lighting.',
            'description_ar' => 'لوحة مفاتيح ميكانيكية للألعاب عالية الأداء مع إضاءة RGB.',
            'image' => 'imagesfp/product/f.jpg',
            'arrange' => 4,
            'quantity' => 30,
            'price' => 170.0,
            'status' => true,
            'discount' => 5.0,
            'shipping_fee' => 10.0,
            'discount_start' => '2023-07-20 00:00:00',
            'discount_end' => '2023-07-29 23:59:59',
            'offer' => 'Limited time offer: 5% discount on this gaming keyboard!',
            'sku' => 'KB004',
            'sub_category_id' => 4,
            'user_id' => 2,
            'weight' => 3, 'type_attribute' => "colors",
        ]);

        // Product 5
        Product::create([
            'name_en' => 'Handcrafted Ceramic Mug',
            'name_ar' => 'قدح سيراميك مصنوع يدويًا',
            'description_en' => 'A beautifully handcrafted ceramic mug, perfect for enjoying your favorite beverage.',
            'description_ar' => 'قدح سيراميك جميل مصنوع يدويًا، مثالي للاستمتاع بمشروبك المفضل.',
            'image' => 'imagesfp/product/g.jpg',
            'arrange' => 5,
            'quantity' => 20,
            'price' => 450.0,
            'status' => true,
            'discount' => 0.0,
            'shipping_fee' => 10.0,
            'discount_start' => null,
            'discount_end' => null,
            'offer' => null,
            'sku' => 'MG005',
            'sub_category_id' => 5,
            'user_id' => 2,
            'weight' => 1, 'type_attribute' => "sizes",
        ]);








        Product::create([
            'name_en' => 'Handmade Leather Wallet',
            'name_ar' => 'محفظة جلدية مصنوعة يدويًا',
            'description_en' => 'This stylish handmade leather wallet features multiple card slots and a convenient coin pocket. It is perfect for carrying your essentials in style.',
            'description_ar' => 'تتميز هذه المحفظة الجلدية المصنوعة يدويًا بعدة فتحات للبطاقات وجيب مريح للنقود النقدية. إنها مثالية لحمل الضروريات الخاصة بك بأناقة.',
            'image' => 'imagesfp/product/k.jpg',
            'arrange' => 1,
            'quantity' => 20,
            'price' => 800.0,
            'status' => true,
            'discount' => 0.0,
            'shipping_fee' => 12.0,
            'discount_start' => null,
            'discount_end' => null,
            'offer' => null,
            'sku' => 'WL001',
            'sub_category_id' => 1,
            'user_id' => 1,
            'weight' => 2,
        ]);

        Product::create([
            'name_en' => 'Handcrafted Wooden Coasters',
            'name_ar' => 'حامل أكواب خشبي مصنوع يدويًا',
            'description_en' => 'These beautiful wooden coasters are handmade and perfect for protecting your furniture from water rings and stains. They add a natural and rustic touch to any home.',
            'description_ar' => 'هذه الحوامل الخشبية الجميلة مصنوعة يدويًا ومثالية لحماية أثاث منزلك من حلقات الماء والبقع. إنها تضيف لمسة طبيعية وريفية إلى أي منزل.',
            'image' => 'imagesfp/product/l.jpg',
            'arrange' => 2,
            'quantity' => 12,
            'price' => 235.0,
            'status' => true,
            'discount' => 0.0,
            'shipping_fee' => 3.0,
            'discount_start' => null,
            'discount_end' => null,
            'offer' => null,
            'sku' => 'CO002',
            'sub_category_id' => 2,
            'user_id' => 1,
            'weight' => 3,
        ]);

        Product::create([
            'name_en' => 'Handwoven Basket',
            'name_ar' => 'سلة مصنوعة يدويًا',
            'description_en' => 'This beautiful handwoven basket is perfect for storing towels, blankets, or other items. It is a unique and stylish addition to any home décor.',
            'description_ar' => 'هذه السلة الجميلة المصنوعة يدويًا مثالية لتخزين المناشف والبطانيات وغيرها من الأشياء. إنها إضافة فريدة وأنيقة لأي ديكور منزلي.',
            'image' => 'imagesfp/product/o.jpg',
            'arrange' => 3,
            'quantity' => 8,
            'price' => 140.0,
            'status' => true,
            'discount' => 0.0,
            'shipping_fee' => 7.0,
            'discount_start' => null,
            'discount_end' => null,
            'offer' => null,
            'sku' => 'BS003',
            'sub_category_id' => 3,
            'user_id' => 1,
            'weight' => 2,
        ]);


        Product::create([
            'name_en' => 'Handmade Ceramic Lamp',
            'name_ar' => 'مصباح سيراميكي مصنوع يدويًا',
            'description_en' => 'This beautiful ceramic lamp is handmade and perfect for adding a warm glow to any room. It is a unique and stylish addition to your home décor.',
            'description_ar' => 'هذا المصباح السيراميكي الجميل مصنوع يدويًا ومثالي لإضفاء إضاءة دافئة على أي غرفة. إنه إضافة فريدة وأنيقة لديكور منزلك.',
            'image' => 'imagesfp/product/h.jpg',
            'arrange' => 5,
            'quantity' => 5,
            'price' => 150.0,
            'status' => true,
            'discount' => 0.0,
            'shipping_fee' => 9.0,
            'discount_start' => null,
            'discount_end' => null,
            'offer' => null,
            'sku' => 'LP005',
            'sub_category_id' => 5,
            'user_id' => 1,
            'weight' => 2,
        ]);


        Product::create([
            'name_en' => 'Handmade Soap Bars',
            'name_ar' => 'أصناف الصابون المصنوعة',
            'description_en' => "These handmade soap bars are made with natural ingredients and come in a variety of scents. They are gentle on the skin and perfect for everyday use",
            'description_ar' => 'تتميز أصناف الصابون المصنوعة يدويًا هذه بتركيبتها الطبيعية وتأتي بعدة روائح. إنها لطيفة على البشرة ومثالية للاستخدام اليومي.',
            'image' => 'imagesfp/product/s.jpg',
            'arrange' => 4,
            'quantity' => 30,
            'price' => 400,
            'status' => true,
            'discount' => 0.0,
            'shipping_fee' => 2.0,
            'discount_start' => null,
            'discount_end' => null,
            'offer' => null,
            'sku' => 'SP004',
            'sub_category_id' => 4,
            'user_id' => 1,
            'weight' => 1,
        ]);




        Product::create([
            'name_en' => 'Skin care product',
            'name_ar' => 'المنتجات للعناية بالبشرة',
            'description_en' => "These handmade soap bars are made with natural ingredients and come in a variety of scents. They are gentle on the skin and perfect for everyday use",
            'description_ar' => 'تتميز أصناف الصابون المصنوعة يدويًا هذه بتركيبتها الطبيعية وتأتي بعدة روائح. إنها لطيفة على البشرة ومثالية للاستخدام اليومي.',
            'image' => 'imagesfp/product/z.jpg',
            'arrange' => 4,
            'quantity' => 30,
            'price' => 200,
            'status' => true,
            'discount' => 0.0,
            'shipping_fee' => 2.0,
            'discount_start' => null,
            'discount_end' => null,
            'offer' => null,
            'sku' => 'SP004',
            'sub_category_id' => 4,
            'user_id' => 1,
            'weight' => 1,
        ]);





        Product::create([
            'name_en' => 'Physiotherapy products',
            'name_ar' => 'منتج العلاج الطبيعي',
            'description_en' => "These handmade soap bars are made with natural ingredients and come in a variety of scents. They are gentle on the skin and perfect for everyday use",
            'description_ar' => 'تتميز أصناف الصابون المصنوعة يدويًا هذه بتركيبتها الطبيعية وتأتي بعدة روائح. إنها لطيفة على البشرة ومثالية للاستخدام اليومي.',
            'image' => 'imagesfp/product/x.jpg',
            'arrange' => 4,
            'quantity' => 30,
            'price' => 150,
            'status' => true,
            'discount' => 0.0,
            'shipping_fee' => 2.0,
            'discount_start' => null,
            'discount_end' => null,
            'offer' => null,
            'sku' => 'SP004',
            'sub_category_id' => 4,
            'user_id' => 1,
            'weight' => 1,
        ]);





        // Example 1
        Product::create([
            'name_en' => 'Aromatherapy Essential Oils Set',
            'name_ar' => 'مجموعة زيوت عطرية للتدليك',
            'description_en' => 'This set includes a variety of high-quality essential oils, perfect for aromatherapy and massage therapy.',
            'description_ar' => 'تتضمن هذه المجموعة مجموعة متنوعة من زيوت الأساسية عالية الجودة، مثالية للعلاج بالروائح وعلاج التدليك.',
            'image' => 'imagesfp/product/x.jpg',
            'arrange' => 3,
            'quantity' => 25,
            'price' => 400,
            'status' => true,
            'discount' => 0.0,
            'shipping_fee' => 2.0,
            'discount_start' => null,
            'discount_end' => null,
            'offer' => null,
            'sku' => 'SP003',
            'sub_category_id' => 4,
            'user_id' => 1,
            'weight' => 2,
        ]);

        // Example 2
        Product::create([
            'name_en' => 'Organic Herbal Tea Sampler',
            'name_ar' => 'مجموعة شاي عضوي من الأعشاب',
            'description_en' => 'Explore a world of flavors with this organic herbal tea sampler, featuring a variety of soothing blends.',
            'description_ar' => 'استكشف عالم النكهات مع مجموعة شاي عضوي من الأعشاب، تتضمن مجموعة متنوعة من الخلطات المهدئة.',
            'image' => 'imagesfp/product/x.jpg',
            'arrange' => 5,
            'quantity' => 40,
            'price' => 500,
            'status' => true,
            'discount' => 0.0,
            'shipping_fee' => 2.0,
            'discount_start' => null,
            'discount_end' => null,
            'offer' => null,
            'sku' => 'SP005',
            'sub_category_id' => 4,
            'user_id' => 1,
            'weight' => 3,
        ]);

        // Example 3
        Product::create([
            'name_en' => 'Yoga Mat and Accessories Kit',
            'name_ar' => 'طقم حصيرة اليوغا والملحقات',
            'description_en' => 'Get everything you need for your yoga practice with this kit, including a high-quality yoga mat and essential accessories.',
            'description_ar' => 'احصل على كل ما تحتاجه لممارسة اليوغا مع هذا الطقم، بما في ذلك حصيرة اليوغا عالية الجودة والملحقات الأساسية.',
            'image' => 'imagesfp/product/x.jpg',
            'arrange' => 6,
            'quantity' => 15,
            'price' => 800,
            'status' => true,
            'discount' => 0.0,
            'shipping_fee' => 5.0,
            'discount_start' => null,
            'discount_end' => null,
            'offer' => null,
            'sku' => 'SP006',
            'sub_category_id' => 4,
            'user_id' => 1,
            'weight' => 2.0,
        ]);

        // Example 4
        Product::create([
            'name_en' => 'Natural Aloe Vera Gel',
            'name_ar' => 'جل الألوفيرا الطبيعي',
            'description_en' => 'A soothing and hydrating aloe vera gel for skin and hair care. It 100% natural and free from harsh chemicals.',
            'description_ar' => 'جل الألوفيرا المهدئ والمرطب للعناية بالبشرة والشعر. إنه طبيعي بنسبة 100% وخالي من المواد الكيميائية القاسية.',
            'image' => 'imagesfp/product/x.jpg',
            'arrange' => 7,
            'quantity' => 50,
            'price' => 750,
            'status' => true,
            'discount' => 0.0,
            'shipping_fee' => 3.0,
            'discount_start' => null,
            'discount_end' => null,
            'offer' => null,
            'sku' => 'SP007',
            'sub_category_id' => 4,
            'user_id' => 1,
            'weight' =>4,
        ]);

        // Example 5
        Product::create([
            'name_en' => 'Bamboo Charcoal Toothbrush Set',
            'name_ar' => 'مجموعة فرش الأسنان بالفحم الخيزراني',
            'description_en' => 'Upgrade your dental care with this eco-friendly bamboo charcoal toothbrush set.  gentle on teeth and the environment.',
            'description_ar' => 'قم بتحسين العناية بصحة الفم مع مجموعة فرش الأسنان بالفحم الخيزراني الصديقة للبيئة. إنها لطيفة على الأسنان والبيئة.',
            'image' => 'imagesfp/product/x.jpg',
            'arrange' => 8,
            'quantity' => 35,
            'price' => 450,
            'status' => true,
            'discount' => 0.0,
            'shipping_fee' => 2.0,
            'discount_start' => null,
            'discount_end' => null,
            'offer' => null,
            'sku' => 'SP008',
            'sub_category_id' => 4,
            'user_id' => 1,
            'weight' =>5,
        ]);

        // Example 6
        Product::create([
            'name_en' => 'Herbal Pain Relief Cream',
            'name_ar' => 'كريم مسكن للألم من الأعشاب',
            'description_en' => 'Relieve pain naturally with this herbal pain relief cream.  formulated with potent herbal extracts.',
            'description_ar' => 'امنح الإغاثة من الألم بشكل طبيعي مع كريم مسكن للألم من الأعشاب. تم تصنيفه بمستخلصات أعشاب فعالة.',
            'image' => 'imagesfp/product/x.jpg',
            'arrange' => 9,
            'quantity' => 20,
            'price' => 300,
            'status' => true,
            'discount' => 0.0,
            'shipping_fee' => 3.0,
            'discount_start' => null,
            'discount_end' => null,
            'offer' => null,
            'sku' => 'SP009',
            'sub_category_id' => 4,
            'user_id' => 1,
            'weight' => 6,
        ]);

        // Example 7
        Product::create([
            'name_en' => 'Organic Herbal Bath Bombs',
            'name_ar' => 'قنابل الاستحمام العضوية من الأعشاب',
            'description_en' => 'Transform your bath time into a luxurious spa experience with these organic herbal bath bombs.',
            'description_ar' => 'قم بتحويل وقت استحمامك إلى تجربة سبا فاخرة مع قنابل الاستحمام العضوية من الأعشاب.',
            'image' => 'imagesfp/product/x.jpg',
            'arrange' => 10,
            'quantity' => 30,
            'price' => 700,
            'status' => true,
            'discount' => 0.0,
            'shipping_fee' => 3.0,
            'discount_start' => null,
            'discount_end' => null,
            'offer' => null,
            'sku' => 'SP010',
            'sub_category_id' => 4,
            'user_id' => 1,
            'weight' => 5,
        ]);

        // Example 8
        Product::create([
            'name_en' => 'Organic Lavender Bath Salts',
            'name_ar' => 'ملح حمام اللافندر العضوي',
            'description_en' => 'Relax and unwind in a soothing bath with these organic lavender bath salts. They promote relaxation and stress relief.',
            'description_ar' => 'استرخ واستريح في حمام مهدئ مع ملح حمام اللافندر العضوي. يساهمون في التخلص من التوتر وتخفيف الضغوط.',
            'image' => 'imagesfp/product/x.jpg',
            'arrange' => 11,
            'quantity' => 25,
            'price' => 655,
            'status' => true,
            'discount' => 0.0,
            'shipping_fee' => 2.0,
            'discount_start' => null,
            'discount_end' => null,
            'offer' => null,
            'sku' => 'SP011',
            'sub_category_id' => 4,
            'user_id' => 1,
            'weight' => 2,
        ]);

        // Example 9
        Product::create([
            'name_en' => 'Natural Coconut Oil Hair Mask',
            'name_ar' => 'قناع الشعر بزيت جوز الهند الطبيعي',
            'description_en' => 'Nourish and strengthen your hair with this natural coconut oil hair mask.  perfect for deep conditioning.',
            'description_ar' => 'قوّي واعتني بشعرك مع قناع الشعر بزيت جوز الهند الطبيعي هذا. إنه مثالي لترطيب العمق.',
            'image' => 'imagesfp/product/x.jpg',
            'arrange' => 12,
            'quantity' => 30,
            'price' => 16,
            'status' => true,
            'discount' => 0.0,
            'shipping_fee' => 2.0,
            'discount_start' => null,
            'discount_end' => null,
            'offer' => null,
            'sku' => 'SP012',
            'sub_category_id' => 4,
            'user_id' => 1,
            'weight' => 1,
        ]);

        // Example 10
        Product::create([
            'name_en' => 'Scented Soy Candle Set',
            'name_ar' => 'مجموعة شموع الصويا المعطرة',
            'description_en' => 'Create a cozy atmosphere with this scented soy candle set. Each candle is hand-poured and infused with delightful fragrances.',
            'description_ar' => 'أنشئ جوًا دافئًا مع مجموعة شموع الصويا المعطرة هذه. تم صب كل شمعة يدويًا ومشبعة بروائح رائعة.',
            'image' => 'imagesfp/product/x.jpg',
            'arrange' => 13,
            'quantity' => 20,
            'price' => 250,
            'status' => true,
            'discount' => 0.0,
            'shipping_fee' => 3.0,
            'discount_start' => null,
            'discount_end' => null,
            'offer' => null,
            'sku' => 'SP013',
            'sub_category_id' => 4,
            'user_id' => 1,
            'weight' => 2,
        ]);
    }
}