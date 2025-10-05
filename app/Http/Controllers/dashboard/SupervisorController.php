<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\dashboard\Departmans;
use App\Models\dashboard\Imprest;
use App\Models\dashboard\Maadiran;
use App\Models\dashboard\Service;
use App\Models\dashboard\Supervisor;
use Illuminate\Http\Request;
use App\Models\dashboard\Vam;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class SupervisorController extends Controller
{
    /**
     * گرفتن شناسه مدیر لاگین شده
     */
    private function supervisorId()
    {
        return Auth::user()->supervisor_id;
    }

    /**
     * Vam Requests
     */
    public function vamRequestsForSupervisor()
    {
        $supervisorId = $this->supervisorId();

        $vams = Vam::whereHas('user', function ($query) use ($supervisorId) {
            $query->where('supervisor_id', $supervisorId);
        })->with('user')->get();

        return view('dashboard/supervisorVams', compact('vams'));
    }

    public function editVam(Vam $vam)
    {
        // اطمینان از اینکه این وام متعلق به کاربر زیرمجموعه مدیر است:
        $supervisorId = $this->supervisorId();
        $supervisors = Supervisor::all();
        $departmans = Departmans::all();

        if ($vam->user->supervisor_id !== $supervisorId) {
            abort(403, 'دسترسی غیرمجاز');
        }

        return view('dashboard/editSupervisorVams', compact('vam', 'supervisors', 'departmans'));
    }

    public function updateVam(Request $request, Vam $vam)
    {
        $supervisorId = $this->supervisorId();

        if ($vam->user->supervisor_id !== $supervisorId) {
            abort(403, 'دسترسی غیرمجاز');
        }

        $request->validate([

            'status' => 'required|in:Pending,Yes,No',
        ]);

        try {
            $vam->update([
                'status' => $request->status,
            ]);

            return redirect()->route('supervisor.vam.index')->with('success', 'درخواست با موفقیت به‌روزرسانی شد.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطایی در ذخیره‌سازی رخ داده است.');
        }
    }

    /**
     * service Requests
     */

    public function serviceRequestsForSupervisor()
    {
        $supervisorId = $this->supervisorId();

        $services = Service::whereHas('user', function ($query) use ($supervisorId) {
            $query->where('supervisor_id', $supervisorId);
        })->with('user')->get();

        return view('dashboard/supervisorServices', compact('services'));
    }

    public function editService(Service $service)
    {
        // اطمینان از اینکه این وام متعلق به کاربر زیرمجموعه مدیر است:
        $supervisorId = $this->supervisorId();
        $supervisors = Supervisor::all();
        $departmans = Departmans::all();

        if ($service->user->supervisor_id !== $supervisorId) {
            abort(403, 'دسترسی غیرمجاز');
        }

        return view('dashboard/editSupervisorServics', compact('service', 'supervisors', 'departmans'));
    }

    public function updateService(Request $request, Service $service)
    {
        $supervisorId = $this->supervisorId();

        if ($service->user->supervisor_id !== $supervisorId) {
            abort(403, 'دسترسی غیرمجاز');
        }
        $request->validate([

            'status' => 'required|in:Pending,Yes,No',
        ]);

        try {
            $service->update([
                'status' => $request->status,
            ]);

            return redirect()->route('supervisor.service.index')->with('success', 'درخواست با موفقیت به‌روزرسانی شد.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطایی در ذخیره‌سازی رخ داده است.');
        }
    }

    // maadiranRequest
    public function maadiranRequestsForSupervisor()
    {
        // شناسه مدیر واحد لاگین شده
        $supervisorId = $this->supervisorId();
        // وام‌هایی که نویسنده‌شان کاربری است که supervisor_id آن برابر با این مقدار است
        $maadirans = Maadiran::whereHas('user', function ($query) use ($supervisorId) {
            $query->where('supervisor_id', $supervisorId);
        })->with('user')->get();

        return view('dashboard/supervisorMaadirans', compact('maadirans'));
    
    }
    public function editMaadiran(Maadiran $maadiran)
    {

        $supervisorId = $this->supervisorId();
        $supervisors = Supervisor::all();
        $departmans = Departmans::all();

        if ($maadiran->user->supervisor_id !== $supervisorId) {
            abort(403, 'دسترسی غیرمجاز');
        }

        return view('dashboard/editSupervisorMaadirans', compact('maadiran', 'supervisors', 'departmans'));
    }

    public function updateMaadiran(Request $request, Maadiran $maadiran)
    {

        $supervisorId = $this->supervisorId();

        if ($maadiran->user->supervisor_id !== $supervisorId) {
            abort(403, 'دسترسی غیرمجاز');
        }
        $request->validate([

            'status' => 'required|in:Pending,Yes,No',
        ]);

        try {
            $maadiran->update([
                'status' => $request->status,
            ]);

            return redirect()->route('supervisor.maadiran.index')->with('success', 'درخواست با موفقیت به‌روزرسانی شد.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطایی در ذخیره‌سازی رخ داده است.');
        }
    }

    // imprestRequest
    public function imprestRequestsForSupervisor()
    {
        $supervisorId = $this->supervisorId();
        // وام‌هایی که نویسنده‌شان کاربری است که supervisor_id آن برابر با این مقدار است
        $imprest = Imprest::whereHas('user', function ($query) use ($supervisorId) {
            $query->where('supervisor_id', $supervisorId);
        })->with('user')->get();

        return view('dashboard/supervisorImprests', compact('imprest'));
    }

    public function editImprest(Imprest $imprest)
    {
        $supervisorId = $this->supervisorId();
        $supervisors = Supervisor::all();
        $departmans = Departmans::all();

        if ($imprest->user->supervisor_id !== $supervisorId) {
            abort(403, 'دسترسی غیرمجاز');
        }

        return view('dashboard/editSupervisorImprests', compact('imprest', 'supervisors', 'departmans'));
    }

    public function updateImprest(Request $request, Imprest $imprest)
    {
        $supervisorId = $this->supervisorId();

        if ($imprest->user->supervisor_id !== $supervisorId) {
            abort(403, 'دسترسی غیرمجاز');
        }

        $request->validate([

            'status' => 'required|in:Pending,Yes,No',
        ]);

        try {
            $imprest->update([
                'status' => $request->status,
            ]);

            return redirect()->route('supervisor.imprest.index')->with('success', 'درخواست با موفقیت به‌روزرسانی شد.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطایی در ذخیره‌سازی رخ داده است.');
        }
    }


    public function index(Request $request)
    {
        $query = Supervisor::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('idCard', 'like', "%$search%");
            });
        }
        $supervisors = $query->latest('supervisors.created_at')->paginate(10);

        $departmans = Departmans::all();
        $supervisorCount = Supervisor::count();
        return view('dashboard/supervisor', compact('supervisors', 'departmans', 'supervisorCount'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => ['required', 'persian_alpha'],
            'idCard' => ['required', 'ir_national_id'],
            'departmans_id' => ['required', 'exists:departmans,id'],

        ], [
            'name.required' => 'نام و نام خانوادگی خود را وارد کنید',
            'idCard.required' => 'کد ملی خود را وارد کنید.'
        ]);

        $supervisor = Supervisor::create($fields);

        return $supervisor ? redirect()->route('supervisor.index')->with('success', '  مدیر واحد با موفقیت اضافه شد') :  redirect()->route('supervisor.index')->with('error', 'خطایی رخ داده است');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $supervisor = Supervisor::find($id);
        $role = Auth::user()->role;
        $departmans = Departmans::all();
        return $supervisor ? view('dashboard.editSupervisor', compact('role', 'supervisor', 'departmans')) : redirect()->route('supervisor.index')->with('error', 'درخواست مورد نظر پیدا نشد.');
    }

    public function update(Request $request, string $id)
    {
        // دریافت رکورد Supervisor با شناسه‌ی مشخص
        $supervisor = Supervisor::find($id);

        // اگر رکورد موجود نیست، خطا می‌دهیم
        if (!$supervisor) {
            return redirect()->route('supervisor.index')->with('error', 'مدیر واحد پیدا نشد.');
        }

        // اعتبارسنجی ورودی‌ها
        $fields = $request->validate([
            'name' => 'required|string',
            'idCard' => 'required|ir_national_id|unique:supervisors,idCard,' . $supervisor->id . ',id',
            'departmans_id' => 'nullable|exists:departmans,id',
        ], [
            'name.required' => 'نام و نام خانوادگی مدیر واحد را وارد کنید',
            'idCard.required' => 'کدملی مدیر واحد وارد شود',
            'idCard.unique' => 'کدملی وارد شده از قبل موجود می باشد.'
        ]);

        // به‌روزرسانی رکورد
        $supervisor->name = $request->input('name');
        $supervisor->idCard = $request->input('idCard');
        $supervisor->departmans_id = $request->input('departmans_id');
        $supervisor->save(); // ذخیره تغییرات در دیتابیس

        // بازگشت به صفحه با پیام موفقیت
        return redirect()->route('supervisor.index')->with('success', 'اطلاعات مدیر واحد با موفقیت ویرایش شد.');
    }

    public function destroy(string $id)
    {
        $supervisor = Supervisor::findOrFail($id);

        // حذف رکورد
        $supervisor->delete();

        // بازگشت به صفحه با پیام موفقیت
        return redirect()->route('supervisor.index')->with('success', 'درخواست مورد نظر با موفقیت حذف گردید');
    }
}
