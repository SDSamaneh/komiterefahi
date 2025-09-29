<?php

namespace App\Http\Controllers\view;

use App\Http\Controllers\Controller;
use App\Models\dashboard\NewsModel;

use Illuminate\Http\Request;

class UserNewsController extends Controller
{
    public function index(Request $request)
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
        return view('view/index', compact('news'));
    }
}
