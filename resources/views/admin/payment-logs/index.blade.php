@extends('layouts.admin')

@section('title', 'سجل عمليات بوابة PaySky (Payment Logs)')

@section('content')
<div class="admin-content-inner">
    
    <div class="topbar-actions" style="margin-bottom: 24px; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
        <div>
            <h1 class="topbar-title">📋 سجل عمليات وتتبع بوابة PaySky (Payment Logs)</h1>
            <p style="font-size: 12.5px; color: var(--text-muted); margin-top: 4px;">
                سجل تدقيق كامل لكافة الطلبات، استجابات Callback، إشعارات Webhook، وتوقيعات SecureHash
            </p>
        </div>

        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.settings.index', ['tab' => 'paysky']) }}" class="btn btn-outline btn-sm" style="display: flex; align-items: center; gap: 6px;">
                <span>⚙️ إعدادات PaySky</span>
            </a>

            <form action="{{ route('admin.payment-logs.clear_old') }}" method="POST" onsubmit="return confirm('هل تريد بالتأكيد حذف السجلات القديمة الأقدم من 30 يوماً؟');">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">
                    🗑️ تنظيف السجلات القديمة (> 30 يوم)
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px 18px; border-radius: 8px; font-size: 13px; font-weight: 600; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Stats Grid --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 12px; padding: 18px;">
            <div style="font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 4px;">إجمالي العمليات المسجلة</div>
            <div style="font-size: 24px; font-weight: 800; color: var(--text-heading); font-family: var(--font-code);">
                {{ number_format($stats['total_logs']) }}
            </div>
        </div>

        <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 12px; padding: 18px;">
            <div style="font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 4px;">عمليات ناجحة ومعتمدة</div>
            <div style="font-size: 24px; font-weight: 800; color: #059669; font-family: var(--font-code);">
                {{ number_format($stats['success_events']) }}
            </div>
        </div>

        <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 12px; padding: 18px;">
            <div style="font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 4px;">فشل / عدم تطابق التوقيع</div>
            <div style="font-size: 24px; font-weight: 800; color: #dc2626; font-family: var(--font-code);">
                {{ number_format($stats['failed_events']) }}
            </div>
        </div>

        <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 12px; padding: 18px;">
            <div style="font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 4px;">عمليات اليوم</div>
            <div style="font-size: 24px; font-weight: 800; color: #2563eb; font-family: var(--font-code);">
                {{ number_format($stats['today_events']) }}
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 12px; padding: 18px 20px; margin-bottom: 24px;">
        <form action="{{ route('admin.payment-logs.index') }}" method="GET" style="display: flex; gap: 14px; flex-wrap: wrap; align-items: flex-end;">
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px;">بحث بالمرجع أو الرسالة أو IP</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث بالمرجع..." class="form-control">
            </div>

            <div style="min-width: 160px;">
                <label style="display: block; font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px;">نوع الحدث (Event)</label>
                <select name="event" class="form-control">
                    <option value="">جميع الأحداث</option>
                    <option value="lightbox_payload_prepared" {{ request('event') === 'lightbox_payload_prepared' ? 'selected' : '' }}>تجهيز Lightbox</option>
                    <option value="callback_received" {{ request('event') === 'callback_received' ? 'selected' : '' }}>استلام Callback</option>
                    <option value="webhook_received" {{ request('event') === 'webhook_received' ? 'selected' : '' }}>إشعار Webhook</option>
                    <option value="signature_verified" {{ request('event') === 'signature_verified' ? 'selected' : '' }}>تحقق التوقيع بنجاح</option>
                    <option value="signature_mismatch" {{ request('event') === 'signature_mismatch' ? 'selected' : '' }}>فشل توقيع الـ Hash</option>
                    <option value="order_paid_and_fulfilled" {{ request('event') === 'order_paid_and_fulfilled' ? 'selected' : '' }}>اكتمال الدفع والتفعيل</option>
                </select>
            </div>

            <div style="min-width: 140px;">
                <label style="display: block; font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px;">الحالة</label>
                <select name="status" class="form-control">
                    <option value="">جميع الحالات</option>
                    <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>نجاح (Success)</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>فشل (Failed)</option>
                    <option value="info" {{ request('status') === 'info' ? 'selected' : '' }}>معلومات (Info)</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>معلق (Pending)</option>
                </select>
            </div>

            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn btn-primary" style="padding: 10px 18px;">فلترة</button>
                <a href="{{ route('admin.payment-logs.index') }}" class="btn btn-outline" style="padding: 10px 18px;">إعادة ضبط</a>
            </div>
        </form>
    </div>

    {{-- Logs Table --}}
    <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>التوقيت</th>
                        <th>الحدث (Event)</th>
                        <th>الحالة</th>
                        <th>مرجع العملية</th>
                        <th>الرسالة والبيان</th>
                        <th>عنوان IP</th>
                        <th style="text-align: left;">تفاصيل الـ Payload</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td style="white-space: nowrap;">
                                <div style="font-family: var(--font-code); font-size: 11.5px; font-weight: 700; color: var(--text-heading);">
                                    {{ $log->created_at->format('H:i:s') }}
                                </div>
                                <div style="font-size: 10px; color: var(--text-muted);">
                                    {{ $log->created_at->format('Y-m-d') }}
                                </div>
                            </td>
                            <td>
                                <code style="font-size: 11px; background: #f1f5f9; padding: 2px 6px; border-radius: 4px; color: #0369a1; font-weight: 700;">
                                    {{ $log->event }}
                                </code>
                            </td>
                            <td>
                                @if($log->status === 'success')
                                    <span style="background: #dcfce7; color: #15803d; padding: 3px 8px; border-radius: 99px; font-size: 11px; font-weight: 700;">ناجح</span>
                                @elseif($log->status === 'failed')
                                    <span style="background: #fee2e2; color: #b91c1c; padding: 3px 8px; border-radius: 99px; font-size: 11px; font-weight: 700;">فشل</span>
                                @elseif($log->status === 'pending')
                                    <span style="background: #fef3c7; color: #b45309; padding: 3px 8px; border-radius: 99px; font-size: 11px; font-weight: 700;">معلق</span>
                                @else
                                    <span style="background: #e0f2fe; color: #0369a1; padding: 3px 8px; border-radius: 99px; font-size: 11px; font-weight: 700;">معلومات</span>
                                @endif
                            </td>
                            <td>
                                @if($log->order)
                                    <a href="{{ route('admin.digital-orders.show', $log->order_id) }}" style="font-weight: 700; font-family: var(--font-code); font-size: 11.5px; color: #2563eb; text-decoration: underline;">
                                        {{ $log->merchant_reference }}
                                    </a>
                                @else
                                    <span style="font-family: var(--font-code); font-size: 11.5px; color: var(--text-body);">{{ $log->merchant_reference ?: 'N/A' }}</span>
                                @endif
                            </td>
                            <td>
                                <div style="font-size: 12px; color: var(--text-body); max-width: 300px; white-space: normal;">
                                    {{ $log->message }}
                                </div>
                            </td>
                            <td>
                                <code style="font-size: 11px; color: var(--text-muted);">{{ $log->ip_address ?: 'CLI / Server' }}</code>
                            </td>
                            <td style="text-align: left;">
                                <button type="button" onclick="showLogDetails({{ $log->id }})" class="btn btn-outline btn-sm">
                                    معاينة JSON
                                </button>
                                {{-- Hidden container holding log json --}}
                                <div id="log_data_{{ $log->id }}" style="display: none;" 
                                     data-event="{{ $log->event }}"
                                     data-reference="{{ $log->merchant_reference }}"
                                     data-time="{{ $log->created_at->format('Y-m-d H:i:s') }}"
                                     data-message="{{ $log->message }}"
                                     data-request="{{ json_encode($log->request_payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}"
                                     data-response="{{ json_encode($log->response_payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}">
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                لا توجد سجلات دفع مسجلة حتى الآن.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div style="padding: 16px 20px; border-top: 1px solid var(--border-subtle);">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

</div>

{{-- JSON Inspector Modal --}}
<div id="logModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #0f172a; color: #f8fafc; width: 100%; max-width: 750px; border-radius: 16px; border: 1px solid #334155; box-shadow: 0 25px 50px rgba(0,0,0,0.5); overflow: hidden; display: flex; flex-direction: column; max-height: 90vh;">
        
        <div style="padding: 18px 24px; border-bottom: 1px solid #1e293b; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <h3 style="font-size: 15px; font-weight: 800; color: #38bdf8;" id="modalEventName">تفاصيل العملية</h3>
                <span style="font-size: 11px; color: #94a3b8;" id="modalTimestamp"></span>
            </div>
            <button onclick="closeLogModal()" style="background: transparent; border: none; color: #94a3b8; font-size: 20px; cursor: pointer;">✕</button>
        </div>

        <div style="padding: 20px 24px; overflow-y: auto; flex: 1;">
            <div style="margin-bottom: 16px;">
                <div style="font-size: 11px; font-weight: 700; color: #94a3b8; margin-bottom: 4px;">البيان:</div>
                <div id="modalMessage" style="font-size: 13px; color: #e2e8f0; background: #1e293b; padding: 10px 14px; border-radius: 8px;"></div>
            </div>

            <div style="margin-bottom: 16px;">
                <div style="font-size: 11px; font-weight: 700; color: #38bdf8; margin-bottom: 6px;">بيانات الطلب المرسل (Request Payload):</div>
                <pre id="modalRequestPayload" style="background: #020617; border: 1px solid #1e293b; color: #a5f3fc; padding: 14px; border-radius: 8px; font-size: 11.5px; overflow-x: auto; direction: ltr; text-align: left;"></pre>
            </div>

            <div>
                <div style="font-size: 11px; font-weight: 700; color: #34d399; margin-bottom: 6px;">بيانات الاستجابة / التوقيع (Response / Hash):</div>
                <pre id="modalResponsePayload" style="background: #020617; border: 1px solid #1e293b; color: #6ee7b7; padding: 14px; border-radius: 8px; font-size: 11.5px; overflow-x: auto; direction: ltr; text-align: left;"></pre>
            </div>
        </div>

        <div style="padding: 14px 24px; border-top: 1px solid #1e293b; text-align: left;">
            <button type="button" onclick="closeLogModal()" class="btn btn-outline btn-sm" style="background: #1e293b; color: #f8fafc; border-color: #475569;">
                إغلاق
            </button>
        </div>

    </div>
</div>

<script>
function showLogDetails(id) {
    const el = document.getElementById('log_data_' + id);
    if (!el) return;

    document.getElementById('modalEventName').innerText = el.dataset.event + ' (' + (el.dataset.reference || 'N/A') + ')';
    document.getElementById('modalTimestamp').innerText = el.dataset.time;
    document.getElementById('modalMessage').innerText = el.dataset.message || 'لا يوجد بيان إضافي';
    document.getElementById('modalRequestPayload').innerText = el.dataset.request || 'None';
    document.getElementById('modalResponsePayload').innerText = el.dataset.response || 'None';

    const modal = document.getElementById('logModal');
    modal.style.display = 'flex';
}

function closeLogModal() {
    document.getElementById('logModal').style.display = 'none';
}
</script>
@endsection
