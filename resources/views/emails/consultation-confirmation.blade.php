<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تأكيد استلام طلب الاستشارة - OX Tech</title>
</head>
<body style="margin: 0; padding: 0; background-color: #071827; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #ffffff; direction: rtl; text-align: right;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #071827; padding: 40px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="background-color: #0c2532; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 18px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.5);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 30px 40px; background: linear-gradient(135deg, #0c2532 0%, #153b4f 100%); border-bottom: 2px solid #c9fa4b; text-align: center;">
                            <h1 style="margin: 0; font-size: 28px; font-weight: 800; color: #c9fa4b; letter-spacing: 2px;">OX TECH</h1>
                            <p style="margin: 5px 0 0; font-size: 14px; color: #a0aec0;">حلول البرمجيات السحابية وتطوير الأنظمة الذكية</p>
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px;">
                            <h2 style="margin: 0 0 15px; color: #ffffff; font-size: 22px;">مرحباً {{ $consultation->name }}،</h2>
                            <p style="margin: 0 0 25px; line-height: 1.8; color: #cbd5e1; font-size: 15px;">
                                يسعدنا في <strong style="color: #c9fa4b;">OX Tech</strong> إبلاغك بأنه تم استلام طلب استشارتك التقنية بنجاح. يقوم فريقنا الهندسي والاستشاري بدراسة متطلبات مشروعك حالياً، وسنتواصل معك خلال <strong>24 ساعة</strong> لتحديد موعد الجلسة الاستشارية المجانية.
                            </p>

                            <!-- Summary Card -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; margin-bottom: 30px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <h3 style="margin: 0 0 15px; color: #c9fa4b; font-size: 16px; border-bottom: 1px solid rgba(255, 255, 255, 0.1); padding-bottom: 8px;">ملخص بيانات الطلب:</h3>
                                        <p style="margin: 6px 0; font-size: 14px; color: #e2e8f0;"><strong>نوع المشروع:</strong> {{ $consultation->project_type ?? 'غير محدد' }}</p>
                                        <p style="margin: 6px 0; font-size: 14px; color: #e2e8f0;"><strong>الشركة / الجهة:</strong> {{ $consultation->company_name ?? 'شخصي' }}</p>
                                        <p style="margin: 6px 0; font-size: 14px; color: #e2e8f0;"><strong>الميزانية المتوقعة:</strong> {{ $consultation->budget ?? 'حسب العرض الفني' }}</p>
                                        <p style="margin: 6px 0; font-size: 14px; color: #e2e8f0;"><strong>رقم الجوال:</strong> {{ $consultation->phone ?? 'غير متوفر' }}</p>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 30px; font-size: 14px; color: #94a3b8; line-height: 1.7;">
                                إذا كان لديك أي استفسار عاجل أو ملفات إضافية ترغب في مشاركتها، يمكنك الرد مباشرة على هذا البريد أو مراسلتنا عبر الواتساب.
                            </p>

                            <div style="text-align: center;">
                                <a href="https://wa.me/966500000000" style="display: inline-block; background-color: #c9fa4b; color: #071827; padding: 14px 32px; border-radius: 50px; font-weight: 700; text-decoration: none; font-size: 15px;">محادثة المستشار عبر واتساب</a>
                            </div>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="padding: 25px 40px; background-color: #071827; text-align: center; border-top: 1px solid rgba(255, 255, 255, 0.05);">
                            <p style="margin: 0 0 5px; font-size: 13px; color: #64748b;">الرياض (السعودية) • القاهرة (مصر) • دبي (الإمارات)</p>
                            <p style="margin: 0; font-size: 12px; color: #475569;">© {{ date('Y') }} OX Tech Software House. جميع الحقوق محفوظة.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
