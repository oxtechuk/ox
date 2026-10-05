<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تنبيه: طلب استشارة جديد | OX Tech CRM</title>
</head>
<body style="margin: 0; padding: 0; background-color: #060F1A; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #ffffff; direction: rtl; text-align: right;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #060F1A; padding: 30px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="650" cellspacing="0" cellpadding="0" style="background-color: #0c2532; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 16px; overflow: hidden;">
                    <tr>
                        <td style="padding: 25px 35px; background: linear-gradient(135deg, #1A56F5 0%, #0c2532 100%); border-bottom: 3px solid #BDFF45;">
                            <span style="background-color: #BDFF45; color: #060F1A; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 20px; text-transform: uppercase;">Lead Alert 🎯</span>
                            <h2 style="margin: 10px 0 0; color: #ffffff; font-size: 22px;">طلب استشارة جديد من: {{ $consultation->name }}</h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px 35px;">
                            <!-- Attribution Badge -->
                            <div style="background-color: rgba(31, 99, 255, 0.15); border: 1px solid #1A56F5; border-radius: 10px; padding: 15px; margin-bottom: 25px;">
                                <h3 style="margin: 0 0 10px; color: #60a5fa; font-size: 15px;">📊 مصدر العميل التسويقي (Lead Attribution):</h3>
                                <p style="margin: 4px 0; font-size: 14px;"><strong>المنصة المكتشفة:</strong> <span style="background-color: #BDFF45; color: #060F1A; font-weight: bold; padding: 2px 8px; border-radius: 6px;">{{ $consultation->platform_detected ?? 'Direct / Organic' }}</span></p>
                                <p style="margin: 4px 0; font-size: 13px; color: #cbd5e1;"><strong>UTM Source:</strong> {{ $consultation->utm_source ?? 'N/A' }} | <strong>Medium:</strong> {{ $consultation->utm_medium ?? 'N/A' }} | <strong>Campaign:</strong> {{ $consultation->utm_campaign ?? 'N/A' }}</p>
                                @if($consultation->referrer_url)
                                    <p style="margin: 4px 0; font-size: 12px; color: #94a3b8; word-break: break-all;"><strong>الرابط المرجعي:</strong> {{ $consultation->referrer_url }}</p>
                                @endif
                            </div>

                            <!-- Lead Details -->
                            <h3 style="margin: 0 0 12px; color: #BDFF45; font-size: 16px;">تفاصيل العميل والمشروع:</h3>
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="8" style="background-color: rgba(255,255,255,0.02); border-radius: 8px; font-size: 14px; margin-bottom: 25px;">
                                <tr>
                                    <td width="30%" style="color: #94a3b8;">الاسم الكامل:</td>
                                    <td style="color: #ffffff; font-weight: 600;">{{ $consultation->name }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #94a3b8;">البريد الإلكتروني:</td>
                                    <td><a href="mailto:{{ $consultation->email }}" style="color: #60a5fa; text-decoration: none;">{{ $consultation->email }}</a></td>
                                </tr>
                                <tr>
                                    <td style="color: #94a3b8;">رقم الجوال:</td>
                                    <td><a href="tel:{{ $consultation->phone }}" style="color: #BDFF45; text-decoration: none; font-weight: bold;">{{ $consultation->phone }}</a></td>
                                </tr>
                                <tr>
                                    <td style="color: #94a3b8;">اسم الشركة / المنظمة:</td>
                                    <td style="color: #ffffff;">{{ $consultation->company_name ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #94a3b8;">نوع الخدمة / المشروع:</td>
                                    <td style="color: #ffffff;">{{ $consultation->project_type ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #94a3b8;">الميزانية التقديرية:</td>
                                    <td style="color: #BDFF45; font-weight: bold;">{{ $consultation->budget ?? 'غير محدد' }}</td>
                                </tr>
                            </table>

                            <h3 style="margin: 0 0 8px; color: #BDFF45; font-size: 15px;">نص الرسالة / تفاصيل الفكرة:</h3>
                            <div style="background-color: #060F1A; border-left: 3px solid #BDFF45; padding: 15px; border-radius: 6px; font-size: 14px; line-height: 1.7; color: #e2e8f0; margin-bottom: 25px;">
                                {{ $consultation->message }}
                            </div>

                            <div style="text-align: center;">
                                <a href="{{ route('admin.consultations.index') }}" style="display: inline-block; background-color: #1A56F5; color: #ffffff; padding: 12px 28px; border-radius: 8px; font-weight: 600; text-decoration: none; font-size: 14px; margin-left: 10px;">فتح لوحة التحكم</a>
                                <a href="{{ route('admin.crm.clients.create', ['name' => $consultation->name, 'email' => $consultation->email, 'phone' => $consultation->phone ?? '', 'company' => $consultation->company_name ?? '']) }}" style="display: inline-block; background-color: #BDFF45; color: #060F1A; padding: 12px 28px; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 14px;">تحويل إلى عميل CRM 🚀</a>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
