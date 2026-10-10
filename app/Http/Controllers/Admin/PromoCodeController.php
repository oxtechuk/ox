<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DigitalProduct;
use App\Models\PromoCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PromoCodeController extends Controller
{
    /**
     * Display a listing of promo codes.
     */
    public function index(Request $request): View
    {
        $query = PromoCode::with('product');

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true)
                    ->where(function ($q) {
                        $q->whereNull('valid_until')->orWhere('valid_until', '>=', now());
                    });
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            } elseif ($request->status === 'expired') {
                $query->whereNotNull('valid_until')->where('valid_until', '<', now());
            }
        }

        if ($request->filled('search')) {
            $search = trim((string) $request->search);
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $promoCodes = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'total' => PromoCode::count(),
            'active' => PromoCode::where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('valid_until')->orWhere('valid_until', '>=', now());
                })->count(),
            'expired' => PromoCode::whereNotNull('valid_until')->where('valid_until', '<', now())->count(),
            'total_uses' => PromoCode::sum('used_count'),
        ];

        return view('admin.promo-codes.index', compact('promoCodes', 'stats'));
    }

    /**
     * Show the form for creating a new promo code.
     */
    public function create(): View
    {
        $products = DigitalProduct::where('is_active', true)->orderBy('name')->get();
        $suggestedCode = 'OX'.strtoupper(Str::random(4));

        return view('admin.promo-codes.create', compact('products', 'suggestedCode'));
    }

    /**
     * Store a newly created promo code in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'code' => strtoupper(trim((string) $request->code)),
            'is_active' => $request->has('is_active'),
        ]);

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:promo_codes,code'],
            'discount_type' => ['required', 'in:percentage,fixed'],
            'discount_value' => [
                'required',
                'numeric',
                'min:0.01',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->discount_type === 'percentage' && $value > 100) {
                        $fail('نسبة الخصم المئوية لا يمكن أن تتجاوز 100%.');
                    }
                },
            ],
            'valid_from' => ['nullable', 'date'],
            'valid_until' => ['nullable', 'date', 'after_or_equal:valid_from'],
            'max_uses' => ['nullable', 'integer', 'min:1'],
            'description' => ['nullable', 'string', 'max:255'],
            'product_id' => ['nullable', 'exists:digital_products,id'],
            'is_active' => ['boolean'],
        ]);

        PromoCode::create($validated);

        return redirect()->route('admin.promo-codes.index')
            ->with('success', 'تم إنشاء كود الخصم '.$validated['code'].' بنجاح.');
    }

    /**
     * Show the form for editing the specified promo code.
     */
    public function edit(PromoCode $promoCode): View
    {
        $products = DigitalProduct::where('is_active', true)->orderBy('name')->get();

        return view('admin.promo-codes.edit', compact('promoCode', 'products'));
    }

    /**
     * Update the specified promo code in storage.
     */
    public function update(Request $request, PromoCode $promoCode): RedirectResponse
    {
        $request->merge([
            'code' => strtoupper(trim((string) $request->code)),
            'is_active' => $request->has('is_active'),
        ]);

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:promo_codes,code,'.$promoCode->id],
            'discount_type' => ['required', 'in:percentage,fixed'],
            'discount_value' => [
                'required',
                'numeric',
                'min:0.01',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->discount_type === 'percentage' && $value > 100) {
                        $fail('نسبة الخصم المئوية لا يمكن أن تتجاوز 100%.');
                    }
                },
            ],
            'valid_from' => ['nullable', 'date'],
            'valid_until' => ['nullable', 'date', 'after_or_equal:valid_from'],
            'max_uses' => ['nullable', 'integer', 'min:1'],
            'description' => ['nullable', 'string', 'max:255'],
            'product_id' => ['nullable', 'exists:digital_products,id'],
            'is_active' => ['boolean'],
        ]);

        $promoCode->update($validated);

        return redirect()->route('admin.promo-codes.index')
            ->with('success', 'تم تحديث بيانات كود الخصم بنجاح.');
    }

    /**
     * Remove the specified promo code from storage.
     */
    public function destroy(PromoCode $promoCode): RedirectResponse
    {
        $code = $promoCode->code;
        $promoCode->delete();

        return redirect()->route('admin.promo-codes.index')
            ->with('success', "تم حذف كود الخصم {$code} بنجاح.");
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(PromoCode $promoCode): RedirectResponse
    {
        $promoCode->update(['is_active' => ! $promoCode->is_active]);

        $statusText = $promoCode->is_active ? 'تفعيل' : 'تعطيل';

        return redirect()->back()
            ->with('success', "تم {$statusText} كود الخصم {$promoCode->code} بنجاح.");
    }
}
