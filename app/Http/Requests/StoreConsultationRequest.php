<?php

namespace App\Http\Requests;

use App\Models\SiteSetting;
use App\Rules\RecaptchaRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreConsultationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare data before validation (honeypot trap handling).
     */
    protected function prepareForValidation(): void
    {
        if ($this->filled('hp_check') || $this->filled('website_hp')) {
            if (! $this->has('phone') || empty($this->input('phone'))) {
                $this->merge(['phone' => '+966500000000']);
            }
            if (! $this->has('g-recaptcha-response') || empty($this->input('g-recaptcha-response'))) {
                $this->merge(['g-recaptcha-response' => 'honeypot-trap']);
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $secretKey = config('services.recaptcha.secret_key');
        if (empty($secretKey) && class_exists(SiteSetting::class)) {
            $secretKey = SiteSetting::get('recaptcha_secret_key', '');
        }

        $isHoneypotTriggered = $this->filled('hp_check') || $this->filled('website_hp');

        $recaptchaRule = (! empty($secretKey) && ! $isHoneypotTriggered)
            ? ['required', 'string', new RecaptchaRule]
            : ['nullable'];

        return [
            'name' => 'required|string|min:2|max:70',
            'email' => 'required|email|max:100',
            'phone' => ['required', 'string', 'min:6', 'max:30', 'regex:/^[\+0-9\s\-\(\)]+$/'],
            'company_name' => 'nullable|string|max:100',
            'project_type' => 'nullable|string|max:100',
            'budget' => 'nullable|string|max:100',
            'contact_preference' => 'nullable|string|max:50',
            'message' => 'required|string|min:10|max:1000',
            'g-recaptcha-response' => $recaptchaRule,
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => __('يرجى إدخال الاسم الكريم.'),
            'name.min' => __('الاسم يجب أن يتكون من حرفين على الأقل.'),
            'name.max' => __('الاسم يجب ألا يتجاوز 70 حرفاً.'),
            'email.required' => __('البريد الإلكتروني مطلوب.'),
            'email.email' => __('يرجى إدخال بريد إلكتروني صحيح.'),
            'email.max' => __('البريد الإلكتروني يجب ألا يتجاوز 100 حرف.'),
            'phone.required' => __('رقم الجوال أو الواتساب مطلوب للتواصل معك.'),
            'phone.min' => __('يرجى إدخال رقم هاتف صحيح.'),
            'phone.max' => __('رقم الجوال يجب ألا يتجاوز 30 حرفاً.'),
            'phone.regex' => __('صيغة رقم الجوال غير صحيحة، يرجى كتابة أرقام صحيحة.'),
            'company_name.max' => __('اسم الشركة يجب ألا يتجاوز 100 حرف.'),
            'message.required' => __('يرجى كتابة تفاصيل مشروعك أو فكرتك.'),
            'message.min' => __('يرجى كتابة 10 أحرف على الأقل لشرح الفكرة بشكل أوضح.'),
            'message.max' => __('تفاصيل الرسالة يجب ألا تتجاوز 1000 حرف.'),
            'g-recaptcha-response.required' => __('يرجى إتمام التحقق الأمني ضد البوتات (reCAPTCHA).'),
        ];
    }
}
