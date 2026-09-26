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

        // 3. High-Converting Landing Page for OxPro ERP
        ProductLandingPage::updateOrCreate(
            ['product_id' => $oxPro->id],
            [
                'slug' => 'oxpro-erp',
                'headline' => 'أدر شركتك ومخازنك وحساباتك باحترافية وتخلّص من فوضى الأوراق مع OxPro ERP',
                'subheadline' => 'البرنامج الأكثر موثوقية لإصدار الفواتير الإلكترونية المعتمدة وإدارة نقاط البيع بدقة 100%، مع تفعيل رقمي فوري ودعم فني عربي متخصص.',
                'hero_badge' => '🔥 عرض إطلاق حصري: خصم 40% لفترة محدودة جداً + تفعيل فوري',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'timer_ends_at' => now()->addHours(36),
                'key_benefits' => [
                    [
                        'title' => 'توفير 80% من وقت الحسابات',
                        'desc' => 'حسابات الضرائب والأرباح والتقارير المالية تُحسب تلقائياً بدون تدخل يدوي معقد.',
                        'icon' => 'clock',
                    ],
                    [
                        'title' => 'معتمد للفاتورة الإلكترونية',
                        'desc' => 'جاهز ومتوافق 100% مع هيئة الضرائب لإصدار الإيصالات والفواتير فوراً.',
                        'icon' => 'shield-check',
                    ],
                    [
                        'title' => 'حماية بياناتك وتشفير تام',
                        'desc' => 'قواعد بيانات مشفرة مع نسخ احتياطي دوري يضمن أمان معلوماتك المحاسبية.',
                        'icon' => 'lock',
                    ],
                    [
                        'title' => 'ترخيص دائم بدون مصاريف دورية',
                        'desc' => 'اشترِ البرنامج لمرة واحدة فقط واستمتع بالترخيص والتحديثات طوال العام.',
                        'icon' => 'sparkles',
                    ],
                ],
                'social_proof_stats' => [
                    ['label' => 'شركة ومتجر يعتمدون علينا', 'value' => '+1,450'],
                    ['label' => 'فاتورة ومستند تمت معالجته', 'value' => '+2.8M'],
                    ['label' => 'نسبة رضا وتقييم العملاء', 'value' => '99.4%'],
                    ['label' => 'دعم فني سريع واستجابة', 'value' => '24/7'],
                ],
                'testimonials' => [
                    [
                        'name' => 'م. أحمد الشناوي',
                        'role' => 'المدير التنفيذي - شركة التقنية الحديثة',
                        'comment' => 'برنامج OxPro وفر علينا استئجار محاسبين إضافيين، تقارير الأرباح والمخازن تظهر بدقة مذهلة وخدمة ما بعد البيع فوق الممتازة.',
                        'rating' => 5,
                    ],
                    [
                        'name' => 'أ. هاني عبد الرحمن',
                        'role' => 'مالك سلسلة محلات الأندلس',
                        'comment' => 'نظام البيع السريع POS خفيف جداً، والربط مع الفاتورة الإلكترونية تم في أقل من ربع ساعة. أنصح به بشدة.',
                        'rating' => 5,
                    ],
                    [
                        'name' => 'د. سارة المنشاوي',
                        'role' => 'مديرة العمليات - فارما كير',
                        'comment' => 'سهل الاستخدام وواجهته عربية مريحة للموظفين. عملية الشراء عبر الموقع كانت سريعة جداً وحصلنا على الملف فوراً.',
                        'rating' => 5,
                    ],
                ],
                'faq_items' => [
                    [
                        'question' => 'كيف أستلم البرنامج ومفتاح الترخيص بعد الدفع؟',
                        'answer' => 'بمجرد إتمام الدفع عبر بوابة PaySky الآمنة، سيتم نقلك مباشرة لصفحة تحميل ملف البرنامج ونسخ مفتاح التفعيل، بالإضافة إلى إرسال نسخة احتياطية فورية إلى بريدك الإلكتروني مع بيانات حسابك.',
                    ],
                    [
                        'question' => 'هل يحتاج البرنامج إلى اتصال دائم بالإنترنت؟',
                        'answer' => 'لا، البرنامج يعمل بكفاءة كاملة دون اتصال بالإنترنت (Offline Mode)، ولا يحتاج للاتصال إلا عند مزامنة الفواتير الإلكترونية أو تلقي التحديثات البرمجية.',
                    ],
                    [
                        'question' => 'هل هناك رسوم اشتراك شهرية أو سنوية مخفية؟',
                        'answer' => 'لا إطلاقاً، هذا العرض يمنحك ترخيصاً دائماً لاستخدام البرنامج مع كافة المزايا الموضحة دون أي رسوم تجديد إجبارية.',
                    ],
                    [
                        'question' => 'ماذا لو واجهت صعوبة في التثبيت أو الاستخدام؟',
                        'answer' => 'يتوفر فريق دعم فني عبر الواتساب والمحادثة المباشرة لمساعدتك في خطوات التثبيت خطوة بخطوة مجاناً.',
                    ],
                ],
                'comparison_table' => [
                    [
                        'feature' => 'الفاتورة والإيصال الإلكتروني المعتمد',
                        'us' => 'متوافق 100% وجاهز فوراً',
                        'others' => 'تكلفة إضافية واشتراك سنوي',
                    ],
                    [
                        'feature' => 'تكلفة الترخيص',
                        'us' => 'دفع لمرة واحدة وتملك دائم',
                        'others' => 'اشتراك شهري متكرر يثقل كاهلك',
                    ],
                    [
                        'feature' => 'السرعة وسهولة الاستخدام',
                        'us' => 'واجهة عربية بديهية لا تحتاج تدريب',
                        'others' => 'برامج قديمة معقدة وبطيئة',
                    ],
                    [
                        'feature' => 'الدعم الفني وتحديثات الأمان',
                        'us' => 'دعم فني فوري مع تحديثات دورية',
                        'others' => 'ردود متأخرة وتكلفة دعم إضافية',
                    ],
                ],
                'guarantee_text' => 'نضمن لك استرجاع أموالك بنسبة 100% خلال 14 يوماً إذا لم يحقق البرنامج النتائج المتوقعة لعملك.',
                'cta_text' => 'اغتنم العرض الحصري واشترِ الآن بخصم 40%',
                'primary_color' => '#0284c7',
                'is_published' => true,
            ]
        );

        // 4. Additional Products
        DigitalProduct::updateOrCreate(
            ['slug' => 'smartbot-marketing-suite'],
            [
                'category_id' => $catMarketing->id,
                'name' => 'برنامج SmartBot لأتمتة التسويق ورسائل الواتساب',
                'tagline' => 'ضاعف مبيعاتك وأرسل رسائل تسويقية ذكية لعملائك على واتساب بنقرة واحدة',
                'description' => 'برنامج تسويقي متطور يساعدك على إرسال حملاتك الإعلانية والتواصل مع الآلاف من عملائك مع تجنب الحظر، وإعداد ردود آلية ذكية على الاستفسارات مدار الساعة.',
                'features' => [
                    'إرسال رسائل مخصصة بالاسم وتفاصيل العميل',
                    'نظام روبوت للرد التلقائي (Chatbot) على الكلمات المفتاحية',
                    'استخراج الأرقام من مجموعات الواتساب وحفظها',
                    'تقارير مفصلة بنسبة الوصول والتفاعل',
                ],
                'price' => 1200.00,
                'sale_price' => 790.00,
                'currency' => 'EGP',
                'version' => '2.1.0',
                'thumbnail' => '/images/products/smartbot-banner.jpg',
                'file_name' => 'SmartBot_Automation_v2.1.zip',
                'has_license_key' => true,
                'is_featured' => true,
                'status' => 'active',
            ]
        );

        DigitalProduct::updateOrCreate(
            ['slug' => 'omnidesk-helpdesk-system'],
            [
                'category_id' => $catCrm->id,
                'name' => 'نظام OmniDesk لإدارة تذاكر الدعم وعلاقات العملاء',
                'tagline' => 'حوّل فوضى طلبات الدعم الفني إلى تجربة عملاء استثنائية وسريعة',
                'description' => 'نظام تذاكر خدمة عملاء احترافي للمواقع والشركات التقنية لمتابعة استفسارات ومشاكل العملاء وتوزيعها على فريق العمل وقياس سرعة الاستجابة بدقة.',
                'features' => [
                    'إدارة التذاكر عبر البريد والموقع والمحادثة المباشرة',
                    'توزيع المهام الآلي حسب تخصص الموظف',
                    'قاعدة معرفية (Knowledgebase) للأسئلة الشائعة للعملاء',
                    'لوحة تحكم إحصائية لأداء فريق خدمة العملاء',
                ],
                'price' => 1800.00,
                'sale_price' => 1150.00,
                'currency' => 'EGP',
                'version' => '1.5.2',
                'thumbnail' => '/images/products/omnidesk-banner.jpg',
                'file_name' => 'OmniDesk_Helpdesk_v1.5.2.zip',
                'has_license_key' => true,
                'is_featured' => false,
                'status' => 'active',
            ]
        );
    }
}
