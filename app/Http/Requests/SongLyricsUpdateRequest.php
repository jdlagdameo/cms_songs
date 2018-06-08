<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SongLyricsUpdateRequest extends ParentRequest
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
            //
            'title' => 'required|string|max:50',
            'artist' => 'required|string|max:50',
            'lyrics' => 'required|string'
        ];
    }

    public function validationData()
    {
        $this['id'] = $this->id;
        return $this->all();
    }
}
