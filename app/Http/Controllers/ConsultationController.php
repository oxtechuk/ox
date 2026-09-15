<?php

namespace App\Http\Controllers;

use App\Mail\ConsultationAdminNotificationMail;
use App\Mail\ConsultationConfirmationMail;
use App\Models\Consultation;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ConsultationController extends Controller
{
    public function store(Request $request)
    {
        // 1. Anti-Spam Bot Honeypot Trap
        // If a hidden bot field is filled, silently discard or fake success to fool automated scrapers
        if ($request->filled('hp_check') || $request->filled('website_hp')) {
            Log::info('Anti-Spam Honeypot triggered by IP: ' . $request->ip());
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'تم استلام طلب استشارتك بنجاح! سيتواصل معك فريقنا خلال 24 ساعة.',
                ]);
            }
            return back()->with('success', 'تم إرسال طلبك بنجاح! سنتواصل معك في أقرب وقت.');
        }

        // 2. Anti-Spam Time-Trap (if timestamp is provided and submitted faster than 2 seconds)
        if ($request->filled('_form_load_time')) {
            $loadTime = (int) $request->input('_form_load_time');
            $currentTime = time();
            if ($loadTime > 0 && ($currentTime - $loadTime) < 2) {
                Log::info('Anti-Spam Time-Trap triggered (instant submit) by IP: ' . $request->ip());
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'تم استلام طلب استشارتك بنجاح! سيتواصل معك فريقنا خلال 24 ساعة.',
                    ]);
                }
                return back()->with('success', 'تم إرسال طلبك بنجاح!');
            }
        }

        // 3. Strict Validation & Character Limits
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:70',
            'email' => 'required|email:rfc,dns|max:100',
            'phone' => 'nullable|string|max:30',
            'company_name' => 'nullable|string|max:100',
            'project_type' => 'nullable|string|max:100',
            'budget' => 'nullable|string|max:100',
            'message' => 'required|string|min:10|max:1000',
        ], [
            'name.required' => 'يرجى إدخال الاسم الكريم.',
            'name.min' => 'الاسم يجب أن يتكون من حرفين على الأقل.',
            'name.max' => 'الاسم يجب ألا يتجاوز 70 حرفاً.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
            'email.max' => 'البريد الإلكتروني يجب ألا يتجاوز 100 حرف.',
            'phone.max' => 'رقم الجوال يجب ألا يتجاوز 30 حرفاً.',
            'company_name.max' => 'اسم الشركة يجب ألا يتجاوز 100 حرف.',
            'message.required' => 'يرجى كتابة تفاصيل مشروعك أو فكرتك.',
            'message.min' => 'يرجى كتابة 10 أحرف على الأقل لشرح الفكرة بشكل أوضح.',
            'message.max' => 'تفاصيل الرسالة يجب ألا تتجاوز 1000 حرف.',
        ]);

        // Merge attribution data
        $validated['utm_source'] = $request->input('utm_source', session('attribution.utm_source'));
        $validated['utm_medium'] = $request->input('utm_medium', session('attribution.utm_medium'));
        $validated['utm_campaign'] = $request->input('utm_campaign', session('attribution.utm_campaign'));
        $validated['utm_term'] = $request->input('utm_term', session('attribution.utm_term'));
        $validated['utm_content'] = $request->input('utm_content', session('attribution.utm_content'));
        $validated['referrer_url'] = $request->input('referrer_url', session('attribution.referrer_url', $request->header('referer')));
        $validated['platform_detected'] = $request->input('platform_detected', session('attribution.platform_detected', 'Direct'));
        $validated['ip_address'] = $request->ip();
        $validated['user_agent'] = $request->userAgent();

        $consultation = Consultation::create($validated);

        // Send Email Confirmation & Admin Alert safely
        try {
            if ($consultation->email) {
                Mail::to($consultation->email)->send(new ConsultationConfirmationMail($consultation));
            }

            $adminEmail = SiteSetting::get('contact_email_primary', 'info@ox-tech.sa');
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new ConsultationAdminNotificationMail($consultation));
            }
        } catch (\Throwable $e) {
            Log::warning('Could not dispatch consultation email: ' . $e->getMessage());
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم استلام طلب استشارتك بنجاح! سيتواصل معك فريقنا خلال 24 ساعة.',
                'consultation_id' => $consultation->id,
                'platform' => $consultation->platform_detected,
            ]);
        }

        return back()->with('success', 'تم إرسال طلبك بنجاح! سنتواصل معك في أقرب وقت لتحديد موعد الاستشارة.');
    }
}
