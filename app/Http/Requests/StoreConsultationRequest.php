<?php

namespace App\Http\Requests;

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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:70',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|string|max:30',
            'company_name' => 'nullable|string|max:100',
            'project_type' => 'nullable|string|max:100',
            'budget' => 'nullable|string|max:100',
            'message' => 'required|string|min:10|max:1000',
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
            'phone.max' => __('رقم الجوال يجب ألا يتجاوز 30 حرفاً.'),
            'company_name.max' => __('اسم الشركة يجب ألا يتجاوز 100 حرف.'),
            'message.required' => __('يرجى كتابة تفاصيل مشروعك أو فكرتك.'),
            'message.min' => __('يرجى كتابة 10 أحرف على الأقل لشرح الفكرة بشكل أوضح.'),
            'message.max' => __('تفاصيل الرسالة يجب ألا تتجاوز 1000 حرف.'),
        ];
    }
}
