<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && method_exists($this->user(), 'isAdmin') && $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'site_logo_main' => 'nullable|image|mimes:jpeg,png,webp,svg,gif|max:5120',
            'site_logo_dark' => 'nullable|image|mimes:jpeg,png,webp,svg,gif|max:5120',
            'site_logo_footer' => 'nullable|image|mimes:jpeg,png,webp,svg,gif|max:5120',
            'site_favicon' => 'nullable|mimes:ico,png,svg,webp|max:2048',
            'seo_og_image' => 'nullable|image|mimes:jpeg,png,webp,gif|max:5120',
            'active_tab' => 'nullable|string|max:50',
        ];
    }
}
