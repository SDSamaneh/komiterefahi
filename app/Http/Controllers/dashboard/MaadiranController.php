<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\dashboard\Maadiran;
use Illuminate\Support\Facades\Auth;
use App\Models\dashboard\Departmans;
use App\Models\dashboard\Supervisor;

class MaadiranController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;
        $query = Maadiran::query()
            ->leftJoin('supervisors', 'maadirans.supervisors_id', '=', 'supervisors.id')
            ->leftJoin('departmans', 'maadirans.departmans_id', '=', 'departmans.id')
            ->select('maadirans.*'); // فقط ستون‌های جدول مادیران رو بگیر

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('maadirans.name', 'like', "%$search%")
                    ->orWhere('maadirans.idCard', 'like', "%$search%")
                    ->orWhere('maadirans.price', 'like', "%$search%")
                    ->orWhere('supervisors.name', 'like', "%$search%")
                    ->orWhere('departmans.name', 'like', "%$search%");
            });
        }

        $maadirans = $query->latest('maadirans.created_at')->paginate(10);

        $role = Auth::user()->role;
        $supervisors = Supervisor::all();
        $departmans = Departmans::all();
        $maadiranCount = Maadiran::count();
        return view('dashboard/allMaadiran', compact('maadirans', 'role', 'maadiranCount', 'supervisors', 'departmans'));
    }

    public function create()
    {
        $role = Auth::user()->role;
        $maadirans = Maadiran::all();
        $supervisors = Supervisor::all();
        $departmans = Departmans::all();
        return view('dashboard/createMaadiran', compact('maadirans', 'role', 'supervisors', 'departmans'));
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => ['required', 'persian_alpha'],
            'idCard' => ['required', 'ir_national_id'],
            'departmans_id' => ['required', 'exists:departmans,id'],
            'supervisors_id' => ['required', 'exists:supervisors,id'],
            'price' => ['required'],
            'category' => ['required', 'in:موبایل,لپتاپ,لوازم خانگی,تلویزیون,سایر'],
            'descriptionUser' => ['nullable', 'string'],
            'accept' => ['required', 'in:No,Yes'],

        ], [
            'name.required' => 'نام و نام خانوادگی خود را وارد کنید',
            'idCard.required' => 'کد ملی را وارد کنید',
            'departmans_id.required' => 'دپارتمان خود را وارد کنید',
            'supervisors_id.required' => 'مدیر واحد خود را انتخاب کنید',
            'price.required' => 'مبلغ درخواست را وارد کنید',
            'accept.required' => 'قوانین را میپذیرم'
        ]);

        $validRoles = ['admin', 'author', 'managerM', 'managerHr', 'manager1', 'manager2', 'humanResources', 'subscriber'];
        if (!auth()->user()->hasAnyRole($validRoles)) {
            abort(403, 'دسترسی غیرمجاز');
        }

        $fields['author_id'] = Auth::id();
        $fields['accept'] = $request->has('accept') ? 'Yes' : 'No';


        $maadirans = Maadiran::create($fields);
        return $maadirans
            ? redirect()->route('maadiran.create')->with('success', 'درخواست شما با موفقیت ثبت شد.')
            : redirect()->route('maadiran.create')->with('error', 'مشکلی رخ داده است.');
    }

    public function show(string $id) {}

    public function edit(string $id)
    {
        $maadiran = Maadiran::find($id);
        $role = Auth::user()->role;
        $supervisors = Supervisor::all();
        $departmans = Departmans::all();
        return $maadiran ? view('dashboard.editMaadiran', compact('maadiran', 'role', 'supervisors', 'departmans')) : redirect()->route('maadiran.index')->with('error', 'درخواست مورد نظر پیدا نشد.');
    }


    public function update(Request $request, Maadiran $maadiran)
    {
        $user = auth()->user();

        $request->merge([
            'accept' => $request->has('accept') ? 'Yes' : 'No',
            'status' => $request->status ?? 'Pending',
        ]);

        if ($user->hasRole('subscriber')) {

            if ($maadiran->status !== 'Yes') {
                $request->validate([
                    'name' => 'required|string|max:255|persian_alpha',
                    'idCard' => 'required|string|ir_national_id',
                    'departmans_id' => 'required|exists:departmans,id',
                    'supervisors_id' => 'required|exists:supervisors,id',
                    'price' => 'required|min:0',
                    'category' => 'required|in:موبایل,لپتاپ,لوازم خانگی,تلویزیون,سایر',
                    'descriptionUser' => 'nullable|string',
                    'accept' => 'required|in:Yes,No',
                ]);

                $maadiran->update([
                    'name' => $request->name,
                    'idCard' => $request->idCard,
                    'departmans_id' => $request->departmans_id,
                    'supervisors_id' => $request->supervisors_id,
                    'price' => $request->price,
                    'category' => $request->category,
                    'descriptionUser' => $request->descriptionUser,
                    'accept' => $request->accept,
                ]);
            } else {
                return redirect()->back()->with('error', 'امکان ویرایش وجود ندارد. درخواست وارد مراحل بعدی شده است.');
            }
        }
        if ($user->hasAnyRole(['author', 'admin'])) {

            $request->validate([
                'name' => 'required|string|max:255|persian_alpha',
                'idCard' => 'required|string|ir_national_id',
                'departmans_id' => 'required|exists:departmans,id',
                'supervisors_id' => 'required|exists:supervisors,id',
                'price' => 'required|min:0',
                'category' => 'required|in:موبایل,لپتاپ,لوازم خانگی,تلویزیون,سایر',
                'descriptionUser' => 'nullable|string',
                'accept' => 'required|in:Yes,No',
                'status' => 'required|in:Pending,Yes,No',

            ]);
            $maadiran->update([
                'name' => $request->name,
                'idCard' => $request->idCard,
                'departmans_id' => $request->departmans_id,
                'supervisors_id' => $request->supervisors_id,
                'price' => $request->price,
                'category' => $request->category,
                'descriptionUser' => $request->descriptionUser,
                'accept' => $request->accept,
            ]);
        }
        if ($user->hasAnyRole(['humanResources', 'admin'])) {

            $request->validate([
                'memberDate' => 'required',
                'memberPrice' => 'required|min:0',
                'lastSalary' => 'required|min:0',
                'debt_company' => 'required|min:0',
                'debt_madiran' => 'required|min:0',
                'debt_fund' => 'required|min:0',
                'debt_purchase' => 'required',
                'validationDate' => 'required',
                'descriptionEdari' => 'nullable|string',
                'validationHr' => 'required|in:Pending,Yes,No',

            ], [
                'memberDate.required' => 'تاریخ ورود به سازمان را وارد نمایید',
                'memberPrice.required' => 'مبلغ را وارد نمایید',
                'lastSalary.required' => 'آخرین حقوق را وارد نمایید',
                'debt_company.required' => 'بدهی وام شرکت',
                'debt_madiran.required' => 'بدهی مادیران',
                'debt_fund.required' => 'بدهی وام صندوق',
                'debt_purchase.required' => 'بدهی شرکت ',
                'validationDate.required' => 'تاریخ اعتبارسنجی را وارد نمایید',
            ]);
            $maadiran->update([
                'memberDate' => $request->memberDate,
                'memberPrice' => $request->memberPrice,
                'lastSalary' => $request->lastSalary,
                'debt_company' => $request->debt_company,
                'debt_madiran' => $request->debt_madiran,
                'debt_fund' => $request->debt_fund,
                'debt_purchase' => $request->debt_purchase,
                'validationDate' => $request->validationDate,
                'descriptionEdari' => $request->descriptionEdari,
                'validationHr' => $request->validationHr ?? 'Pending',

            ]);
        }

        if ($user->hasAnyRole(['managerHr', 'admin'])) {

            $request->validate([
                'descriptionHr' => 'nullable|string',
                'validation_managerHr' => 'required|in:Pending,Yes,No',
            ]);
            $maadiran->update([
                'descriptionHr' => $request->descriptionHr,
                'validation_managerHr' => $request->validation_managerHr ?? 'Pending',
            ]);
        }

        return redirect()->back()->with('success', 'تغییرات با موفقیت ذخیره شد.');
    }

    public function destroy(string $id)
    {
        $maadiran = Maadiran::findOrfail($id);
        $maadiranDestroy = $maadiran->delete();
        return $maadiranDestroy ? redirect()->route('maadiran.index')->with('success', 'درخواست مورد نظر با موفقیت حذف گردید') : redirect()->route('maadiran.index')->with('error', 'خطایی در حذف درخواست  مورد نظر رخ داده است');
    }
}
