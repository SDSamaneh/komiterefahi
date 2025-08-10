<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
use App\Models\dashboard\Announcement;
use App\Models\dashboard\Maadiran;
use App\Models\dashboard\Service;
use App\Models\dashboard\Vam;
use App\Models\User;
use Illuminate\Http\Request;
=======
use App\Models\dashboard\Maadiran;
use App\Models\dashboard\Service;
use App\Models\dashboard\Vam;
>>>>>>> 26b23e8 (final)

class IndexController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // گرفتن کاربر لاگین شده

        if ($user) {
            $vamCount = Vam::where('author_id', $user->id)->count();
            $serviceCount = Service::where('author_id', $user->id)->count();
            $maadiranCount = Maadiran::where('author_id', $user->id)->count();
<<<<<<< HEAD
            $announcementCount = Announcement::count();
        } else {
            $vamCount = $serviceCount = $announcementCount = $maadiranCount = 0;
=======
        } else {
            $vamCount = $serviceCount = $maadiranCount = 0;
>>>>>>> 26b23e8 (final)
        }

        $vams = Vam::where('author_id', $user->id)->get()->map(function ($item) {
            return [
                'type' => 'درخواست وام',
                'status' => $item->status,
<<<<<<< HEAD
=======
                'validationHr' => $item->validationHr,
                'validationManager1' => $item->validationManager1,
                'validationManager2' => $item->validationManager2,
>>>>>>> 26b23e8 (final)
                'created_at' => $item->created_at,
                'edit_route' => route('vam.edit', $item->id),
            ];
        });

        $services = Service::where('author_id', $user->id)->get()->map(function ($item) {
            return [
<<<<<<< HEAD
                'type' => 'درخواست تعمیرگاه',
                'title' => $item->title,
                'status' => $item->status,
=======
                'type' => 'درخواست خرید از کویر',
                'title' => $item->title,
                'status' => $item->status,
                'validationHr' => $item->validationHr,
                'validationManager1' => $item->validationManager1,
                'validationManager2' => $item->validationManager2,
>>>>>>> 26b23e8 (final)
                'created_at' => $item->created_at,
                'edit_route' => route('service.edit', $item->id),
            ];
        });

        $maadirans = Maadiran::where('author_id', $user->id)->get()->map(function ($item) {
            return [
                'type' => 'درخواست خرید از مادیران',
                'title' => $item->title,
                'status' => $item->status,
<<<<<<< HEAD
=======
                'validationHr' => $item->validationHr,
                'validationManager1' => $item->validationManager1,
                'validationManager2' => $item->validationManager2,
>>>>>>> 26b23e8 (final)
                'created_at' => $item->created_at,
                'edit_route' => route('maadiran.edit', $item->id),
            ];
        });

        $allRequests = $vams->merge($services)->merge($maadirans)->sortByDesc('created_at');

<<<<<<< HEAD
        return view('dashboard.index', compact('user', 'vamCount', 'allRequests', 'serviceCount', 'announcementCount', 'maadiranCount'));
=======
        return view('dashboard.index', compact('user', 'vamCount', 'allRequests', 'serviceCount', 'maadiranCount'));
>>>>>>> 26b23e8 (final)
    }
}
