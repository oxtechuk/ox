<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فاتورة رقم {{ $invoice->invoice_number }}</title>
</head>
<body style="margin: 0; padding: 0; background-color: #071827; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #ffffff; direction: rtl; text-align: right;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #071827; padding: 35px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="650" cellspacing="0" cellpadding="0" style="background-color: #0c2532; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 16px; overflow: hidden;">
                    <tr>
                        <td style="padding: 30px; background: linear-gradient(135deg, #0c2532 0%, #1a365d 100%); border-bottom: 2px solid #1f63ff;">
                            <table role="presentation" width="100%">
                                <tr>
                                    <td>
                                        <h1 style="margin: 0; font-size: 26px; color: #c9fa4b;">OX TECH</h1>
                                        <p style="margin: 3px 0 0; font-size: 13px; color: #94a3b8;">فاتورة ضريبية / مطالبة مالية</p>
                                    </td>
                                    <td align="left">
                                        <span style="font-size: 18px; font-weight: bold; color: #ffffff;">{{ $invoice->invoice_number }}</span><br>
                                        <span style="font-size: 12px; color: #94a3b8;">تاريخ الإصدار: {{ $invoice->invoice_date ? $invoice->invoice_date->format('Y-m-d') : ($invoice->created_at ? $invoice->created_at->format('Y-m-d') : date('Y-m-d')) }}</span><br>
                                        <span style="font-size: 12px; color: #f87171;">تاريخ الاستحقاق: {{ $invoice->due_date ? $invoice->due_date->format('Y-m-d') : 'فوري' }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 35px;">
                            <h2 style="margin: 0 0 10px; color: #ffffff; font-size: 20px;">السيد / {{ $invoice->client->name }}</h2>
                            <p style="margin: 0 0 20px; color: #cbd5e1; font-size: 14px; line-height: 1.7;">
                                مرفق إليكم الفاتورة الخاصة بمشروع: <strong style="color: #60a5fa;">{{ $invoice->title }}</strong>.
                            </p>

                            @if($customMessage)
                                <div style="background-color: rgba(31, 99, 255, 0.1); border-right: 3px solid #1f63ff; padding: 12px 16px; margin-bottom: 25px; border-radius: 6px; font-size: 14px; color: #f1f5f9;">
                                    {{ $customMessage }}
                                </div>
                            @endif

                            <!-- Status Badge -->
                            <div style="background-color: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; padding: 15px; margin-bottom: 25px; text-align: center;">
                                <span style="font-size: 13px; color: #94a3b8;">حالة الفاتورة:</span>
                                @if($invoice->status === 'paid')
                                    <span style="background-color: #22c55e; color: #ffffff; font-weight: bold; padding: 4px 12px; border-radius: 20px; font-size: 13px; margin-right: 8px;">مدفوعة بالكامل ✅</span>
                                @elseif($invoice->status === 'partially_paid')
                                    <span style="background-color: #f59e0b; color: #ffffff; font-weight: bold; padding: 4px 12px; border-radius: 20px; font-size: 13px; margin-right: 8px;">مدفوعة جزئياً ⏳</span>
                                @elseif($invoice->status === 'overdue')
                                    <span style="background-color: #ef4444; color: #ffffff; font-weight: bold; padding: 4px 12px; border-radius: 20px; font-size: 13px; margin-right: 8px;">متأخرة السداد ⚠️</span>
                                @else
                                    <span style="background-color: #3b82f6; color: #ffffff; font-weight: bold; padding: 4px 12px; border-radius: 20px; font-size: 13px; margin-right: 8px;">بانتظار السداد 💳</span>
                                @endif
                            </div>

                            <!-- Financial Breakdown -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="8" style="font-size: 14px; background-color: rgba(0,0,0,0.25); border-radius: 8px; margin-bottom: 25px;">
                                <tr>
                                    <td align="right" style="color: #94a3b8;">المبلغ قبل الضريبة:</td>
                                    <td align="left" style="color: #ffffff;">{{ number_format($invoice->subtotal, 2) }} {{ $invoice->currency }}</td>
                                </tr>
                                @if($invoice->discount_amount > 0)
                                    <tr>
                                        <td align="right" style="color: #4ade80;">الخصم:</td>
                                        <td align="left" style="color: #4ade80;">- {{ number_format($invoice->discount_amount, 2) }} {{ $invoice->currency }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td align="right" style="color: #94a3b8;">ضريبة القيمة المضافة ({{ $invoice->vat_rate }}%):</td>
                                    <td align="left" style="color: #ffffff;">{{ number_format($invoice->vat_amount, 2) }} {{ $invoice->currency }}</td>
                                </tr>
                                <tr style="border-top: 1px solid rgba(255,255,255,0.1);">
                                    <td align="right" style="color: #ffffff; font-weight: bold; font-size: 16px;">إجمالي الفاتورة:</td>
                                    <td align="left" style="color: #ffffff; font-weight: bold; font-size: 16px;">{{ number_format($invoice->total_amount, 2) }} {{ $invoice->currency }}</td>
                                </tr>
                                <tr>
                                    <td align="right" style="color: #22c55e;">المبلغ المسدد:</td>
                                    <td align="left" style="color: #22c55e; font-weight: 600;">{{ number_format($invoice->paid_amount, 2) }} {{ $invoice->currency }}</td>
                                </tr>
                                <tr style="border-top: 2px solid #ef4444;">
                                    <td align="right" style="color: #f87171; font-weight: bold; font-size: 17px; padding-top: 10px;">المبلغ المتبقي المطلوب سداده:</td>
                                    <td align="left" style="color: #f87171; font-weight: bold; font-size: 17px; padding-top: 10px;">{{ number_format($invoice->due_amount, 2) }} {{ $invoice->currency }}</td>
                                </tr>
                            </table>

                            <!-- Payment details -->
                            <div style="background-color: rgba(255,255,255,0.03); border-radius: 8px; padding: 15px; font-size: 13px; color: #94a3b8; margin-bottom: 25px;">
                                <p style="margin: 0 0 5px; color: #c9fa4b; font-weight: bold;">معلومات الحساب البنكي للتحويل:</p>
                                <p style="margin: 3px 0;"><strong>البنك:</strong> مصرف الراجحي / البنك الأهلي السعودي (SNB)</p>
                                <p style="margin: 3px 0;"><strong>اسم المستفيد:</strong> مؤسسة أوكس للتقنية وتطوير البرمجيات</p>
                                <p style="margin: 3px 0;"><strong>IBAN:</strong> SA00 0000 0000 0000 0000 0000</p>
                            </div>

                            <div style="text-align: center;">
                                <a href="mailto:finance@ox-tech.sa?subject={{ urlencode('إشعار تحويل فاتورة ' . $invoice->invoice_number) }}" style="display: inline-block; background-color: #1f63ff; color: #ffffff; padding: 12px 30px; border-radius: 50px; font-weight: bold; text-decoration: none; font-size: 14px;">إرسال إشعار السداد 📩</a>
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
