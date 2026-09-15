<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>عرض سعر - {{ $quotation->quotation_number }}</title>
</head>
<body style="margin: 0; padding: 0; background-color: #071827; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #ffffff; direction: rtl; text-align: right;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #071827; padding: 35px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="650" cellspacing="0" cellpadding="0" style="background-color: #0c2532; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 16px; overflow: hidden;">
                    <tr>
                        <td style="padding: 30px; background: linear-gradient(135deg, #0c2532 0%, #153b4f 100%); border-bottom: 2px solid #c9fa4b;">
                            <table role="presentation" width="100%">
                                <tr>
                                    <td>
                                        <h1 style="margin: 0; font-size: 26px; color: #c9fa4b;">OX TECH</h1>
                                        <p style="margin: 3px 0 0; font-size: 13px; color: #94a3b8;">عرض سعر فني ومالي مخصص</p>
                                    </td>
                                    <td align="left">
                                        <span style="font-size: 16px; font-weight: bold; color: #ffffff;">{{ $quotation->quotation_number }}</span><br>
                                        <span style="font-size: 12px; color: #94a3b8;">التاريخ: {{ $quotation->quotation_date ? $quotation->quotation_date->format('Y-m-d') : ($quotation->created_at ? $quotation->created_at->format('Y-m-d') : date('Y-m-d')) }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 35px;">
                            <h2 style="margin: 0 0 10px; color: #ffffff; font-size: 20px;">عزيزنا العميل / {{ $quotation->client->name }}</h2>
                            <p style="margin: 0 0 20px; color: #cbd5e1; font-size: 14px; line-height: 1.7;">
                                يسر شركة <strong>OX Tech</strong> أن تقدم لكم هذا العرض الفني والمالي لتنفيذ مشروع: <strong style="color: #c9fa4b;">{{ $quotation->title }}</strong> وفق أعلى المعايير البرمجية وأفضل الممارسات التقنية.
                            </p>

                            @if($customMessage)
                                <div style="background-color: rgba(201, 250, 75, 0.08); border-right: 3px solid #c9fa4b; padding: 12px 16px; margin-bottom: 25px; border-radius: 6px; font-size: 14px; color: #f1f5f9;">
                                    {{ $customMessage }}
                                </div>
                            @endif

                            <!-- Line Items Table -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="10" style="border-collapse: collapse; margin-bottom: 25px; font-size: 14px; background-color: rgba(0,0,0,0.2); border-radius: 8px;">
                                <thead>
                                    <tr style="background-color: rgba(255,255,255,0.05); color: #c9fa4b; border-bottom: 1px solid rgba(255,255,255,0.1);">
                                        <th align="right" style="padding: 10px;">الخدمة / البند</th>
                                        <th align="center" style="padding: 10px;">الكمية</th>
                                        <th align="center" style="padding: 10px;">السعر</th>
                                        <th align="left" style="padding: 10px;">الإجمالي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($quotation->items as $item)
                                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                            <td style="padding: 10px;">
                                                <strong>{{ $item->service_name }}</strong>
                                                @if($item->description)
                                                    <br><span style="font-size: 12px; color: #94a3b8;">{{ $item->description }}</span>
                                                @endif
                                            </td>
                                            <td align="center" style="padding: 10px; color: #cbd5e1;">{{ $item->quantity }}</td>
                                            <td align="center" style="padding: 10px; color: #cbd5e1;">{{ number_format($item->unit_price, 2) }} {{ $quotation->currency }}</td>
                                            <td align="left" style="padding: 10px; font-weight: 600; color: #ffffff;">{{ number_format($item->total_price, 2) }} {{ $quotation->currency }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Financial Summary -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="6" style="font-size: 14px; margin-bottom: 30px;">
                                <tr>
                                    <td align="right" style="color: #94a3b8;">المجموع الفرعي:</td>
                                    <td align="left" style="color: #ffffff;">{{ number_format($quotation->subtotal, 2) }} {{ $quotation->currency }}</td>
                                </tr>
                                @if($quotation->discount_amount > 0)
                                    <tr>
                                        <td align="right" style="color: #4ade80;">الخصم الممنوح ({{ $quotation->discount_type === 'percentage' ? $quotation->discount_value.'%' : 'مبلغ ثابت' }}):</td>
                                        <td align="left" style="color: #4ade80;">- {{ number_format($quotation->discount_amount, 2) }} {{ $quotation->currency }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td align="right" style="color: #94a3b8;">ضريبة القيمة المضافة ({{ $quotation->vat_rate }}%):</td>
                                    <td align="left" style="color: #ffffff;">{{ number_format($quotation->vat_amount, 2) }} {{ $quotation->currency }}</td>
                                </tr>
                                <tr style="border-top: 2px solid #c9fa4b;">
                                    <td align="right" style="color: #c9fa4b; font-size: 18px; font-weight: bold; padding-top: 10px;">الإجمالي الكلي:</td>
                                    <td align="left" style="color: #c9fa4b; font-size: 18px; font-weight: bold; padding-top: 10px;">{{ number_format($quotation->total_amount, 2) }} {{ $quotation->currency }}</td>
                                </tr>
                            </table>

                            <div style="background-color: rgba(255,255,255,0.03); border: 1px dashed rgba(255,255,255,0.15); border-radius: 8px; padding: 15px; margin-bottom: 25px; font-size: 13px; color: #94a3b8;">
                                <p style="margin: 0 0 5px;"><strong>مدة صلاحية العرض:</strong> صالح حتى {{ $quotation->valid_until ? $quotation->valid_until->format('Y-m-d') : '30 يوماً من تاريخه' }}.</p>
                                @if($quotation->terms_conditions)
                                    <p style="margin: 5px 0 0;"><strong>الشروط والأحكام:</strong> {{ $quotation->terms_conditions }}</p>
                                @endif
                            </div>

                            <div style="text-align: center;">
                                <a href="https://wa.me/966500000000?text={{ urlencode('مرحباً، أود اعتماد عرض السعر رقم ' . $quotation->quotation_number) }}" style="display: inline-block; background-color: #c9fa4b; color: #071827; padding: 14px 34px; border-radius: 50px; font-weight: bold; text-decoration: none; font-size: 15px;">اعتماد العرض وتوقيع العقد ✍️</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px; background-color: #071827; text-align: center; font-size: 12px; color: #64748b; border-top: 1px solid rgba(255,255,255,0.05);">
                            OX Tech Software House • المملكة العربية السعودية • مصر • الإمارات
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
