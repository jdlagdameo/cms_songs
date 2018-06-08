<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Hashids;

/**
 * Class IdRequest
 *
 * Validates incoming id request
 *
 * @package App\Http\Requests\Content
 *
 * @author: Paulo Lorenzo Basilio
 *
 */
class ParentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->is('api/*')) {
            return true;
        } else {
            return auth()->check();
        }
    }

    /**
     * Check if hash field is correct
     * @param $args - the field to be check for hash
     * @return bool
     */
    public function checkHashField($args)
    {
        $hash = Hashids::decode($args);
        if (count($hash) == 0) {
            return false;
        }
        return $hash;
    }


    /*
    * Custom Handle a failed validation attempt.
    *
    * @param  \Illuminate\Contracts\Validation\Validator  $validator
    * @return void
    *
    * @throws \Illuminate\Validation\ValidationException
    */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
      
        $errors = $validator->errors();
        $errors_arr = $errors->toArray();

        if ($this->is('api/*')) {
          
            $message = "";
            $field = "";
            foreach ($errors_arr as $key => $val) {               
                foreach ($val as $item) {
                    if ($message == "") {
                        $field = $key;
                        $message = $item;
                        break;
                    }
                }
            }
           
            if(request()->ajax()){
                echo json_encode([
                    'success' => false,
                    'field' => $field,
                    'message' => ($message == "" ? $errors : $message)
                ]);
                die();
            }else{
                $response = new JsonResponse([
                    'success' => false,
                    'message' => ($message == "" ? $errors : $message)
                ], 422);
                throw new \Illuminate\Validation\ValidationException($validator, $response);
            }
           
           
            
        } else {
            throw (new \Illuminate\Validation\ValidationException($validator))
                ->errorBag($this->errorBag)
                ->redirectTo($this->getRedirectUrl());
        }
    }
}
