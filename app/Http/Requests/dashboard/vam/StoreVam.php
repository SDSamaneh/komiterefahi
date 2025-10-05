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
            'price' => 'required',
            'descriptionUser' => 'nullable|string',
            'resone' => 'required|in:تحصیل,ازدواج,جهیزیه,درمان,تصادف,بیمه,فوت اقوام,مسکن,سایر',
            'accept' => 'required|in:No,Yes',
            'status' => 'nullable|in:Pending,No,Yes',
            'memberDate' => 'nullable|persian_date',
            'memberPrice' => 'nullable|persian_num',
            'lastSalary' => 'nullable|persian_num',
            'debt_company' => 'nullable|persian_num',
            'debt_madiran' => 'nullable|persian_num',
            'debt_fund' => 'nullable|persian_num',
            'debt_purchase' => 'nullable|persian_num',
            'validationDate' => 'nullable|persian_date',
            'descriptionHr' => 'nullable|string',
            'validationHr' => 'nullable|in:Pending,No,Yes',
            'descriptionManager1' => 'nullable|string',
            'validationManager1' => 'nullable|in:Pending,No,Yes',
            'finalPrice' => 'nullable',
            'descriptionManager2' => 'nullable|string',
            'validationManager2' => 'nullable|in:Pending,No,Yes',

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
            'accept.required' => 'برای استفاده از امکانات رفاهی باید قوانین را تایید فرمایید'
        ];
    }
}
