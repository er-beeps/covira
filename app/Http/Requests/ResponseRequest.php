<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

 class ResponseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
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
            'name_en' => 'required|max:255',
            'name_lc' => 'required|max:255',
            'age' => 'required|min:1|max:3',
            'gender_id' => 'required',
            'province_id' => 'required',
            'district_id' => 'required',
            'local_level_id' => 'required',
            'ward_number' => 'required|min:1|max:2',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name_en.required'=>'Name आवश्यक छ |',
            'name_lc.required'=>'नाम आवश्यक छ |',
            'age.required'=>'कृपया उमेर भर्नुहोस् |',
            'gender.required'=>'कृपया लिङ्ग छान्नुहोस् |',
            'province_id.required'=>'कृपया प्रदेश छान्नुहोस् |',
            'district_id.required'=>'कृपया जिल्ला छान्नुहोस् |',
            'local_level_id.required'=>'कृपया स्थानीय तह छान्नुहोस् |',
            'ward_number.required'=>'कृपया वडा नं. भर्नुहोस् |',
        ];
    }
}
