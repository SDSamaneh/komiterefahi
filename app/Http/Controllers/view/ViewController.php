<?php

namespace App\Http\Controllers\view;

use App\Http\Controllers\Controller;
use App\Models\dashboard\NewsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ViewController extends Controller
{
    public function index()
    {
        $news = NewsModel::latest('created_at')->paginate(10);

        return view('view.index', compact('news'));
    }

    public function show(string $id)
    {
        $news = NewsModel::findOrFail($id);

        return $news ? view('view/details', compact('news')) : redirect()->route('view.index')->with('error', 'اطلاعیه مورد نظر پیدا نشد.');
    }
}
