<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        $query = Consultation::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $consultations = $query->orderBy('created_at', 'desc')->paginate(15);
        $statusCounts = [
            'all' => Consultation::count(),
            'new' => Consultation::where('status', 'new')->count(),
            'contacted' => Consultation::where('status', 'contacted')->count(),
            'scheduled' => Consultation::where('status', 'scheduled')->count(),
            'completed' => Consultation::where('status', 'completed')->count(),
            'archived' => Consultation::where('status', 'archived')->count(),
        ];

        return view('admin.consultations.index', compact('consultations', 'statusCounts'));
    }

    public function show(Consultation $consultation)
    {
        return view('admin.consultations.show', compact('consultation'));
    }

    public function updateStatus(Request $request, Consultation $consultation)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,contacted,scheduled,completed,archived',
            'admin_notes' => 'nullable|string',
        ]);

        $consultation->update($validated);

        return back()->with('success', 'تم تحديث حالة طلب الاستشارة والملاحظات بنجاح.');
    }

    public function destroy(Consultation $consultation)
    {
        $consultation->delete();

        return redirect()->route('admin.consultations.index')->with('success', 'تم حذف الطلب بنجاح.');
    }
}
