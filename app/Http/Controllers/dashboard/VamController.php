<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard\vam\StoreVam;
use App\Models\dashboard\Departmans;
use App\Models\dashboard\Supervisor;
use App\Models\dashboard\Vam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\dashboard\Vam as DashboardVam;

class VamController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request, DashboardVam $vam)
    {
        $search = $request->search;

        $query = Vam::query()
            ->leftJoin('supervisors', 'vams.supervisors_id', '=', 'supervisors.id')
            ->leftJoin('departmans', 'vams.departmans_id', '=', 'departmans.id')
            ->select('vams.*'); // مهم: فقط ستون‌های جدول وام‌ها رو بگیر

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('vams.name', 'like', "%$search%")
                    ->orWhere('vams.idCard', 'like', "%$search%")
                    ->orWhere('vams.price', 'like', "%$search%")
                    ->orWhere('vams.resone', 'like', "%$search%")
                    ->orWhere('supervisors.name', 'like', "%$search%")
                    ->orWhere('departmans.name', 'like', "%$search%");
            });
        }

        $vams = $query->latest('vams.created_at')->paginate(10);
        $role = Auth::user()->role;
        $supervisors = Supervisor::all();
        $departmans = Departmans::all();
        $vamCount = Vam::count();

        return view('dashboard/allVamKomiteh', compact('vams', 'role', 'vamCount', 'supervisors', 'departmans'));
    }

    public function create()
    {
        $role = Auth::user()->role;
        $vams = Vam::all();
        $supervisors = Supervisor::all();
        $departmans = Departmans::all();
        return view('dashboard/vamKomiteh', compact('vams', 'role', 'supervisors', 'departmans'));
    }

    public function store(StoreVam $request)
    {
        // اجازه ثبت فقط اگر مجاز باشه
        $this->authorize('create', Vam::class);

        $validRoles = ['admin', 'author', 'managerM', 'managerHr', 'manager1', 'manager2', 'humanResources', 'subscriber'];
        if (!auth()->user()->hasAnyRole($validRoles)) {
            abort(403, 'دسترسی غیرمجاز');
        }
        // اعتبارسنجی داده‌ها
        $fields = $request->validated();
        $fields['author_id'] = Auth::id();
        $fields['price'] = str_replace(',', '', $fields['price']);
        $fields['accept'] = $request->has('accept') ? 'Yes' : 'No';
        // ایجاد رکورد
        $vams = Vam::create($fields);
        // بازگشت نتیجه
        return $vams
            ? redirect()->route('vam.create')->with('success', 'درخواست وام با موفقیت ثبت شد.')
            : redirect()->route('vam.create')->with('error', 'مشکلی رخ داده است.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $vam = Vam::find($id);
        $role = Auth::user()->role;
        $supervisors = Supervisor::all();
        $departmans = Departmans::all();
        return $vam ? view('dashboard.editVamKomiteh', compact('vam', 'role', 'supervisors', 'departmans')) : redirect()->route('vam.index')->with('error', 'درخواست مورد نظر پیدا نشد.');
    }

    public function update(Request $request, DashboardVam $vam)
    {
        $user = auth()->user();

        $request->merge([
            'accept' => $request->has('accept') ? 'Yes' : 'No',
            'status' => $request->status ?? 'Pending',
        ]);

        if ($user->hasRole('subscriber')) {
            if ($vam->status !== 'Yes') {
                $request->validate([
                    'name' => 'required|string|max:255|persian_alpha',
                    'idCard' => 'required|string|ir_national_id',
                    'price' => 'required|min:0',
                    'departmans_id' => 'required|exists:departmans,id',
                    'supervisors_id' => 'required|exists:supervisors,id',
                    'resone' => 'required|in:تحصیل,ازدواج,جهیزیه,درمان,تصادف,بیمه,فوت اقوام,سایر',
                    'descriptionUser' => 'nullable|string',
                    'accept' => 'required|in:Yes,No',
                ]);

                $vam->update([
                    'name' => $request->name,
                    'idCard' => $request->idCard,
                    'price' => $request->price,
                    'departmans_id' => $request->departmans_id,
                    'supervisors_id' => $request->supervisors_id,
                    'resone' => $request->resone,
                    'descriptionUser' => $request->descriptionUser,
                    'accept' => $request->accept,
                ]);
            } else {
                return redirect()->back()->with('error', 'امکان ویرایش وجود ندارد. درخواست وارد مراحل بعدی شده است');
            }
        }

        if ($user->hasAnyRole(['author', 'admin'])) {

            $request->validate([
                'name' => 'required|string|max:255|persian_alpha',
                'idCard' => 'required|string|ir_national_id',
                'price' => 'required|min:0',
                'departmans_id' => 'required|exists:departmans,id',
                'supervisors_id' => 'required|exists:supervisors,id',
                'resone' => 'required|in:تحصیل,ازدواج,جهیزیه,درمان,تصادف,بیمه,فوت اقوام,سایر',
                'descriptionUser' => 'nullable|string',
                'accept' => 'required|in:Yes,No',
                'status' => 'required|in:Pending,Yes,No',
            ]);

            $vam->update([
                'name' => $request->name,
                'idCard' => $request->idCard,
                'price' => $request->price,
                'departmans_id' => $request->departmans_id,
                'supervisors_id' => $request->supervisors_id,
                'resone' => $request->resone,
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
                'number' => 'nullable|regex:/^[0-9-]+$/',
                'descriptionEdari' => 'nullable|string',
                'validationHr' => 'required|in:Pending,Yes,No',
            ], [
                'memberDate.required' => 'تاریخ ورود به سازمان را وارد نمایید',
                'memberPrice.required' => 'مبلغ را وارد نمایید',
                'lastSalary.required' => 'آخرین حقوق را وارد نمایید',
                'debt_company.required' => 'میزان وام شرکت',
                'debt_madiran.required' => 'میزان مادیران',
                'debt_fund.required' => 'میزان وام صندوق',
                'debt_purchase.required' => 'میزان شرکت ',
                'number.regex' => ' به طور مثال : 01-04',
                'validationDate.required' => 'تاریخ اعتبارسنجی را وارد نمایید',
            ]);
            $vam->update([
                'memberDate' => $request->memberDate,
                'memberPrice' => $request->memberPrice,
                'lastSalary' => $request->lastSalary,
                'debt_company' => $request->debt_company,
                'debt_madiran' => $request->debt_madiran,
                'debt_fund' => $request->debt_fund,
                'debt_purchase' => $request->debt_purchase,
                'validationDate' => $request->validationDate,
                'number' => $request->number,
                'descriptionEdari' => $request->descriptionEdari,
                'validationHr' => $request->validationHr ?? 'Pending',
            ]);
        }

        if ($user->hasAnyRole(['managerHr', 'admin'])) {

            $request->validate([
                'descriptionHr' => 'nullable|string',
                'validation_managerHr' => 'required|in:Pending,Yes,No',
            ]);
            $vam->update([
                'descriptionHr' => $request->descriptionHr,
                'validation_managerHr' => $request->validation_managerHr ?? 'Pending',
            ]);
        }

        if ($user->hasAnyRole(['manager1', 'admin'])) {

            $request->validate([
                'descriptionManager1' => 'nullable|string',
                'validationManager1' => 'required|in:Pending,Yes,No',
            ]);
            $vam->update([
                'descriptionManager1' => $request->descriptionManager1,
                'validationManager1' => $request->validationManager1 ?? 'Pending',
            ]);
        }

        if ($user->hasAnyRole(['manager2', 'admin'])) {

            $request->validate([
                'finalPrice' => 'required|min:0',
                'descriptionManager2' => 'nullable|string',
                'validationManager2' => 'required|in:Pending,Yes,No',
            ]);
            $vam->update([
                'finalPrice' => $request->finalPrice,
                'descriptionManager2' => $request->descriptionManager2,
                'validationManager2' => $request->validationManager2 ?? 'Pending',
            ]);
        }

        return redirect()->back()->with('success', 'تغییرات با موفقیت ذخیره شد.');
    }

    public function destroy(string $id)
    {
        $vam = Vam::findOrfail($id);
        $vamDestroy = $vam->delete();
        return $vamDestroy ? redirect()->route('vam.index')->with('success', 'درخواست مورد نظر با موفقیت حذف گردید') : redirect()->route('vam.index')->with('error', 'خطایی در حذف درخواست  مورد نظر رخ داده است');
    }
}
