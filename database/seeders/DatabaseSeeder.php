<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Consultation;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\SiteContent;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\TrackingPixel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin Users
        User::updateOrCreate(
            ['email' => 'admin@oxtech.studio'],
            [
                'name' => 'مدير النظام',
                'password' => Hash::make('admin123456'),
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'editor@oxtech.studio'],
            [
                'name' => 'مسؤول المحتوى',
                'password' => Hash::make('editor123456'),
                'role' => 'editor',
                'is_active' => true,
            ]
        );

        // 2. Portfolio Projects (Live Seed)
        $this->call(ProjectSeeder::class);

        // 3. Testimonials & Partner Video Reviews
        $testimonials = [
            [
                'partner_name' => 'سارة العتيبي',
                'partner_role' => 'CEO، مِرسال',
                'partner_country' => 'السعودية',
                'quote' => 'فريق OX لم يبنِ لنا متجرًا فقط؛ رتّب رحلة العميل كاملة وجعل الفريق يرى الأرقام بشكل أوضح.',
                'video_type' => 'url',
                'video_url' => 'assets/videos/story-1.mp4',
                'poster_image' => 'assets/ox-saudi-story.png',
                'number_badge' => '01',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'partner_name' => 'نور الدين',
                'partner_role' => 'مؤسس، نَهْر',
                'partner_country' => 'العراق',
                'quote' => 'بدأنا بفكرة تشغيلية معقدة، وانتهينا بمنصة يفهمها العميل وفريق العمليات من أول مرة.',
                'video_type' => 'url',
                'video_url' => 'assets/videos/story-2.mp4',
                'poster_image' => 'assets/ox-hero.png',
                'number_badge' => '02',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'partner_name' => 'عمر مدني',
                'partner_role' => 'COO، DRIVE+',
                'partner_country' => 'الإمارات',
                'quote' => 'الهدوء في التنفيذ والوضوح في التفاصيل جعلانا نثق في كل خطوة من رحلة المنتج.',
                'video_type' => 'url',
                'video_url' => 'assets/videos/story-3.mp4',
                'poster_image' => 'assets/ox-saudi-founder-video.jpg',
                'number_badge' => '03',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(['partner_name' => $t['partner_name']], $t);
        }

        // 4. Initial Consultations
        $consultations = [
            [
                'name' => 'عبدالعزيز الشمري',
                'email' => 'aziz@alshammari-group.sa',
                'phone' => '+966501234567',
                'company_name' => 'مجموعة الشمري القابضة',
                'project_type' => 'منصات ومواقع',
                'budget' => '30,000 - 50,000 $',
                'message' => 'نحتاج بناء منصة رقمية لإدارة العقارات والمستأجرين وربطها مع نظام السداد الإلكتروني.',
                'status' => 'new',
                'admin_notes' => 'طلب واعد، يحتاج لتحديد موعد اتصال عبر جوجل ميت.',
            ],
            [
                'name' => 'مريم الكعبي',
                'email' => 'mariam@dubaitech.ae',
                'phone' => '+971559876543',
                'company_name' => 'Dubai Tech Solutions',
                'project_type' => 'تطبيقات ومنتجات',
                'budget' => '20,000 - 35,000 $',
                'message' => 'تطبيق لتتبع خدمات الشحن السريع للشركات الناشئة مع لوحة تحكم فورية.',
                'status' => 'contacted',
                'admin_notes' => 'تم التواصل عبر الواتساب وتحديد موعد يوم الثلاثاء القادم.',
            ],
        ];

        foreach ($consultations as $c) {
            Consultation::updateOrCreate(['email' => $c['email']], $c);
        }

        // 5. Site Contents (Dynamic Sections)
        $contents = [
            [
                'key' => 'hero_kicker',
                'group' => 'hero',
                'label' => 'عبارة الهيرو العلوية (Kicker)',
                'value' => 'SOFTWARE HOUSE · 2021 — NOW',
            ],
            [
                'key' => 'hero_title_p1',
                'group' => 'hero',
                'label' => 'عنوان الهيرو الرئيسي',
                'value' => 'نبني منتجات',
            ],
            [
                'key' => 'hero_title_highlight',
                'group' => 'hero',
                'label' => 'الكلمة المميزة باللون الأخضر (Lime)',
                'value' => 'تتحرك.',
            ],
            [
                'key' => 'hero_description',
                'group' => 'hero',
                'label' => 'وصف الهيرو',
                'value' => 'شريكك التقني من أول فكرة إلى منتج يُستخدم ويكبر. مواقع، متاجر، تطبيقات ومنتجات SaaS تُصمم لتخدم السوق فعلًا.',
            ],
            [
                'key' => 'hero_proof_stat_1',
                'group' => 'hero',
                'label' => 'إحصائية الهيرو 1',
                'value' => '+48 منتج أُطلق',
            ],
            [
                'key' => 'hero_proof_stat_2',
                'group' => 'hero',
                'label' => 'إحصائية الهيرو 2',
                'value' => '8 أسواق نخدمها',
            ],
            [
                'key' => 'hero_proof_stat_3',
                'group' => 'hero',
                'label' => 'إحصائية الهيرو 3',
                'value' => '4.9/5 رضا الشركاء',
            ],
            [
                'key' => 'trust_clients',
                'group' => 'hero',
                'label' => 'شريط العملاء والشركاء الموثوقين',
                'value' => 'RASED, NEXA, مِرسال, VELA, GOBOX, بِداية',
            ],
            [
                'key' => 'about_story_title',
                'group' => 'about',
                'label' => 'عنوان قصة البداية',
                'value' => 'بدأنا من السعودية. وكبرنا بثقة شركائنا.',
            ],
            [
                'key' => 'about_story_p',
                'group' => 'about',
                'label' => 'نص قصة البداية',
                'value' => 'في 2021 بدأنا كفريق صغير يؤمن أن التقنية لازم تفهم الناس والسوق قبل أي شيء. أول مشاريعنا كانت لفرق سعودية طموحة تحتاج حلولًا أسرع وأوضح—ومن هناك تعلّمنا أن أفضل المنتجات تبدأ من الاستماع الجيد.',
            ],
            [
                'key' => 'consult_title',
                'group' => 'consult',
                'label' => 'عنوان قسم حجز الاستشارة',
                'value' => 'عندك فكرة؟ خلّينا نرتّبها.',
            ],
            [
                'key' => 'consult_subtitle',
                'group' => 'consult',
                'label' => 'وصف حجز الاستشارة',
                'value' => 'استشارة أولية مركزة لمدة 30 دقيقة. نسمع فكرتك، نحدد فرصها، ونقترح الخطوة الأنسب.',
            ],
            [
                'key' => 'contact_email',
                'group' => 'contact',
                'label' => 'البريد الإلكتروني للشركة',
                'value' => 'hello@oxtech.studio',
            ],
        ];

        foreach ($contents as $item) {
            SiteContent::updateOrCreate(['key' => $item['key']], $item);
        }

        // 6. Comprehensive Site Settings (General, Branding, Footer, Regional Tech SEO, SMTP)
        $settings = [
            // Branding & Logos
            ['key' => 'site_name', 'value' => 'OX Tech Studio', 'group' => 'general', 'type' => 'text', 'label' => 'اسم المنصة / الشركة'],
            ['key' => 'site_tagline', 'value' => 'بيت برمجيات متكامل لرواد الأعمال والشركات الطموحة', 'group' => 'general', 'type' => 'text', 'label' => 'شعار الشركة (Tagline)'],
            ['key' => 'header_logo_text', 'value' => 'OX.', 'group' => 'branding', 'type' => 'text', 'label' => 'شعار الهيدر النصي'],
            ['key' => 'header_logo_sub', 'value' => 'TECH STUDIO', 'group' => 'branding', 'type' => 'text', 'label' => 'الوصف التابع للشعار'],
            ['key' => 'custom_logo_image', 'value' => null, 'group' => 'branding', 'type' => 'file', 'label' => 'صورة اللوجو المخصص (PNG/SVG)'],
            ['key' => 'custom_favicon', 'value' => null, 'group' => 'branding', 'type' => 'file', 'label' => 'أيقونة الموقع (Favicon)'],

            // Footer & Corporate
            ['key' => 'footer_description', 'value' => 'بيت برمجيات سعودي معاصر. نبني منصات ومتاجر وتطبيقات وحلول SaaS تصنع الفارق الحقيقي في نمو الأعمال.', 'group' => 'footer', 'type' => 'textarea', 'label' => 'نبذة الفوتر'],
            ['key' => 'footer_copyright', 'value' => '© '.date('Y').' OX Tech. جميع الحقوق محفوظة.', 'group' => 'footer', 'type' => 'text', 'label' => 'حقوق النشر'],
            ['key' => 'phone_ksa', 'value' => '+966 50 123 4567', 'group' => 'footer', 'type' => 'text', 'label' => 'هاتف / واتساب الرياض'],
            ['key' => 'phone_uae', 'value' => '+971 50 987 6543', 'group' => 'footer', 'type' => 'text', 'label' => 'هاتف / واتساب دبي'],
            ['key' => 'phone_egypt', 'value' => '+20 100 123 4567', 'group' => 'footer', 'type' => 'text', 'label' => 'هاتف / واتساب القاهرة'],
            ['key' => 'address_riyadh', 'value' => 'طريق الملك فهد، حي الملقا، الرياض، المملكة العربية السعودية', 'group' => 'footer', 'type' => 'text', 'label' => 'عنوان مكتب الرياض'],
            ['key' => 'address_dubai', 'value' => 'خليج الأعمال (Business Bay)، دبي، الإمارات العربية المتحدة', 'group' => 'footer', 'type' => 'text', 'label' => 'عنوان مكتب دبي'],
            ['key' => 'address_cairo', 'value' => 'التجمع الخامس، القاهرة الجديدة، مصر', 'group' => 'footer', 'type' => 'text', 'label' => 'عنوان مكتب القاهرة'],

            // Social Media & Map Links
            ['key' => 'social_linkedin', 'value' => 'https://www.linkedin.com/company/ox-tech', 'group' => 'social', 'type' => 'text', 'label' => 'لينكد إن (LinkedIn)'],
            ['key' => 'social_instagram', 'value' => 'https://www.instagram.com/oxtech.uk', 'group' => 'social', 'type' => 'text', 'label' => 'إنستغرام'],
            ['key' => 'social_github', 'value' => 'https://github.com/oxtechuk', 'group' => 'social', 'type' => 'text', 'label' => 'جيت هب (GitHub)'],
            ['key' => 'social_tiktok', 'value' => 'https://www.tiktok.com/@oxtech.uk', 'group' => 'social', 'type' => 'text', 'label' => 'تيك توك'],
            ['key' => 'social_youtube', 'value' => 'https://www.youtube.com/@oxtech-uk', 'group' => 'social', 'type' => 'text', 'label' => 'يوتيوب'],
            ['key' => 'social_whatsapp', 'value' => 'https://wa.me/201008616682', 'group' => 'social', 'type' => 'text', 'label' => 'رابط واتساب المباشر'],
            ['key' => 'google_maps_url', 'value' => 'https://share.google/82M8ufbu784MYpH3y', 'group' => 'contact', 'type' => 'text', 'label' => 'رابط موقع الشركة خرائط جوجل'],
            ['key' => 'contact_phone_primary', 'value' => '+20 10 08616682', 'group' => 'contact', 'type' => 'text', 'label' => 'رقم الهاتف الرئيسي'],
            ['key' => 'contact_email_primary', 'value' => 'contact@oxtech.uk', 'group' => 'contact', 'type' => 'text', 'label' => 'البريد الإلكتروني الرئيسي'],

            // Regional Tech SEO (KSA, Egypt, UAE)
            ['key' => 'seo_meta_title', 'value' => 'OX Tech | أفضل بيت برمجيات وتطوير تطبيقات ومواقع في السعودية والإمارات ومصر', 'group' => 'seo', 'type' => 'text', 'label' => 'عنوان الـ SEO الأساسي (Meta Title)'],
            ['key' => 'seo_meta_description', 'value' => 'شريكك التقني المعتمد لتطوير التطبيقات، المتاجر الإلكترونية، المنصات السحابية SaaS، وتكاملات الدفع في الرياض ودبي والقاهرة. استشارة مجانية مع خبرائنا.', 'group' => 'seo', 'type' => 'textarea', 'label' => 'وصف الـ SEO (Meta Description)'],
            ['key' => 'seo_meta_keywords', 'value' => 'شركة برمجيات بالرياض, شركة تطوير تطبيقات السعودية, Software House Dubai, برمجة متاجر سلة وزد, برمجة تطبيقات مصر, بيت برمجيات, برمجة SaaS', 'group' => 'seo', 'type' => 'textarea', 'label' => 'الكلمات المفتاحية (Meta Keywords)'],
            ['key' => 'seo_canonical_url', 'value' => 'https://oxtech.studio', 'group' => 'seo', 'type' => 'text', 'label' => 'الرابط الأساسي (Canonical URL)'],
            ['key' => 'default_currency', 'value' => 'SAR', 'group' => 'general', 'type' => 'text', 'label' => 'العملة الافتراضية (SAR / USD / AED / EGP)'],
            ['key' => 'vat_rate', 'value' => '15', 'group' => 'general', 'type' => 'text', 'label' => 'نسبة ضريبة القيمة المضافة %'],
        ];

        foreach ($settings as $s) {
            SiteSetting::updateOrCreate(['key' => $s['key']], $s);
        }

        // 7. Tracking Pixels (Google, Meta, Snapchat, TikTok)
        $pixels = [
            ['platform' => 'google_analytics', 'pixel_id' => 'G-OXTECH2026', 'is_active' => true],
            ['platform' => 'google_tag_manager', 'pixel_id' => 'GTM-OX8899', 'is_active' => true],
            ['platform' => 'meta', 'pixel_id' => '987654321098765', 'is_active' => true],
            ['platform' => 'snapchat', 'pixel_id' => 'snap-pixel-ox-2026', 'is_active' => true],
            ['platform' => 'tiktok', 'pixel_id' => 'TT-OXTECH-COMMERCE', 'is_active' => true],
            ['platform' => 'linkedin', 'pixel_id' => 'LI-9823412', 'is_active' => false],
            ['platform' => 'x_twitter', 'pixel_id' => 'TW-OX-PIXEL', 'is_active' => false],
        ];

        foreach ($pixels as $p) {
            TrackingPixel::updateOrCreate(['platform' => $p['platform']], $p);
        }

        // 8. Initial CRM Clients, Quotations & Invoices (Demonstration Suite)
        $client1 = Client::updateOrCreate(
            ['email' => 'contact@mersal.sa'],
            [
                'name' => 'سارة العتيبي',
                'company_name' => 'شركة مِرسال اللوجستية',
                'phone' => '+966 50 111 2233',
                'country' => 'السعودية',
                'city' => 'الرياض',
                'vat_number' => '300123456700003',
                'status' => 'active',
                'source_platform' => 'snapchat',
                'notes' => 'عميل استراتيجي لمتجر وتطبيق مِرسال اللوجستي.',
            ]
        );

        $client2 = Client::updateOrCreate(
            ['email' => 'nasser@driveplus.ae'],
            [
                'name' => 'ناصر المنصوري',
                'company_name' => 'مجموعة درايف بلس للسيارات',
                'phone' => '+971 50 333 4455',
                'country' => 'الإمارات',
                'city' => 'دبي',
                'vat_number' => '100456789000003',
                'status' => 'active',
                'source_platform' => 'meta',
                'notes' => 'مشروع نظام حجز وصيانة المركبات وتطبيق الفنيين.',
            ]
        );

        $client3 = Client::updateOrCreate(
            ['email' => 'omar@madahealth.eg'],
            [
                'name' => 'د. عمر مدني',
                'company_name' => 'شبكة عيادات مَدى الطبية',
                'phone' => '+20 100 555 6677',
                'country' => 'مصر',
                'city' => 'القاهرة',
                'vat_number' => '540123987',
                'status' => 'in_negotiation',
                'source_platform' => 'tiktok',
                'notes' => 'طلب استشارة لتطوير منصة طبية وتطبيقات حجز المرضى.',
            ]
        );

        // Create Quotations for Client 1
        $quotation1 = Quotation::updateOrCreate(
            ['quotation_number' => 'QT-2026-0001'],
            [
                'client_id' => $client1->id,
                'title' => 'تطوير منصة تجارة إلكترونية متكاملة وتطبيق جوال',
                'subtotal' => 45000.00,
                'discount_type' => 'percentage',
                'discount_value' => 10.00,
                'discount_amount' => 4500.00,
                'vat_percentage' => 15.00,
                'vat_amount' => 6075.00,
                'total_amount' => 46575.00,
                'currency' => 'SAR',
                'status' => 'accepted',
                'issue_date' => now()->subDays(20),
                'valid_until' => now()->addDays(10),
                'terms_and_conditions' => "1. الدفع مقسم على 3 دفعات.\n2. الدعم الفني مجاني لمدة 3 أشهر بعد الإطلاق.\n3. التسليم وفق الجدول الزمني المعتمد.",
                'notes' => 'يشمل تكاملات الدفع مع مدى وأبل باي وتابي وتمارا.',
            ]
        );

        // Add Quotation Items
        QuotationItem::updateOrCreate(
            ['quotation_id' => $quotation1->id, 'service_name' => 'تصميم واجهة وتجربة المستخدم UX/UI'],
            ['description' => 'تصميم كامل لواجهات الويب وتطبيقات الجوال بنظام Figma التفاعلي', 'unit_price' => 12000.00, 'quantity' => 1, 'total' => 12000.00, 'order' => 1]
        );
        QuotationItem::updateOrCreate(
            ['quotation_id' => $quotation1->id, 'service_name' => 'برمجة وتطوير المتجر الإلكتروني والباك إند'],
            ['description' => 'بناء المنصة على Laravel مع تكاملات الدفع والشحن المباشر', 'unit_price' => 20000.00, 'quantity' => 1, 'total' => 20000.00, 'order' => 2]
        );
        QuotationItem::updateOrCreate(
            ['quotation_id' => $quotation1->id, 'service_name' => 'تطبيق الجوال iOS & Android'],
            ['description' => 'تطبيق هجين فائق السرعة عبر Flutter', 'unit_price' => 13000.00, 'quantity' => 1, 'total' => 13000.00, 'order' => 3]
        );

        // Create Invoice for Client 1
        $invoice1 = Invoice::updateOrCreate(
            ['invoice_number' => 'INV-2026-0001'],
            [
                'client_id' => $client1->id,
                'quotation_id' => $quotation1->id,
                'title' => 'فاتورة الدفعة الأولى والثانية - منصة مِرسال للتجارة',
                'total_amount' => 46575.00,
                'paid_amount' => 30000.00,
                'due_amount' => 16575.00,
                'currency' => 'SAR',
                'status' => 'partial',
                'issue_date' => now()->subDays(15),
                'due_date' => now()->addDays(14),
                'payment_terms' => 'دفعة مقدمة 50% مستلمة + دفعة ثانية بعد التصميم مستلمة، المتبقي عند الإطلاق.',
                'notes' => 'المستحق المتبقي: 16,575 ريال سعودي بعد الفحص النهائي.',
            ]
        );

        // Add payment for invoice 1
        InvoicePayment::updateOrCreate(
            ['invoice_id' => $invoice1->id, 'transaction_reference' => 'TXN-BANK-998822'],
            [
                'amount' => 30000.00,
                'payment_method' => 'bank_transfer',
                'payment_date' => now()->subDays(10),
                'notes' => 'تحويل بنكي - الدفعة المقدمة والدفعة الثانية',
            ]
        );

        // 7. Digital Products & Product Categories
        $this->call(DigitalProductSeeder::class);
    }
}
