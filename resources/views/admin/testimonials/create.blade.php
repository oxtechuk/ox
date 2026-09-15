@extends('layouts.admin')

@section('title', 'إضافة فيديو ريفيو | OX Tech')
@section('header_title', 'إضافة فيديو ريفيو جديد')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">بيانات الشريك وفيديو التقييم</div>
        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline btn-sm">رجوع للفيديوهات</a>
    </div>

    <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-grid">
            <div>
                <label class="form-label">اسم الشريك / العميل *</label>
                <input type="text" name="partner_name" class="form-control" value="{{ old('partner_name') }}" placeholder="مثال: سارة العتيبي" required>
            </div>

            <div>
                <label class="form-label">المنصب والشركة *</label>
                <input type="text" name="partner_role" class="form-control" value="{{ old('partner_role') }}" placeholder="مثال: CEO، مِرسال" required>
            </div>

            <div>
                <label class="form-label">الدولة أو السوق</label>
                <input type="text" name="partner_country" class="form-control" value="{{ old('partner_country', 'السعودية') }}" placeholder="مثال: السعودية">
            </div>

            <div>
                <label class="form-label">رقم الشارة في السلايدر</label>
                <input type="text" name="number_badge" class="form-control" value="{{ old('number_badge', '01') }}" placeholder="01, 02, 03">
            </div>

            <div>
                <label class="form-label">نوع الفيديو</label>
                <select name="video_type" class="form-control" id="video_type" onchange="toggleVideoInputs(this.value)">
                    <option value="url">رابط خارجي مباشر (MP4/WebM)</option>
                    <option value="file">رفع ملف فيديو من الجهاز</option>
                    <option value="youtube">رابط يوتيوب أو فيميو</option>
                </select>
            </div>

            <div id="video_url_box">
                <label class="form-label">رابط الفيديو (Video URL)</label>
                <input type="text" name="video_url" class="form-control" value="{{ old('video_url') }}" placeholder="https://example.com/video.mp4">
            </div>

            <div id="video_file_box" style="display: none;">
                <label class="form-label">ملف الفيديو من الجهاز (MP4/WebM/MOV)</label>
                <input type="file" name="video_file" class="form-control" accept="video/*">
            </div>

            <div>
                <label class="form-label">صورة الغلاف للكارت (Poster Image)</label>
                <input type="file" name="poster_image" class="form-control" accept="image/*">
            </div>

            <div>
                <label class="form-label">ترتيب الظهور</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', 1) }}">
            </div>
        </div>

        <div style="margin-top: 20px;">
            <div style="margin-bottom: 20px;">
                <label class="form-label">نص الاقتباس / الرأي (Quote) *</label>
                <textarea name="quote" rows="4" class="form-control" placeholder="اكتب نص تقييم الشريك ورأيه في العمل مع OX Tech..." required>{{ old('quote') }}</textarea>
            </div>

            <div style="margin: 20px 0;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                    <span style="font-size: 12.5px; font-weight: 600; color: var(--text-heading);">تفعيل وظهور في السلايدر التفاعلي بالصفحة الرئيسية</span>
                </label>
            </div>

            <button type="submit" class="btn btn-lime" style="padding: 10px 28px;">
                <span>حفظ ونشر الريفيو</span>
            </button>
        </div>
    </form>
</div>
@endsection

@push('admin-scripts')
<script>
    function toggleVideoInputs(val) {
        document.getElementById('video_url_box').style.display = (val === 'file') ? 'none' : 'block';
        document.getElementById('video_file_box').style.display = (val === 'file') ? 'block' : 'none';
    }
</script>
@endpush
