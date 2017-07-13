<?php

namespace App\Http\Requests;

use App\Models\Feedback;
use Illuminate\Validation\Rule;

class FeedbackCreateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'feedback_type' => ['required', 'integer', Rule::in([Feedback::FEEDBACK_TYPE_BUG, Feedback::FEEDBACK_TYPE_IMPROV, Feedback::FEEDBACK_TYPE_OTHER])],
            'contact' => 'nullable|string|max:300',
            'content' => 'required|string|max:10000'
        ];
    }

    public function messages()
    {
        return [
            'feedback_type.required' => '请选择反馈类型',
            'feedback_type.integer' => '请选择正确的反馈类型',
            'feedback_type.in' => '请选择正确的反馈类型',
            'contact.string' => '请输入正确的联系方式',
            'contact.max' => '联系方式请控制在300字以内！',
            'content.required' => '请输入详细描述！',
            'content.string' => '请输入正确的详细描述！',
            'content.max' => '详细描述请控制在10000字以内！',
        ];
    }
}
