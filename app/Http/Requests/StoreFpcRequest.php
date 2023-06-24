<?php

namespace App\Http\Requests;

use App\Models\Fpc;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFpcRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('fpc_create');
    }

    public function rules()
    {
        return [
            'state_id' => [
                'required',
                'integer',
            ],
            'district_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
