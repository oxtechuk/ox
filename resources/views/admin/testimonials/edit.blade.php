@extends('layouts.admin')

@section('title', 'تعديل فيديو ريفيو | OX Tech')
@section('header_title', 'تعديل ريفيو: ' . $testimonial->partner_name)

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">تعديل بيانات ريفيو {{ $testimonial->partner_name }}</div>
        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline btn-sm">رجوع للفيديوهات</a>
    </div>

    <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-grid">
            <div>
                <label class="form-label">اسم الشريك / العميل *</label>
                <input type="text" name="partner_name" class="form-control" value="{{ old('partner_name', $testimonial->partner_name) }}" required>
            </div>

            <div>
                <label class="form-label">المنصب والشركة *</label>
                <input type="text" name="partner_role" class="form-control" value="{{ old('partner_role', $testimonial->partner_role) }}" required>
            </div>

            <div>
                <label class="form-label">الدولة أو السوق</label>
                <input type="text" name="partner_country" class="form-control" value="{{ old('partner_country', $testimonial->partner_country) }}">
            </div>

            <div>
                <label class="form-label">رقم الشارة في السلايدر</label>
                <input type="text" name="number_badge" class="form-control" value="{{ old('number_badge', $testimonial->number_badge) }}">
            </div>

            <div>
                <label class="form-label">نوع الفيديو</label>
                <select name="video_type" class="form-control" id="video_type" onchange="toggleVideoInputs(this.value)">
                    <option value="url" {{ old('video_type', $testimonial->video_type) == 'url' ? 'selected' : '' }}>رابط خارجي مباشر (MP4/WebM)</option>
                    <option value="file" {{ old('video_type', $testimonial->video_type) == 'file' ? 'selected' : '' }}>رفع ملف فيديو من الجهاز</option>
                    <option value="youtube" {{ old('video_type', $testimonial->video_type) == 'youtube' ? 'selected' : '' }}>رابط يوتيوب أو فيميو</option>
                </select>
            </div>

            <div id="video_url_box" style="{{ $testimonial->video_type == 'file' ? 'display: none;' : '' }}">
                <label class="form-label">رابط الفيديو (Video URL)</label>
                <input type="text" name="video_url" class="form-control" value="{{ old('video_url', $testimonial->video_url) }}">
            </div>

            <div id="video_file_box" style="{{ $testimonial->video_type == 'file' ? '' : 'display: none;' }}">
                <label class="form-label">تغيير ملف الفيديو (MP4/WebM/MOV)</label>
                <input type="file" name="video_file" class="form-control" accept="video/*">
                @if($testimonial->video_url && $testimonial->video_type == 'file')
                    <div style="font-size: 11px; color: var(--brand-green); margin-top: 5px;">ملف الفيديو الحالي محفوظ.</div>
                @endif
            </div>

            <div>
                <label class="form-label">صورة الغلاف (تغيير الصورة)</label>
                <input type="file" name="poster_image" class="form-control" accept="image/*">
            </div>

            <div>
                <label class="form-label">ترتيب الظهور</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', $testimonial->order) }}">
            </div>
        </div>

        <div style="margin-top: 20px;">
            <div style="margin-bottom: 20px;">
                <label class="form-label">نص الاقتباس / الرأي (Quote) *</label>
                <textarea name="quote" rows="4" class="form-control" required>{{ old('quote', $testimonial->quote) }}</textarea>
            </div>

            <div style="margin: 20px 0;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}>
                    <span style="font-size: 12.5px; font-weight: 600; color: var(--text-heading);">تفعيل وظهور في السلايدر التفاعلي بالصفحة الرئيسية</span>
                </label>
            </div>

            <button type="submit" class="btn btn-lime" style="padding: 10px 28px;">
                <span>تحديث وحفظ الريفيو</span>
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
