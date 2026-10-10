<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\LicenseDevice;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LicenseController extends Controller
{
    /**
     * Display a listing of the software licenses.
     */
    public function index(Request $request): View
    {
        $query = License::with(['user', 'devices'])->withCount('devices');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = trim((string) $request->search);
            $query->where(function ($q) use ($search) {
                $q->where('license_key', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('devices', function ($dq) use ($search) {
                        $dq->where('hardware_id', 'like', "%{$search}%");
                    });
            });
        }

        $licenses = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'total' => License::count(),
            'active' => License::where('status', 'active')->count(),
            'revoked' => License::where('status', 'revoked')->count(),
            'expired' => License::where('status', 'expired')->count(),
            'devices_count' => LicenseDevice::count(),
        ];

        return view('admin.licenses.index', compact('licenses', 'stats'));
    }

    /**
     * Show the form for creating a new license.
     */
    public function create(): View
    {
        // Suggest a new random formatted license key
        $suggestedKey = 'OX-'.strtoupper(Str::random(4)).'-'.strtoupper(Str::random(4)).'-'.strtoupper(Str::random(4));
        $users = User::orderBy('name')->get(['id', 'name', 'email']);

        return view('admin.licenses.create', compact('suggestedKey', 'users'));
    }

    /**
     * Store a newly created license in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'license_key' => ['required', 'string', 'max:191', 'unique:licenses,license_key'],
            'max_devices' => ['required', 'integer', 'min:1', 'max:100'],
            'status' => ['required', 'in:active,revoked,expired'],
            'expires_at' => ['nullable', 'date'],
            'user_id' => ['nullable', 'exists:users,id'],
        ], [
            'license_key.required' => 'يرجى إدخال مفتاح الترخيص أو توليد مفتاح تلقائي.',
            'license_key.unique' => 'مفتاح الترخيص هذا مستخدم بالفعل.',
            'max_devices.min' => 'أقل عدد مسموح للأجهزة هو 1.',
        ]);

        $license = License::create($validated);

        return redirect()
            ->route('admin.licenses.index')
            ->with('success', "تم إنشاء مفتاح الترخيص ({$license->license_key}) بنجاح وهو جاهز للتفعيل الآن.");
    }

    /**
     * Display the specified license and its activated devices.
     */
    public function show(License $license): View
    {
        $license->load(['user', 'devices' => fn ($q) => $q->latest()]);

        return view('admin.licenses.show', compact('license'));
    }

    /**
     * Show the form for editing the specified license.
     */
    public function edit(License $license): View
    {
        $users = User::orderBy('name')->get(['id', 'name', 'email']);

        return view('admin.licenses.edit', compact('license', 'users'));
    }

    /**
     * Update the specified license in storage.
     */
    public function update(Request $request, License $license): RedirectResponse
    {
        $validated = $request->validate([
            'license_key' => ['required', 'string', 'max:191', 'unique:licenses,license_key,'.$license->id],
            'max_devices' => ['required', 'integer', 'min:1', 'max:100'],
            'status' => ['required', 'in:active,revoked,expired'],
            'expires_at' => ['nullable', 'date'],
            'user_id' => ['nullable', 'exists:users,id'],
        ], [
            'license_key.required' => 'يرجى إدخال مفتاح الترخيص.',
            'license_key.unique' => 'مفتاح الترخيص هذا مستخدم بالفعل لرخصة أخرى.',
            'max_devices.min' => 'أقل عدد مسموح للأجهزة هو 1.',
        ]);

        $license->update($validated);

        return redirect()
            ->route('admin.licenses.index')
            ->with('success', "تم تحديث بيانات الترخيص ({$license->license_key}) بنجاح.");
    }

    /**
     * Remove the specified license from storage.
     */
    public function destroy(License $license): RedirectResponse
    {
        $key = $license->license_key;
        $license->delete();

        return redirect()
            ->route('admin.licenses.index')
            ->with('success', "تم حذف الترخيص ({$key}) وكافة أجهزته المرتبطة بنجاح.");
    }

    /**
     * Quick toggle license status (Active <-> Revoked).
     */
    public function toggleStatus(License $license): RedirectResponse
    {
        $newStatus = $license->status === 'active' ? 'revoked' : 'active';
        $license->update(['status' => $newStatus]);

        $label = $newStatus === 'active' ? 'تفعيل' : 'إلغاء تفعيل / حظر';

        return back()->with('success', "تم {$label} الترخيص ({$license->license_key}) بنجاح.");
    }

    /**
     * Disconnect/Remove a registered hardware device so user can activate a new device.
     */
    public function removeDevice(License $license, LicenseDevice $device): RedirectResponse
    {
        if ($device->license_id !== $license->id) {
            abort(404);
        }

        $device->delete();

        return back()->with('success', "تم فك ارتباط الجهاز ({$device->hardware_id}) بنجاح. يمكن للعميل الآن استخدام المفتاح على جهاز جديد.");
    }
}
