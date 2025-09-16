<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\dashboard\Departmans;
use App\Models\dashboard\Service;
use App\Models\dashboard\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{

    public function index(Request $request)
    {

        $search = $request->search;

        $query = Service::query()
            ->leftJoin('supervisors', 'services.supervisors_id', '=', 'supervisors.id')
            ->leftJoin('departmans', 'services.departmans_id', '=', 'departmans.id')
            ->select('services.*'); // مهم: فقط ستون‌های جدول وام‌ها رو بگیر

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('services.name', 'like', "%$search%")
                    ->orWhere('services.idCard', 'like', "%$search%")
                    ->orWhere('services.price', 'like', "%$search%")
                    ->orWhere('services.category', 'like', "%$search%")
                    ->orWhere('supervisors.name', 'like', "%$search%")
                    ->orWhere('departmans.name', 'like', "%$search%");
            });
        }

        $services = $query->latest('services.created_at')->paginate(10);

        $role = Auth::user()->role;
        $serviceCount = Service::count();
        return view('dashboard/allService', compact('role', 'serviceCount', 'services'));
    }

    public function create()
    {
        $role = Auth::user()->role;
        $services = Service::all();
        $supervisors = Supervisor::all();
        $departmans = Departmans::all();
        return view('dashboard/createService', compact('services', 'role', 'supervisors', 'departmans'));
    }
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => ['required', 'persian_alpha'],
            'idCard' => ['required', 'ir_national_id'],
            'departmans_id' => ['required', 'exists:departmans,id'],
            'supervisors_id' => ['required', 'exists:supervisors,id'],
            'category' => ['required', 'in:خدمات تعمیرگاهی,موتورسیکلت بنزینی, موتورسیکلت برقی,محصولات کودک ,دوچرخه,اکسسوری و لوازم جانبی,تفریحات آبی,چهار چرخ,سایر'],
            'price' => ['required'],
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

        // بررسی دسترسی کاربر
        $validRoles = ['admin', 'author', 'managerM', 'managerHr', 'manager1', 'manager2', 'humanResources', 'subscriber'];
        if (!auth()->user()->hasAnyRole($validRoles)) {
            abort(403, 'دسترسی غیرمجاز');
        }

        $fields['author_id'] = Auth::id();
        $fields['accept'] = $request->has('accept') ? 'Yes' : 'No';

        $services = Service::create($fields);
        return $services
            ? redirect()->route('service.create')->with('success', 'درخواست شما با موفقیت ثبت شد.')
            : redirect()->route('service.create')->with('error', 'مشکلی رخ داده است.');
    }
    public function show(string $id)
    {
        //
    }
    public function edit(string $id)
    {
        $service = Service::find($id);
        $role = Auth::user()->role;
        $supervisors = Supervisor::all();
        $departmans = Departmans::all();
        return $service ? view('dashboard.editService', compact('service', 'role', 'supervisors', 'departmans')) : redirect()->route('service.index')->with('error', 'درخواست مورد نظر پیدا نشد.');
    }
    public function update(Request $request, Service $service)
    {
        $user = auth()->user();
        $request->merge([
            'accept' => $request->has('accept') ? 'Yes' : 'No',
            'status' => $request->status ?? 'Pending',
        ]);

        if ($user->hasRole('subscriber')) {

            if ($service->status !== 'Yes') {

                $request->validate([
                    'name' => 'required|string|max:255|persian_alpha',
                    'idCard' => 'required|string|ir_national_id',
                    'departmans_id' => 'required|exists:departmans,id',
                    'supervisors_id' => 'required|exists:supervisors,id',
                    'category' => 'required|in:خدمات تعمیرگاهی,موتورسیکلت بنزینی,موتورسیکلت برقی,محصولات کودک,دوچرخه,اکسسوری و لوازم جانبی,تفریحات آبی,چهار چرخ,سایر',
                    'price' => 'required|min:0',
                    'descriptionUser' => 'nullable|string',
                    'accept' => 'required|in:Yes,No',
                ]);

                $service->update([
                    'name' => $request->name,
                    'idCard' => $request->idCard,
                    'category' => $request->category,
                    'price' => $request->price,
                    'departmans_id' => $request->departmans_id,
                    'supervisors_id' => $request->supervisors_id,
                    'descriptionUser' => $request->descriptionUser,
                    'accept' => $request->accept,
                ]);
            } else {
                return back()->with('error', 'امکان ویرایش وجود ندارد. درخواست وارد مراحل بعدی شده است.');
            }
        }

        if ($user->hasAnyRole(['author', 'admin'])) {

            $request->validate([
                'name' => 'required|string|max:255|persian_alpha',
                'idCard' => 'required|string|ir_national_id',
                'departmans_id' => 'required|exists:departmans,id',
                'supervisors_id' => 'required|exists:supervisors,id',
                'category' => 'required|in:خدمات تعمیرگاهی,موتورسیکلت بنزینی,موتورسیکلت برقی,محصولات کودک,دوچرخه,اکسسوری و لوازم جانبی,تفریحات آبی,چهار چرخ,سایر',
                'price' => 'required',
                'descriptionUser' => 'nullable|string',
                'accept' => 'required|in:Yes,No',
                'status' => 'required|in:Pending,Yes,No',

            ]);
            $service->update([
                'name' => $request->name,
                'idCard' => $request->idCard,
                'category' => $request->category,
                'price' => $request->price,
                'departmans_id' => $request->departmans_id,
                'supervisors_id' => $request->supervisors_id,
                'descriptionUser' => $request->descriptionUser,
                'accept' => $request->accept,
            ]);
        }
        if ($user->hasAnyRole(['humanResources', 'admin'])) {
            $request->validate([
                'memberDate' => 'required',
                'memberPrice' => 'required',
                'lastSalary' => 'required',
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
                'debt_company.required' => 'بدهی وام شرکت',
                'debt_madiran.required' => 'بدهی مادیران',
                'debt_fund.required' => 'بدهی وام صندوق',
                'debt_purchase.required' => 'بدهی شرکت ',
                'number.regex' => ' به طور مثال : 01-04',
                'validationDate.required' => 'تاریخ اعتبارسنجی را وارد نمایید',
            ]);
            $service->update([
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
            $service->update([
                'descriptionHr' => $request->descriptionHr,
                'validation_managerHr' => $request->validation_managerHr ?? 'Pending',
            ]);
        }

        if ($user->hasAnyRole(['manager1', 'admin'])) {

            $request->validate([
                'descriptionManager1' => 'nullable|string',
                'validationManager1' => 'required|in:Pending,Yes,No',
            ]);
            $service->update([
                'descriptionManager1' => $request->descriptionManager1,
                'validationManager1' => $request->validationManager1 ?? 'Pending',

            ]);
        }

        if ($user->hasAnyRole(['manager2', 'admin'])) {

            $request->validate([
                'finalPrice' => 'required',
                'descriptionManager2' => 'nullable|string',
                'validationManager2' => 'required|in:Pending,Yes,No',
            ]);

            $service->update([
                'finalPrice' => $request->finalPrice,
                'descriptionManager2' => $request->descriptionManager2,
                'validationManager2' => $request->validationManager2 ?? 'Pending',
            ]);
        }

        return back()->with('success', 'تغییرات با موفقیت ذخیره شد.');
    }

    public function destroy(string $id)
    {
        $services = Service::findOrfail($id);
        $servicesDestroy = $services->delete();
        return $servicesDestroy ? redirect()->route('service.index')->with('success', 'سرویس مورد نظر با موفقیت حذف گردید') : redirect()->route('service.index')->with('error', 'خطایی در حذف  سرویس مورد نظر رخ داده است');
    }
}
