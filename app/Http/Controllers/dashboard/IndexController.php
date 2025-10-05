<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\dashboard\Imprest;
use App\Models\dashboard\Maadiran;
use App\Models\dashboard\Service;
use App\Models\dashboard\Vam;
use App\Models\dashboard\NewsModel;


class IndexController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // گرفتن کاربر لاگین شده

        if ($user) {
            $vamCount = Vam::where('author_id', $user->id)->count();
            $serviceCount = Service::where('author_id', $user->id)->count();
            $maadiranCount = Maadiran::where('author_id', $user->id)->count();
            $imprestCount = Imprest::where('author_id', $user->id)->count();
        } else {
            $vamCount = $serviceCount = $maadiranCount = $imprestCount = 0;
        }

        $vams = Vam::where('author_id', $user->id)->get()->map(function ($item) {
            $item->type = 'درخواست وام';
            $item->accept = $item->accept ?? null;
            $item->status = $item->status ?? null;
            $item->validationHr = $item->validationHr ?? null;
            $item->validationManager1 = $item->validationManager1 ?? null;
            $item->validationManager2 = $item->validationManager2 ?? null;
            $item->edit_route = route('vam.edit', $item->id);
            return $item; // برگرداندن خودِ مدل، نه آرایه
        });

        $services = Service::where('author_id', $user->id)->get()->map(function ($item) {

            $item->type = 'درخواست خرید از کویر';
            $item->accept = $item->accept ?? null;
            $item->status = $item->status ?? null;
            $item->validationHr = $item->validationHr ?? null;
            $item->validationManager1 = $item->validationManager1 ?? null;
            $item->validationManager2 = $item->validationManager2 ?? null;
            $item->edit_route = route('service.edit', $item->id);
            return $item;
        });

        $maadirans = Maadiran::where('author_id', $user->id)->get()->map(function ($item) {
            $item->type = 'درخواست خرید از مادیران';
            $item->accept = $item->accept ?? null;
            $item->status = $item->status ?? null;
            $item->validationHr = $item->validationHr ?? null;
            $item->edit_route = route('maadiran.edit', $item->id);
            return $item;
        });

        $imprests = Imprest::where('author_id', $user->id)->get()->map(function ($item) {
            $item->type = 'درخواست مساعده';
            $item->status = $item->status ?? null;
            $item->accept = $item->accept ?? null;
            $item->edit_route = route('imprest.edit', $item->id);
            return $item;
        });

        $news = NewsModel::latest('news_models.created_at')->paginate(10);


        $allRequests = collect()
            ->concat($vams)
            ->concat($services)
            ->sortByDesc('created_at');

        return view('dashboard.index', compact('user', 'news' ,'vamCount', 'allRequests', 'maadirans', 'imprests', 'serviceCount', 'maadiranCount', 'imprestCount'));
    }
}
