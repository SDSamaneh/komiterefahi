<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\dashboard\NewsModel;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


use Illuminate\Support\Facades\Auth;
use App\Models\dashboard\Vam as DashboardVam;

class NewsController extends Controller
{

    public function index(Request $request, NewsModel $news)
    {

        $query = NewsModel::query(); // شروع ساخت کوئری

        // اگر فیلد جستجو پر شده بود
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('shortDescription', 'like', "%$search%");
            });
        }

        $news = $query->latest('news_models.created_at')->paginate(10);
        $role = Auth::user()->role;
        $newsCount = NewsModel::count();

        return view('dashboard/news', compact('news', 'role', 'newsCount'));
    }

    public function create()
    {
        $role = Auth::user()->role;
        $news = NewsModel::all();
        return view('dashboard/createNews', compact('news', 'role'));
    }


    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => ['required', 'string'],
            'shortDescription' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],

        ], [
            'title.required' => 'عنوان را وارد نمایید',
        ]);

        $validRoles = ['admin', 'humanResources'];
        if (!auth()->user()->hasAnyRole($validRoles)) {
            abort(403, 'دسترسی غیرمجاز');
        }

        $fields['author_id'] = Auth::id();

        $news = NewsModel::create($fields);
        return $news
            ? redirect()->route('news.create')->with('success', ' اطلاعیه با موفقیت ثبت شد.')
            : redirect()->route('news.create')->with('error', 'مشکلی رخ داده است.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $news = NewsModel::find($id);
        $role = Auth::user()->role;

        return $news ? view('dashboard.editNews', compact('news', 'role')) : redirect()->route('news.index')->with('error', 'اطلاعیه مورد نظر پیدا نشد.');
    }
    public function update(Request $request, NewsModel $news)
    {
        $user = auth()->user();

        // چک دسترسی
        if (!$user->hasAnyRole(['humanResources', 'admin'])) {
            abort(403, 'شما اجازه ویرایش این خبر را ندارید');
        }

        // ولیدیشن
        $request->validate([
            'title' => 'required',
            'shortDescription' => 'nullable',
            'description' => 'nullable',
        ], [
            'title.required' => 'عنوان را وارد نمایید',
        ]);

        // ذخیره تغییرات
        $news->update($request->only(['title', 'shortDescription', 'description']));

        return redirect()->route('news.index')->with('success', 'تغییرات با موفقیت ذخیره شد');
    }


    public function destroy(string $id)
    {
        $news = NewsModel::findOrfail($id);
        $newsDestroy = $news->delete();
        return $newsDestroy ? redirect()->route('news.index')->with('success', 'اطلاعیه مورد نظر با موفقیت حذف گردید') : redirect()->route('news.index')->with('error', 'خطایی در حذف اطلاعیه مورد نظر رخ داده است');
    }
}
