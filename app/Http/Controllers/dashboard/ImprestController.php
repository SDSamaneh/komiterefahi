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
            'status' => ['required', 'in:No,Yes'],
        ], [
            'name.required' => 'نام و نام خانوادگی خود را وارد کنید',
            'idCard.required' => 'کد ملی را وارد کنید',
            'price.required' => 'مبلغ را وارد کنید',
            'loc.required' => 'محل تابع را مشخص کنید',
            'status.required' => 'درخواست را تایید فرمایید'
        ]);


        $validRoles = ['admin', 'author', 'managerM', 'managerHr', 'manager1', 'manager2', 'humanResources', 'subscriber'];
        if (!auth()->user()->hasAnyRole($validRoles)) {
            abort(403, 'دسترسی غیرمجاز');
        }

        $fields['author_id'] = Auth::id();


        $imprests = Imprest::create($fields);
        return $imprests
            ? redirect()->route('imprest.create')->with('success', 'درخواست شما با موفقیت ثبت شد.')
            : redirect()->route('imprest.create')->with('error', 'مشکلی رخ داده است.');
    }

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
    public function update(Request $request, Imprest $imprest)
    {
        $user = auth()->user();

        if ($user->hasRole('subscriber')) {

            if ($imprest->accept !== 'Yes') {

                $request->validate([
                    'name' => 'required|string|max:255|persian_alpha',
                    'idCard' => 'required|string|ir_national_id',
                    'price' => 'required|min:0',
                    'loc' => 'required|in:یکتاز,اوراسیا',
                    'status' => 'required|in:No,Yes',
                ]);

                $imprest->update([
                    'name' => $request->name,
                    'idCard' => $request->idCard,
                    'price' => $request->price,
                    'loc' => $request->loc,
                    'status' => $request->status,
                ]);
            } else {

                return redirect()->back()->with('error', 'امکان ویرایش وجود ندارد. درخواست وارد مراحل بعدی شده است.');
            }
        }

        if ($user->hasAnyRole(['managerM', 'admin'])) {

            $request->validate([
                'finalPrice' => 'required|min:0',
                'description' => 'nullable|string',
                'accept' => 'required|in:Pending,Yes,No',
            ]);
            $imprest->update([
                'finalPrice' => $request->finalPrice,
                'description' => $request->description,
                'accept' => $request->accept ?? 'Pending',
            ]);
        }

        return redirect()->back()->with('success', 'تغییرات با موفقیت ذخیره شد.');
    }


    public function destroy(string $id)
    {
        $imprest = Imprest::findOrfail($id);
        $imprestDestroy = $imprest->delete();
        return $imprestDestroy ? redirect()->route('imprest.index')->with('success', 'درخواست مورد نظر با موفقیت حذف گردید') : redirect()->route('imprest.index')->with('error', 'خطایی در حذف درخواست  مورد نظر رخ داده است');
    }
}
