<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Contexts\Block as BlockContext;
use Illuminate\Http\Request;

class BlockRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'blocked_user_id' => ['required', 'exists:users,id', function (string $attribute, mixed $value, $fail) use ($request) {
                if (BlockContext::isUserBlocked($request->user()->id, $value)) {
                    $fail("The User ID {$value} given is invalid or is already blocked");
                }
            }]
        ];
    }

    protected function prepareForValidation() 
    {
        $this->merge(['blocked_user_id' => $this->route('blocked_user_id')]);
    }

    public function messages()
    {
        return [
            'blocked_user_id.unique' => 'This user is already blocked',
        ];
    }
}
