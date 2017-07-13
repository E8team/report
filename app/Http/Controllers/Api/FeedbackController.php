<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\FeedbackCreateRequest;
use App\Models\Feedback;
use Auth;

class FeedbackController extends ApiController
{
    public function feedbackTypes()
    {
        return [
            [
                'key' => Feedback::FEEDBACK_TYPE_BUG,
                'value' => 'BUG反馈'
            ],
            [
                'key' => Feedback::FEEDBACK_TYPE_IMPROV,
                'value' => '改进建议',
            ],
            [
                'key' => Feedback::FEEDBACK_TYPE_OTHER,
                'value' => '其他',
            ],
        ];

    }
    public function store(FeedbackCreateRequest $request)
    {
        // todo 每天提交超过n次 需要验证码
        $data = $request->all();
        if(isset($data['contact']))
            $data['contact'] = e($data['contact']);
        $data['content'] = e($data['content']);
        $data['student_id'] = Auth::guard('web')->id();
        $data['user_id'] = Auth::guard('web_admin')->id();
        Feedback::create($data);
        return $this->response->noContent();
    }
}