<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\dashboard\Imprest;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class ImprestController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;
        $query = Imprest::query()
            ->select('imprests.*'); // مهم: فقط ستون‌های جدول وام‌ها رو بگیر

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('imprests.name', 'like', "%$search%")
                    ->orWhere('imprests.idCard', 'like', "%$search%")
                    ->orWhere('imprests.price', 'like', "%$search%");
            });
        }

        $imprests = $query->latest('imprests.created_at')->paginate(10);

        $role = Auth::user()->role;

        $imprestCount = Imprest::count();
        return view('dashboard/allImprest', compact('imprests', 'role', 'imprestCount'));
    }

    public function create()
    {
        $role = Auth::user()->role;
        $imprests = Imprest::all();

        return view('dashboard/createImprest', compact('imprests', 'role'));
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => ['required', 'persian_alpha'],
            'idCard' => ['required', 'ir_national_id'],
            'price' => ['required'],
            'loc' => ['required', 'in:یکتاز,اوراسیا'],

        ], [
            'name.required' => 'نام و نام خانوادگی خود را وارد کنید',
            'idCard.required' => 'کد ملی را وارد کنید',
            'price.required' => 'مبلغ را وارد کنید',
            'loc.required' => 'محل تابع را مشخص کنید'
        ]);


        $role = Auth::user()->role;

        if (!in_array($role, ['admin', 'author', 'managerHr', 'manager1', 'manager2', 'humanResources', 'subscriber'])) {
            abort(403, 'دسترسی غیرمجاز');
        }

        $fields['author_id'] = Auth::id();


        $imprests = Imprest::create($fields);
        return $imprests
            ? redirect()->route('imprest.create')->with('success', 'درخواست شما با موفقیت ثبت شد.')
            : redirect()->route('imprest.create')->with('error', 'مشکلی رخ داده است.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    public function edit(string $id)
    {
        $imprest = Imprest::find($id);
        $role = Auth::user()->role;

        return $imprest ? view('dashboard.editImprest', compact('imprest', 'role')) : redirect()->route('imprest.index')->with('error', 'درخواست مورد نظر پیدا نشد.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Imprest $imprest)
    {
        $user = auth()->user();

        switch ($user->role) {

            case 'subscriber':

                if ($imprest->status !== 'Yes') {

                    $request->validate([
                        'name' => 'required|string|max:255|persian_alpha',
                        'idCard' => 'required|string|ir_national_id',
                        'price' => 'required|min:0',
                        'loc' => 'required|in:یکتاز,اوراسیا',
                    ]);

                    $imprest->update([
                        'name' => $request->name,
                        'idCard' => $request->idCard,
                        'price' => $request->price,
                        'loc' => $request->loc,

                    ]);
                } else {
                    return redirect()->back()->with('error', 'امکان ویرایش وجود ندارد. درخواست وارد مراحل بعدی شده است.');
                }
                break;

            case 'author':

                if ($imprest->status === 'Yes') {
                    return back()->with('error', 'امکان ویرایش وجود ندارد. درخواست وارد مراحل بعدی شده است.');
                }

                $request->validate([
                    'name' => 'required|string|max:255|persian_alpha',
                    'idCard' => 'required|string|ir_national_id',
                    'price' => 'required|min:0',
                    'loc' => 'required|in:یکتاز,اوراسیا',
                    'status' => 'required|in:Pending,Yes,No',

                ]);
                $imprest->update([
                    'name' => $request->name,
                    'idCard' => $request->idCard,
                    'price' => $request->price,
                    'loc' => $request->loc,
                    'status' => $request->status,
                ]);
                break;

            case 'humanResources':

                if ($imprest->validationHr === 'Yes') {
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
                $imprest->update([
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

                if ($imprest->validation_managerHr === 'Yes') {
                    return back()->with('error', 'امکان ویرایش وجود ندارد.');
                }

                $request->validate([
                    'validation_managerHr' => 'required|in:Pending,Yes,No',
                ]);
                $imprest->update([
                    'validation_managerHr' => $request->validation_managerHr ?? 'Pending',
                ]);
                break;
            case 'manager1':

                if ($imprest->validationManager1 === 'Yes') {
                    return back()->with('error', 'امکان ویرایش وجود ندارد.');
                }

                $request->validate([

                    'descriptionManager1' => 'nullable|string',
                    'validationManager1' => 'required|in:Pending,Yes,No',
                ]);
                $imprest->update([
                    'descriptionManager1' => $request->descriptionManager1,
                    'validationManager1' => $request->validationManager1 ?? 'Pending',
                ]);

                break;

            case 'manager2':

                if ($imprest->validationManager2 === 'Yes') {
                    return back()->with('error', 'امکان ویرایش وجود ندارد.');
                }

                $request->validate([

                    'finalPrice' => 'required|min:0',
                    'descriptionManager2' => 'nullable|string',

                    'validationManager2' => 'required|in:Pending,Yes,No',
                ]);
                $imprest->update([
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $imprest = Imprest::findOrfail($id);
        $imprestDestroy = $imprest->delete();
        return $imprestDestroy ? redirect()->route('imprest.index')->with('success', 'درخواست مورد نظر با موفقیت حذف گردید') : redirect()->route('imprest.index')->with('error', 'خطایی در حذف درخواست  مورد نظر رخ داده است');
    }
}
