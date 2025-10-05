<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$params):Response
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/'); // یا abort(403)
        }

        // حالت پیش‌فرض: any (هرکدام کافیست)
        $mode = 'any';

        // اگر پارامتر اول 'any' یا 'all' باشه، اون رو جدا می‌کنیم
        if (!empty($params) && in_array(strtolower($params[0]), ['any', 'all'])) {
            $mode = strtolower(array_shift($params));
        }

        // اگر همه نقش‌ها به صورت یک رشته با | یا , فرستاده شده باشند، آن را باز می‌کنیم
        if (count($params) === 1 && is_string($params[0])) {
            $str = $params[0];
            if (strpos($str, '|') !== false) {
                $params = preg_split('/\|/', $str);
            } elseif (strpos($str, ',') !== false) {
                $params = preg_split('/,/', $str);
            } else {
                $params = [$str];
            }
        }

        // پاکسازی فاصله‌ها
        $roles = array_map(fn($r) => trim($r), $params);
        $roles = array_filter($roles, fn($r) => $r !== '');

        if (empty($roles)) {
            // هیچ نقشی داده نشده — دسترسی پیش‌فرض: رد شود یا اجازه (بستگی به سیاست شما)
            return redirect('/');
        }

        // از متدهای مدل User استفاده می‌کنیم (پیشنهاد شده در بخش 1)
        if ($mode === 'any') {
            if ($user->hasAnyRole($roles)) {
                return $next($request);
            }
        } else { // all
            if ($user->hasAllRoles($roles)) {
                return $next($request);
            }
        }

        return redirect('/'); // یا abort(403, 'Access denied');
    }
}
