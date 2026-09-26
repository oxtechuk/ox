<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteContent;
use Illuminate\Http\Request;

class SiteContentController extends Controller
{
    public function index()
    {
        $contents = SiteContent::all()->groupBy('group');

        return view('admin.site-content.index', compact('contents'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            SiteContent::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => 'general']
            );
        }

        return back()->with('success', 'تم حفظ وتحديث محتوى وعناصر الموقع بنجاح!');
    }
}
