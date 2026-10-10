<?php

namespace Database\Seeders;

use App\Models\DigitalProduct;
use App\Models\ProductCategory;
use App\Models\ProductLandingPage;
use Illuminate\Database\Seeder;

class DigitalProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Categories
        $catAccounting = ProductCategory::updateOrCreate(
            ['slug' => 'business-accounting'],
            [
                'name' => 'برامج إدارة الأعمال والمحاسبة',
                'icon' => 'calculator',
                'description' => 'حلول برمجية متطورة لإدارة المخزون، الحسابات المالية، والفاتورة الإلكترونية.',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        $catMarketing = ProductCategory::updateOrCreate(
            ['slug' => 'marketing-automation'],
            [
                'name' => 'أدوات وحلول التسويق الرقمي',
                'icon' => 'bullhorn',
                'description' => 'برمجيات أتمتة الحملات الإعلانية، الرسائل التلقائية وتتبع التحويلات.',
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        $catCrm = ProductCategory::updateOrCreate(
            ['slug' => 'crm-customer-service'],
            [
                'name' => 'أنظمة خدمة العملاء والـ CRM',
                'icon' => 'users-gear',
                'description' => 'منصات إدارة علاقات العملاء، التذاكر، والمحادثات الموحدة للفرق.',
                'sort_order' => 3,
                'is_active' => true,
            ]
        );

        $catDataTools = ProductCategory::updateOrCreate(
            ['slug' => 'data-targeting-tools'],
            [
                'name' => 'أدوات جمع البيانات والاستهداف',
                'icon' => 'database',
                'description' => 'برمجيات جمع وتنقية بيانات العملاء من المنصات وتصديرها لحملات إعلانية مستهدفة.',
                'sort_order' => 4,
                'is_active' => true,
            ]
        );

        // 2. Main Flagship Product: OxPro ERP
        $oxPro = DigitalProduct::updateOrCreate(
            ['slug' => 'oxpro-erp-system'],
            [
                'category_id' => $catAccounting->id,
                'name' => 'نظام OxPro ERP المتكامل لإدارة الشركات والمخازن',
                'slug' => 'oxpro-erp-system',
                'tagline' => 'برنامج المحاسبة وإدارة المخزون والفاتورة الإلكترونية رقم 1 للشركات والمتاجر في الشرق الأوسط',
                'description' => 'نظام متكامل صُمم ليمكنك من إدارة كافة العمليات المحاسبية والمخازن وإصدار الفواتير الإلكترونية المعتمدة بكبسة زر واحدة. يشمل شاشات بيع POS سريعة، تقارير أرباح وخسائر لحظية، إدارة العملاء والموردين، مع حماية وتشفير عالي وتحديثات مستمرة مدى الحياة.',
                'features' => [
                    'دعم كامل لمنظومة الفاتورة الإلكترونية والإيصال الإلكتروني بنسبة 100%',
                    'إدارة دقيقة للمخازن وتنبيهات النواقص وحركات الجرد الدوري',
                    'نقطة بيع POS سريعة تعمل مع قارئات الباركود والشاشات اللمسية',
                    'تقارير تفصيلية لحظية للأرباح، التدفقات النقدية والمبيعات',
                    'نظام صلاحيات متقدم متعدد المستخدمين مع سجل تدقيق كامل للعمليات',
                    'تفعيل فوري مع ترخيص مدى الحياة بدون اشتراكات شهرية متكررة',
                ],
                'system_requirements' => [
                    'نظام التشغيل: Windows 10/11 أو macOS 12+ أو سيرفر محلي Linux',
                    'المعالج: Dual Core 2.0 GHz أو أحدث',
                    'الذاكرة العشوائية (RAM): 4GB كحد أدنى (يوصى بـ 8GB)',
                    'المساحة التخزينية: 500MB مساحة متوفرة',
                ],
                'price' => 2499.00,
                'sale_price' => 1499.00,
                'currency' => 'EGP',
                'version' => '3.4.0',
                'demo_url' => 'https://demo.oxtech.com/oxpro',
                'thumbnail' => '/images/products/oxpro-banner.jpg',
                'gallery' => [
                    '/images/products/oxpro-1.jpg',
                    '/images/products/oxpro-2.jpg',
                    '/images/products/oxpro-3.jpg',
                ],
                'file_name' => 'OxPro_ERP_Setup_v3.4.0.zip',
                'download_limit' => 10,
                'expiry_days' => 365,
                'has_license_key' => true,
                'is_featured' => true,
                'status' => 'active',
                'meta_title' => 'تحميل برنامج OxPro ERP - أفضل برنامج محاسبة وإدارة مخازن للشركات',
                'meta_description' => 'اشترِ الآن برنامج OxPro ERP لإدارة الفواتير والمخازن مع خصم خاص وتفعيل فوري مدى الحياة.',
            ]
        );


        // ═══════════════════════════════════════════════════════════
        //  ScripOx — Customer Data Aggregator & Targeting Suite
        // ═══════════════════════════════════════════════════════════
        $scripOx = DigitalProduct::updateOrCreate(
            ['slug' => 'scripox-data-targeting'],
            [
                'category_id' => $catDataTools->id,
                'name' => 'ScripOx — جمع بيانات العملاء وإنشاء جماهير الإعلانات في خطوة واحدة',
                'slug' => 'scripox-data-targeting',
                'tagline' => 'اجمع بيانات عملائك من كل منصة، نظّفها واستهدفها في Meta وGoogle بضغطة زر. أداة الشركات الناشئة الأولى لتوفير 80% من ميزانية الإعلانات.',
                'description' => "ScripOx هو الحل المتكامل للشركات الناشئة والمسوقين الرقميين الذين يريدون جمع بيانات عملائهم من منصات متعددة (Meta، LinkedIn، X، Google Leads، WhatsApp Groups، Sheets…) ومعالجتها وتصفيتها ثم تصديرها مباشرة لإنشاء Custom Audiences على Facebook & Instagram أو Google Display، أو بناء ملفات إعلانات احترافية جاهزة للرفع.\n\nالبرنامج يتكون من جزأين متكاملين:\n\n① Chrome Extension (ScripOx Scraper):\nتعمل مع المتصفح وتجمع بيانات العملاء (أسماء، ايميلات، أرقام، مواضع جغرافية) من المنصات تلقائياً وتصدّرها كملف Excel أو JSON جاهز.\n\n② Desktop App (ScripOx Studio):\nيستورد ملفات الـ Extension، يعرض كل عميل في كارت تفصيلي مع موقعه على الخريطة التفاعلية، وتفاصيل التواصل الكاملة، مع فلاتر متقدمة (الموقع، الاهتمام، المصدر). ثم يصدّر الجمهور مباشرة لـ Meta Custom Audience أو ملف CSV لـ Google Ads بضغطة زر.",
                'features' => [
                    ' Extension لجمع بيانات العملاء من Meta، LinkedIn، X، WhatsApp Groups، وGoogle Leads تلقائياً',
                    ' تصدير فوري كـ Excel أو JSON منظم وجاهز للمعالجة',
                    ' كارت تفصيلي لكل عميل بالاسم والبريد والهاتف وتفاصيل التواصل الكاملة',
                    ' عرض موقع العميل على خريطة تفاعلية بدقة جغرافية عالية',
                    ' فلاتر ذكية: حسب الموقع، المصدر، الاهتمام، والنشاط',
                    ' تصدير مباشر لـ Meta Custom Audience (Facebook & Instagram)',
                    ' تصدير لـ Google Ads Customer Match بصيغة CSV معتمدة',
                    ' بناء ملف إعلانات احترافي جاهز للرفع بضغطة زر واحدة',
                    ' مزامنة تلقائية بين Extension والـ Desktop App',
                    ' ترخيص دائم – ادفع مرة واحدة واستخدم للأبد',
                ],
                'system_requirements' => [
                    'نظام التشغيل: Windows 10/11 (64-bit) للـ Desktop App',
                    'المتصفح: Google Chrome أو Edge (للـ Extension)',
                    'الذاكرة العشوائية (RAM): 4GB كحد أدنى',
                    'الإنترنت: مطلوب فقط لوقت الجمع والتصدير للمنصات',
                    'المساحة التخزينية: 250MB للـ Desktop App',
                ],
                'price' => 100.00,
                // Promo code offer: $5 until Oct 19, 2026 — after that normal price applies
                'sale_price' => null,
                'currency' => 'USD',
                'version' => '1.0.0',
                'demo_url' => 'https://oxtech.studio/demo/scripox',
                'thumbnail' => '/images/products/scripox-banner.jpg',
                'gallery' => [
                    '/images/products/scripox-extension.jpg',
                    '/images/products/scripox-studio.jpg',
                    '/images/products/scripox-map.jpg',
                    '/images/products/scripox-export.jpg',
                ],
                'file_name' => 'ScripOx_Studio_v1.0.0_Setup.exe',
                'download_limit' => 5,
                'expiry_days' => 365,
                'has_license_key' => true,
                'is_featured' => true,
                'status' => 'active',
                'meta_title' => 'ScripOx — برنامج جمع بيانات العملاء وإنشاء جماهير الإعلانات | OX Tech',
                'meta_description' => 'اجمع بيانات عملائك من Meta وGoogle والمنصات، نظّفها وصدّرها كـ Custom Audience جاهز. ترخيص دائم بـ 100$ فقط. عرض لفترة محدودة.',
            ]
        );

        // Full Landing Page — ScripOx (Sales / Startup Story)
        ProductLandingPage::updateOrCreate(
            ['product_id' => $scripOx->id],
            [
                'slug' => 'scripox',
                'headline' => 'أنت تصرف آلاف الدولارات على إعلانات تستهدف الجميع — ScripOx يجعلك تستهدف فقط من يشتري',
                'subheadline' => 'برنامجان في ترخيص واحد: Extension يجمع بيانات عملائك من كل منصة، وDesktop App يحوّلها إلى جمهور إعلاني مستهدف على Meta وGoogle بضغطة زر — بدون اشتراكات، ادفع مرة واحدة.',
                'hero_badge' => '🔥 عرض إطلاق حصري: احصل عليه بـ 5$ فقط مع كود الترقية — ينتهي 19 أكتوبر',
                'video_url' => null,
                'timer_ends_at' => \Carbon\Carbon::create(2026, 10, 19, 23, 59, 59, 'Africa/Cairo'),
                'key_benefits' => [
                    [
                        'title' => 'وفّر 80% من ميزانية الإعلانات',
                        'desc' => 'بدل ما تستهدف ملايين الأشخاص وتدفع عليهم، استهدف فقط من لديه اهتمام حقيقي بمنتجك بناءً على بياناته الفعلية.',
                        'icon' => 'chart-line',
                    ],
                    [
                        'title' => 'جمهور إعلاني جاهز في 10 دقائق',
                        'desc' => 'Extension يجمع البيانات، Studio يرتبها ويصدّرها مباشرة لـ Meta Custom Audience أو Google Customer Match.',
                        'icon' => 'bolt',
                    ],
                    [
                        'title' => 'خريطة تفاعلية لعملائك',
                        'desc' => 'شوف فين عملائك المحتملين على الخريطة وحدّد نطاق الاستهداف الجغرافي بدقة.',
                        'icon' => 'map-pin',
                    ],
                    [
                        'title' => 'ترخيص دائم — ادفع مرة واحدة',
                        'desc' => 'لا اشتراكات شهرية، لا رسوم تجديد. ادفع 100$ مرة واحدة وامتلك البرنامجين للأبد مع التحديثات.',
                        'icon' => 'infinity',
                    ],
                ],
                'social_proof_stats' => [
                    ['label' => 'شركة ناشئة تستخدمه منذ البيتا', 'value' => '+120'],
                    ['label' => 'عميل مجمّع ومعالَج حتى الآن', 'value' => '+850K'],
                    ['label' => 'توفير في تكلفة الإعلانات (متوسط)', 'value' => '78%'],
                    ['label' => 'دعم فني واستجابة', 'value' => '24/7'],
                ],
                'testimonials' => [
                    [
                        'name' => 'ك. نور الدين رشيدي',
                        'role' => 'مؤسس ومسوق رقمي — Noor Digital Agency',
                        'comment' => 'قبل ScripOx كنت بصرف 3000$ شهرياً على إعلانات Broad. بعده بقيت بصرف 700$ وبنفس النتيجة بل أحسن. الـ Custom Audience الـ Studio بيولدها دقيقة جداً.',
                        'rating' => 5,
                    ],
                    [
                        'name' => 'أ. مريم الفاروق',
                        'role' => 'CEO — StartupLab Cairo',
                        'comment' => 'كل startup ناشئة محتاجة هذا التول قبل أي شيء. بدل ما تحرق بودجتك على استهداف عشوائي، ScripOx بيديك بيانات حقيقية من السوق. استثمار يعود 10x.',
                        'rating' => 5,
                    ],
                    [
                        'name' => 'م. حسن الطيب',
                        'role' => 'Growth Hacker — TechBoost KSA',
                        'comment' => 'الـ Extension بيوفر عليّ ساعات يدوية كل أسبوع. والـ Studio مع الخريطة خلاني أشوف إن أغلب عملائي في منطقة معينة — غيّرت استراتيجيتي بالكامل.',
                        'rating' => 5,
                    ],
                ],
                'faq_items' => [
                    [
                        'question' => 'ما الفرق بين الـ Extension والـ Desktop App؟',
                        'answer' => 'الـ Chrome Extension هو أداة جمع البيانات — تشغّلها على المنصة وهي تجمع بيانات العملاء وتحفظها كملف Excel. أما الـ Desktop App (ScripOx Studio) فهو مركز المعالجة: يستورد الملف، يعرض كارت تفصيلي لكل عميل مع موقعه على الخريطة، يتيح الفلترة، ثم يصدّر الجمهور لـ Meta أو Google.',
                    ],
                    [
                        'question' => 'ما المنصات التي يدعمها ScripOx حالياً؟',
                        'answer' => 'الإصدار الأول يدعم: Meta (Facebook & Instagram Leads)، LinkedIn Connections، X (Twitter) Followers، مجموعات WhatsApp، Google Sheets / Lead Forms، وملفات Excel العامة. سيتوسع دعم المنصات في تحديثات قادمة.',
                    ],
                    [
                        'question' => 'كيف يعمل كود الخصم الخاص؟ هل سعر 5$ ثابت؟',
                        'answer' => 'العرض مؤقت جداً وينتهي في 19 أكتوبر 2026. من لديه كود الترقية الخاص يشتري بـ 5$ فقط بدل 100$. بعد التاريخ يعود السعر لـ 100$ ولن يتجدد هذا العرض.',
                    ],
                    [
                        'question' => 'هل يتوافق مع سياسات Meta وGoogle؟',
                        'answer' => 'ScripOx يتبع المعايير المحددة لملفات Custom Audience: البيانات مشفرة بـ SHA-256 قبل الرفع. يقع على المستخدم ضمان أن البيانات المجمّعة مأذون باستخدامها وفق سياسات كل منصة.',
                    ],
                    [
                        'question' => 'ماذا لو واجهت مشكلة في التثبيت؟',
                        'answer' => 'فريق دعم OX Tech متاح عبر واتساب والمحادثة المباشرة لمساعدتك في التثبيت خطوة بخطوة مجاناً. كما نوفر فيديو تفصيلي للإعداد.',
                    ],
                ],
                'comparison_table' => [
                    [
                        'feature' => 'جمع البيانات من المنصات',
                        'us' => 'Extension تلقائي — كل المنصات الكبرى',
                        'others' => 'يدوي أو API مدفوعة معقدة',
                    ],
                    [
                        'feature' => 'إنشاء Custom Audience',
                        'us' => 'مباشر لـ Meta & Google بضغطة',
                        'others' => 'تحتاج أدوات منفصلة بآلاف الدولارات',
                    ],
                    [
                        'feature' => 'خريطة جغرافية للعملاء',
                        'us' => 'مدمجة في Studio بدون إضافات',
                        'others' => 'غير متوفرة أو بتكلفة إضافية',
                    ],
                    [
                        'feature' => 'نموذج التسعير',
                        'us' => 'دفع مرة واحدة — 100$ للأبد',
                        'others' => 'اشتراكات شهرية $50–$500/شهر',
                    ],
                ],
                'guarantee_text' => 'إذا لم يوفر ScripOx ما وعدنا به خلال 14 يوماً من الشراء، نعيد لك المبلغ بالكامل بدون أي أسئلة.',
                'cta_text' => 'احصل على ScripOx الآن — 100$ ترخيص دائم',
                'primary_color' => '#F59E0B',
                'is_published' => true,
            ]
        );
    }
}
