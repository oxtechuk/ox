@extends('layouts.admin')

@section('title', 'إدارة البرمجيات والمنتجات الرقمية')

@section('content')
<div class="admin-content-inner">
    
    <div class="topbar-actions" style="margin-bottom: 24px; justify-content: space-between;">
        <div>
            <h1 class="topbar-title">💻 البرمجيات والمنتجات الرقمية</h1>
            <p style="font-size: 12.5px; color: var(--text-muted); margin-top: 4px;">
                إدارة ملفات البرامج، التراخيص، الأسعار، وصفحات الهبوط الإعلانية
            </p>
        </div>

        <a href="{{ route('admin.digital-products.create') }}" class="btn btn-primary">
            + إضافة برنامج رقمي جديد
        </a>
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px 18px; border-radius: 8px; font-size: 13px; font-weight: 600; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filters Card --}}
    <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 12px; padding: 18px 20px; margin-bottom: 24px;">
        <form action="{{ route('admin.digital-products.index') }}" method="GET" style="display: flex; gap: 14px; flex-wrap: wrap; align-items: flex-end;">
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px;">بحث بالاسم أو الوصف</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث باسم البرنامج..." class="form-control">
            </div>

            <div style="min-width: 180px;">
                <label style="display: block; font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px;">التخصص والتصنيف</label>
                <select name="category" class="form-control">
                    <option value="">جميع التخصصات</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div style="min-width: 140px;">
                <label style="display: block; font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px;">الحالة</label>
                <select name="status" class="form-control">
                    <option value="">الكل</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>نشط (Active)</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>مسودة (Draft)</option>
                </select>
            </div>

            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn btn-primary" style="padding: 10px 18px;">فلترة</button>
                <a href="{{ route('admin.digital-products.index') }}" class="btn btn-outline" style="padding: 10px 18px;">إعادة ضبط</a>
            </div>
        </form>
    </div>

    {{-- Products Table --}}
    <div style="background: var(--bg-card); border: 1px solid var(--border-card); border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>البرنامج</th>
                        <th>التخصص</th>
                        <th>الإصدار</th>
                        <th>السعر</th>
                        <th>المبيعات</th>
                        <th>الحالة</th>
                        <th>روابط سريعة</th>
                        <th style="text-align: left;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <strong style="color: var(--text-heading); font-size: 13px;">{{ $product->name }}</strong>
                                <div style="font-size: 11px; color: var(--text-muted); max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ $product->tagline }}
                                </div>
                            </td>
                            <td>
                                <span style="background: #eff6ff; color: #1d4ed8; padding: 3px 8px; border-radius: 6px; font-size: 11px; font-weight: 600;">
                                    {{ $product->category->name ?? 'عام' }}
                                </span>
                            </td>
                            <td><code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 11px;">v{{ $product->version }}</code></td>
                            <td>
                                <div style="font-weight: 800; color: var(--brand-forest); font-size: 13px;">
                                    {{ number_format($product->effective_price, 2) }} {{ $product->currency }}
                                </div>
                                @if($product->has_discount)
                                    <small style="color: #ef4444; text-decoration: line-through;">{{ number_format($product->price, 2) }}</small>
                                @endif
                            </td>
                            <td>
                                <span style="font-weight: 700; color: var(--text-heading);">{{ $product->order_items_count }}</span> طلب
                            </td>
                            <td>
                                @if($product->status === 'active')
                                    <span style="background: #dcfce7; color: #15803d; padding: 3px 8px; border-radius: 99px; font-size: 11px; font-weight: 700;">نشط</span>
                                @else
                                    <span style="background: #f1f5f9; color: #64748b; padding: 3px 8px; border-radius: 99px; font-size: 11px; font-weight: 700;">مسودة</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                    <a href="{{ route('store.product', $product->slug) }}" target="_blank" style="font-size: 11px; color: #2563eb; text-decoration: underline; display: inline-flex; align-items: center; gap: 4px;">
                                         صفحة المتجر ↗
                                    </a>
                                    @if($product->landingPage && $product->landingPage->is_published)
                                        <a href="{{ route('store.landing', $product->landingPage->slug) }}" target="_blank" style="font-size: 10.5px; background: #f5f3ff; color: #6d28d9; padding: 2px 7px; border-radius: 6px; font-weight: 700; text-decoration: none; border: 1px solid #ddd6fe; display: inline-flex; align-items: center; gap: 4px; width: fit-content;">
                                             صفحة سيلز نشطة ↗
                                        </a>
                                    @else
                                        <span style="font-size: 10px; color: var(--text-muted);">
                                            بدون صفحة سيلز
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td style="text-align: left;">
                                <div style="display: inline-flex; gap: 6px;">
                                    <a href="{{ route('admin.digital-products.edit', $product->id) }}" class="btn btn-outline btn-sm">
                                        تعديل
                                    </a>
                                    <form action="{{ route('admin.digital-products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف هذا البرنامج؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            حذف
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                لا توجد منتجات رقمية مسجلة حتى الآن.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div style="padding: 16px 20px; border-top: 1px solid var(--border-subtle);">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
