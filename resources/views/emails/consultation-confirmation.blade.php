@php
    $locale = app()->getLocale();
    if (!in_array($locale, ['ar', 'en', 'fr'], true)) {
        $locale = 'ar';
    }
    $isRtl = $locale === 'ar';

    $content = [
        'ar' => [
            'title' => 'تأكيد استلام طلب الاستشارة - OX Tech',
            'sub' => 'حلول البرمجيات السحابية وتطوير الأنظمة الذكية',
            'greeting' => 'مرحباً ' . ($consultation->name ?? '') . '،',
            'body' => 'يسعدنا في <strong style="color: #BDFF45;">OX Tech</strong> إبلاغك بأنه تم استلام طلب استشارتك التقنية بنجاح. يقوم فريقنا الهندسي والاستشاري بدراسة متطلبات مشروعك حالياً، وسنتواصل معك خلال <strong>24 ساعة</strong> لتحديد موعد الجلسة الاستشارية المجانية.',
            'summary_title' => 'ملخص بيانات الطلب:',
            'project_type' => 'نوع المشروع:',
            'company' => 'الشركة / الجهة:',
            'budget' => 'الميزانية المتوقعة:',
            'phone' => 'رقم الجوال:',
            'note' => 'إذا كان لديك أي استفسار عاجل أو ملفات إضافية ترغب في مشاركتها، يمكنك الرد مباشرة على هذا البريد أو مراسلتنا عبر الواتساب.',
            'whatsapp_btn' => 'محادثة المستشار عبر واتساب',
            'branches' => 'الرياض (السعودية) • القاهرة (مصر) • دبي (الإمارات)',
            'copyright' => 'جميع الحقوق محفوظة.',
            'default_type' => 'غير محدد',
            'default_company' => 'شخصي',
            'default_budget' => 'حسب العرض الفني',
            'default_phone' => 'غير متوفر',
        ],
        'en' => [
            'title' => 'Consultation Request Confirmation - OX Tech',
            'sub' => 'Enterprise Cloud Solutions & Intelligent Software Engineering',
            'greeting' => 'Hello ' . ($consultation->name ?? '') . ',',
            'body' => 'We are pleased to confirm that your technical consultation request has been received by <strong style="color: #BDFF45;">OX Tech</strong>. Our solutions architects and engineering leads are reviewing your project scope, and we will reach out within <strong>24 hours</strong> to schedule your discovery session.',
            'summary_title' => 'Project Request Summary:',
            'project_type' => 'Project Type:',
            'company' => 'Company / Entity:',
            'budget' => 'Estimated Budget:',
            'phone' => 'Phone / WhatsApp:',
            'note' => 'If you have any urgent questions or technical briefs to share, feel free to reply directly to this email or chat with us on WhatsApp.',
            'whatsapp_btn' => 'Chat with our Tech Advisor',
            'branches' => 'Riyadh (KSA) • Cairo (Egypt) • Dubai (UAE)',
            'copyright' => 'All rights reserved.',
            'default_type' => 'Not Specified',
            'default_company' => 'Individual',
            'default_budget' => 'Based on Proposal',
            'default_phone' => 'Not provided',
        ],
        'fr' => [
            'title' => 'Confirmation de Demande de Consultation - OX Tech',
            'sub' => 'Ingénierie Logicielle & Architectures Cloud d\'Entreprise',
            'greeting' => 'Bonjour ' . ($consultation->name ?? '') . ',',
            'body' => 'Nous avons le plaisir de vous confirmer la bonne réception de votre demande de consultation par <strong style="color: #BDFF45;">OX Tech</strong>. Nos architectes logiciels analysent vos besoins et prendront contact avec vous sous <strong>24 heures</strong> pour planifier votre session découverte.',
            'summary_title' => 'Récapitulatif de votre demande :',
            'project_type' => 'Type de Projet :',
            'company' => 'Entreprise / Organisation :',
            'budget' => 'Budget Estimé :',
            'phone' => 'Téléphone / WhatsApp :',
            'note' => 'Si vous souhaitez partager des cahiers des charges ou documents complémentaires, vous pouvez répondre directement à cet email ou nous contacter via WhatsApp.',
            'whatsapp_btn' => 'Échanger sur WhatsApp',
            'branches' => 'Riyad (Arabie Saoudite) • Le Caire (Égypte) • Dubaï (EAU)',
            'copyright' => 'Tous droits réservés.',
            'default_type' => 'Non spécifié',
            'default_company' => 'Personnel',
            'default_budget' => 'Selon devis',
            'default_phone' => 'Non renseigné',
        ],
    ];

    $t = $content[$locale] ?? $content['ar'];
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $t['title'] }}</title>
</head>
<body style="margin: 0; padding: 0; background-color: #060F1A; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #ffffff; direction: {{ $isRtl ? 'rtl' : 'ltr' }}; text-align: {{ $isRtl ? 'right' : 'left' }};">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #060F1A; padding: 40px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="background-color: #0c2532; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 18px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.5);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 30px 40px; background: linear-gradient(135deg, #0c2532 0%, #153b4f 100%); border-bottom: 2px solid #BDFF45; text-align: center;">
                            <h1 style="margin: 0; font-size: 28px; font-weight: 800; color: #BDFF45; letter-spacing: 2px;">OX TECH</h1>
                            <p style="margin: 5px 0 0; font-size: 14px; color: #a0aec0;">{{ $t['sub'] }}</p>
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px;">
                            <h2 style="margin: 0 0 15px; color: #ffffff; font-size: 22px;">{{ $t['greeting'] }}</h2>
                            <p style="margin: 0 0 25px; line-height: 1.8; color: #cbd5e1; font-size: 15px;">
                                {!! $t['body'] !!}
                            </p>

                            <!-- Summary Card -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; margin-bottom: 30px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <h3 style="margin: 0 0 15px; color: #BDFF45; font-size: 16px; border-bottom: 1px solid rgba(255, 255, 255, 0.1); padding-bottom: 8px;">{{ $t['summary_title'] }}</h3>
                                        <p style="margin: 6px 0; font-size: 14px; color: #e2e8f0;"><strong>{{ $t['project_type'] }}</strong> {{ $consultation->project_type ?? $t['default_type'] }}</p>
                                        <p style="margin: 6px 0; font-size: 14px; color: #e2e8f0;"><strong>{{ $t['company'] }}</strong> {{ $consultation->company_name ?? $t['default_company'] }}</p>
                                        <p style="margin: 6px 0; font-size: 14px; color: #e2e8f0;"><strong>{{ $t['budget'] }}</strong> {{ $consultation->budget ?? $t['default_budget'] }}</p>
                                        <p style="margin: 6px 0; font-size: 14px; color: #e2e8f0;"><strong>{{ $t['phone'] }}</strong> {{ $consultation->phone ?? $t['default_phone'] }}</p>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 30px; font-size: 14px; color: #94a3b8; line-height: 1.7;">
                                {{ $t['note'] }}
                            </p>

                            <div style="text-align: center;">
                                <a href="https://wa.me/966500000000" style="display: inline-block; background-color: #BDFF45; color: #060F1A; padding: 14px 32px; border-radius: 50px; font-weight: 700; text-decoration: none; font-size: 15px;">{{ $t['whatsapp_btn'] }}</a>
                            </div>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="padding: 25px 40px; background-color: #060F1A; text-align: center; border-top: 1px solid rgba(255, 255, 255, 0.05);">
                            <p style="margin: 0 0 5px; font-size: 13px; color: #64748b;">{{ $t['branches'] }}</p>
                            <p style="margin: 0; font-size: 12px; color: #475569;">© {{ date('Y') }} OX Tech Software House. {{ $t['copyright'] }}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
