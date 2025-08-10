<?php

namespace App\Http\Requests\dashboard\vam;

use Illuminate\Foundation\Http\FormRequest;


class StoreVam extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
            'name' => 'required|persian_alpha',
            'idCard' => 'required|ir_national_id',
            'departmans_id' => 'required|exists:departmans,id',
            'supervisors_id' => 'required|exists:supervisors,id',
<<<<<<< HEAD
            'price' => 'required|numeric',
=======
            'price' => 'required',
>>>>>>> 26b23e8 (final)
            'descriptionUser' => 'nullable|string',
            'resone' => 'required|in:تحصیل,ازدواج,جهیزیه,درمان,تصادف,بیمه,فوت اقوام,سایر',
            'accept' => 'required|in:No,Yes',
            'status' => 'nullable|in:No,Yes',
            'memberDate' => 'nullable|persian_date',
            'memberPrice' => 'nullable|persian_num',
            'lastSalary' => 'nullable|persian_num',
            'debt' => 'nullable|persian_num',
            'validationDate' => 'nullable|persian_date',
<<<<<<< HEAD
            'validationHr' => 'nullable|in:No,Yes',
            'validationManager1' => 'nullable|in:No,Yes',
            'finalPrice' => 'nullable|numeric',
            'description' => 'nullable|string',
            'validationManager2' => 'nullable|in:No,Yes',
=======
            'descriptionHr' => 'nullable|string',
            'validationHr' => 'nullable|in:Pending,No,Yes',
            'descriptionManager1' => 'nullable|string',
            'validationManager1' => 'nullable|in:Pending,No,Yes',
            'finalPrice' => 'nullable',
            'descriptionManager2' => 'nullable|string',
            'validationManager2' => 'nullable|in:Pending,No,Yes',
>>>>>>> 26b23e8 (final)

        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'نام و نام خانوادگی خود را وارد کنید',
            'idCard.required' => 'کد ملی خود را وارد کنید',
            'departmans_id.required' => 'نام دپارتمان خود را وارد کنید',
            'supervisors_id.required' => 'نام مدیر واحد خود را وارد کنید',
            'price.required' => ' مبلغ درخواستی خود را وارد کنید',
<<<<<<< HEAD
            'price.numeric' => 'مبلغ باید به صورت عددی باشد',
=======
>>>>>>> 26b23e8 (final)
            'accept.required' => 'برای استفاده از امکانات رفاهی باید قوانین را تایید فرمایید'
        ];
    }
}
