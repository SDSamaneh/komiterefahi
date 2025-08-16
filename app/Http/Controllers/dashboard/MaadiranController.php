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
            ->select('maadirans.*'); // مهم: فقط ستون‌های جدول وام‌ها رو بگیر

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


        $role = Auth::user()->role;

        if (!in_array($role, ['admin', 'author', 'manager1', 'manager2', 'humanResources', 'subscriber'])) {
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
        ]);

        switch ($user->role) {

            case 'subscriber':

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
                break;

            case 'author':

                if ($maadiran->status === 'Yes') {
                    return back()->with('error', 'امکان ویرایش وجود ندارد. درخواست وارد مراحل بعدی شده است.');
                }

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
                    'status' => $request->status,
                ]);
                break;

            case 'humanResources':

                if ($maadiran->validationHr === 'Yes') {
                    return back()->with('error', 'امکان ویرایش وجود ندارد.');
                }

                $request->validate([
                    'memberDate' => 'required',
                    'memberPrice' => 'required|min:0',
                    'lastSalary' => 'required|min:0',
                    'debt_company' => 'required|min:0',
                    'debt_madiran' => 'required|min:0',
                    'debt_fund' => 'required|min:0',
                    'debt_purchase' => 'required',
                    'validationDate' => 'required',
                    'descriptionHr' => 'nullable|string',
                    'validationHr' => 'required|in:Pending,Yes,No',

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
                    'descriptionHr' => $request->descriptionHr,
                    'validationHr' => $request->validationHr ?? 'Pending',

                ]);
                break;
            case 'managerHr':

                if ($maadiran->validation_managerHr === 'Yes') {
                    return back()->with('error', 'امکان ویرایش وجود ندارد.');
                }

                $request->validate([
                    'validation_managerHr' => 'required|in:Pending,Yes,No',
                ]);
                $maadiran->update([
                    'validation_managerHr' => $request->validation_managerHr ?? 'Pending',
                ]);
                break;
            case 'manager1':

                if ($maadiran->validationManager1 === 'Yes') {
                    return back()->with('error', 'امکان ویرایش وجود ندارد.');
                }

                $request->validate([

                    'descriptionManager1' => 'nullable|string',
                    'validationManager1' => 'required|in:Pending,Yes,No',
                ]);
                $maadiran->update([
                    'descriptionManager1' => $request->descriptionManager1,
                    'validationManager1' => $request->validationManager1 ?? 'Pending',
                ]);

                break;

            case 'manager2':

                if ($maadiran->validationManager2 === 'Yes') {
                    return back()->with('error', 'امکان ویرایش وجود ندارد.');
                }

                $request->validate([

                    'finalPrice' => 'required|min:0',
                    'descriptionManager2' => 'nullable|string',

                    'validationManager2' => 'required|in:Pending,Yes,No',
                ]);
                $maadiran->update([
                    'finalPrice' => $request->finalPrice,
                    'descriptionManager2' => $request->descriptionManager2,
                    'validationManager2' => $request->validationManager2 ?? 'Pending',
                ]);
                break;

            default:
                return redirect()->back()->with('error', 'شما اجازه دسترسی به این عملیات را ندارید.');
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
