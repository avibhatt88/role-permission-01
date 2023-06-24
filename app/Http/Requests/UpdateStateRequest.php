<?php

namespace App\Http\Requests;

use App\Models\State;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateStateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('state_edit');
    }

    public function rules()
    {
        return [
            'state' => [
                'string',
                'min:3',
                'max:50',
                'required',
                'unique:states,state,' . request()->route('state')->id,
            ],
        ];
    }
}
