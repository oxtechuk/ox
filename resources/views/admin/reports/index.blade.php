@extends('layouts.admin')

@section('title', 'تقارير الأداء ومصادر الزيارات | OX Tech')
@section('header_title', 'لوحة التقارير والتحليلات ومصادر الاستشارات (Attribution & Finance Reports)')

@section('content')
<div style="max-width: 1200px;">

    <!-- Top Executive Financial Metrics -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 18px; margin-bottom: 24px;">
        <div class="card" style="margin-bottom: 0; border-right: 4px solid var(--brand-blue);">
            <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 6px; font-weight: 600;">إجمالي المبيعات المفوترة</div>
            <div style="font-size: 26px; font-weight: 800; color: var(--text-heading); font-family: var(--font-code);">
                {{ number_format($totalInvoiced, 2) }} <span style="font-size: 13px; color: var(--text-muted);">SAR</span>
            </div>
        </div>

        <div class="card" style="margin-bottom: 0; border-right: 4px solid #10b981;">
            <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 6px; font-weight: 600;">إجمالي الإيرادات المحصلة</div>
            <div style="font-size: 26px; font-weight: 800; color: #047857; font-family: var(--font-code);">
                {{ number_format($totalCollected, 2) }} <span style="font-size: 13px; color: #047857;">SAR</span>
            </div>
        </div>

        <div class="card" style="margin-bottom: 0; border-right: 4px solid #ef4444;">
            <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 6px; font-weight: 600;">المستحقات والديون الآجلة (Due)</div>
            <div style="font-size: 26px; font-weight: 800; color: #b91c1c; font-family: var(--font-code);">
                {{ number_format($totalOutstanding, 2) }} <span style="font-size: 13px; color: #b91c1c;">SAR</span>
            </div>
        </div>

        <div class="card" style="margin-bottom: 0; border-right: 4px solid var(--brand-forest);">
            <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 6px; font-weight: 600;">إجمالي طلبات الاستشارة الواردة</div>
            <div style="font-size: 26px; font-weight: 800; color: var(--brand-forest); font-family: var(--font-code);">
                {{ $totalConsultations }} <span style="font-size: 13px; color: var(--text-muted);">طلب</span>
            </div>
        </div>
    </div>

    <!-- Marketing Attribution Breakdown Card -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">مصادر الاستشارات والعملاء التسويقية (Marketing Attribution)</h3>
            <span style="font-size: 11.5px; color: var(--brand-green); font-weight: 700;">تتبع تلقائي عبر بكسلات ومحددات UTM</span>
        </div>

        <p style="font-size: 12.5px; color: var(--text-muted); margin-bottom: 20px;">
            توضح هذه الإحصائيات المنصات والحملات الإعلانية التي جلبت طلبات الاستشارة والعملاء المحتملين:
        </p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 15px; margin-bottom: 20px;">
            @php
                $colors = [
                    'Snapchat' => '#eab308',
                    'TikTok' => '#0f172a',
                    'Meta Ads' => '#1d4ed8',
                    'Meta (Instagram/Facebook)' => '#db2777',
                    'Google Ads / Search' => '#2563eb',
                    'Google Organic' => '#059669',
                    'Direct' => '#64748b',
                    'Direct / Organic' => '#64748b',
                ];
            @endphp

            @forelse($platformAttribution as $item)
                @php
                    $pct = $totalConsultations > 0 ? round(($item->count / $totalConsultations) * 100, 1) : 0;
                    $platformName = $item->platform_detected ?: 'Direct / Organic';
                    $accentColor = $colors[$platformName] ?? 'var(--brand-green)';
                @endphp
                <div style="background: #f8fafc; border: 1px solid var(--border-card); border-radius: 10px; padding: 16px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <strong style="color: var(--text-heading); font-size: 13.5px;">
                            <span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background: {{ $accentColor }}; margin-left: 6px;"></span>
                            {{ $platformName }}
                        </strong>
                        <span style="font-size: 15px; font-weight: 800; color: var(--text-heading); font-family: var(--font-code);">
                            {{ $item->count }} <small style="font-size: 11px; color: var(--text-muted);">({{ $pct }}%)</small>
                        </span>
                    </div>

                    <!-- Progress bar -->
                    <div style="height: 6px; background: #e2e8f0; border-radius: 99px; overflow: hidden;">
                        <div style="width: {{ $pct }}%; height: 100%; background: {{ $accentColor }}; border-radius: 99px;"></div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 20px;">لا توجد بيانات تتبع مسجلة بعد.</div>
            @endforelse
        </div>
    </div>

    <!-- Secondary Reports Grid (Services, Due Invoices) -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">

        <!-- Top Demanded Software Services -->
        <div class="card" style="margin-bottom: 0;">
            <div class="card-header">
                <h3 class="card-title">أكثر الخدمات والأنظمة طلباً</h3>
            </div>
            <div style="display: flex; flex-direction: column; gap: 14px;">
                @forelse($projectTypes as $pType)
                    @php
                        $pPct = $totalConsultations > 0 ? round(($pType->count / $totalConsultations) * 100, 1) : 0;
                    @endphp
                    <div>
                        <div style="display: flex; justify-content: space-between; font-size: 12.5px; margin-bottom: 5px;">
                            <span style="color: var(--text-heading); font-weight: 700;">{{ $pType->project_type }}</span>
                            <span style="color: var(--brand-forest); font-family: var(--font-code); font-weight: 600;">{{ $pType->count }} طلب ({{ $pPct }}%)</span>
                        </div>
                        <div style="height: 6px; background: #e2e8f0; border-radius: 99px; overflow: hidden;">
                            <div style="width: {{ $pPct }}%; height: 100%; background: var(--brand-green); border-radius: 99px;"></div>
                        </div>
                    </div>
                @empty
                    <p style="color: var(--text-muted); font-size: 12px;">لا توجد بيانات خدمات مسجلة.</p>
                @endforelse
            </div>
        </div>

        <!-- Overdue & Pending Receivables -->
        <div class="card" style="margin-bottom: 0;">
            <div class="card-header">
                <h3 class="card-title">المستحقات والفواتير الآجلة الأكثر إلحاحاً</h3>
                <a href="{{ route('admin.crm.invoices.index', ['status' => 'sent']) }}" class="btn btn-outline btn-sm">عرض الكل</a>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>العميل</th>
                            <th>رقم الفاتورة</th>
                            <th>المتبقي (Due)</th>
                            <th>الاستحقاق</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($overdueInvoices as $dueInv)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.crm.clients.show', $dueInv->client) }}" style="color: var(--brand-forest); font-weight: 700; text-decoration: none;">
                                        {{ $dueInv->client->name }}
                                    </a>
                                </td>
                                <td><a href="{{ route('admin.crm.invoices.show', $dueInv) }}" style="color: var(--brand-blue); font-family: var(--font-code); text-decoration: none;">{{ $dueInv->invoice_number }}</a></td>
                                <td>
                                    <strong style="color: #b91c1c; font-family: var(--font-code);">
                                        {{ number_format($dueInv->due_amount, 2) }} {{ $dueInv->currency }}
                                    </strong>
                                </td>
                                <td>
                                    <span style="font-size: 11.5px; color: {{ ($dueInv->due_date && $dueInv->due_date < now()) ? '#b91c1c' : 'var(--text-muted)' }}; font-weight: 600;">
                                        {{ $dueInv->due_date ? $dueInv->due_date->format('Y-m-d') : 'فوري' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: #047857; padding: 25px; font-weight: 600;">لا توجد فواتير متأخرة، جميع التحصيلات منتظمة.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Leads with Full Attribution Details -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">أحدث طلبات الاستشارة ومصدر كل عميل</h3>
            <a href="{{ route('admin.consultations.index') }}" class="btn btn-outline btn-sm">عرض جميع الاستشارات</a>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>العميل / مقدم الطلب</th>
                        <th>بيانات التواصل</th>
                        <th>نوع المشروع والميزانية</th>
                        <th>المنصة التسويقية (Source)</th>
                        <th>تاريخ الطلب</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentLeads as $lead)
                        <tr>
                            <td>
                                <div>
                                    <strong style="color: var(--text-heading);">{{ $lead->name }}</strong>
                                    @if($lead->company_name)
                                        <div style="font-size: 11px; color: var(--brand-green); font-weight: 600;">{{ $lead->company_name }}</div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div><a href="mailto:{{ $lead->email }}" style="color: var(--brand-blue); text-decoration: none;">{{ $lead->email }}</a></div>
                                <div style="font-size: 11px; color: var(--brand-forest); font-weight: 600;">{{ $lead->phone ?? '—' }}</div>
                            </td>
                            <td>
                                <div style="color: var(--text-body);">{{ $lead->project_type ?? 'غير محدد' }}</div>
                                <div style="font-size: 11px; color: var(--text-muted);">ميزانية: {{ $lead->budget ?? '—' }}</div>
                            </td>
                            <td>
                                <span style="background: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe; padding: 3px 8px; border-radius: 99px; font-size: 11px; font-weight: 700;">
                                    {{ $lead->platform_detected ?? 'Direct / Organic' }}
                                </span>
                                @if($lead->utm_campaign)
                                    <div style="font-size: 10px; color: var(--text-muted); margin-top: 2px;">حملة: {{ $lead->utm_campaign }}</div>
                                @endif
                            </td>
                            <td style="font-size: 12px; color: var(--text-muted);">{{ $lead->created_at->diffForHumans() }}</td>
                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <a href="{{ route('admin.consultations.show', $lead) }}" class="btn btn-outline btn-sm">تفاصيل</a>
                                    <a href="{{ route('admin.crm.clients.create', ['name' => $lead->name, 'email' => $lead->email, 'phone' => $lead->phone, 'company' => $lead->company_name]) }}" class="btn btn-outline btn-sm">تحويل لعميل</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 25px;">لا توجد طلبات استشارة مسجلة.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
