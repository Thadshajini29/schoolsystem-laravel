<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $userRole = $request->user()->role;

        // ---------------------------------------------------------------------
        // Check Required Roles (if any specified in route)
        // ---------------------------------------------------------------------
        if (!empty($roles)) {
            $hasRole = false;
            foreach ($roles as $role) {
                if ($userRole === $role) {
                    $hasRole = true;
                    break;
                }
            }
            if (!$hasRole) {
                // Return immediate redirect instead of 403
                if ($userRole === 'student' || $userRole === 'teacher') {
                    return redirect()->route('students.index');
                }
                return redirect()->route('dashboard');
            }
        }

        // ---------------------------------------------------------------------
        // Strict Student Redirection (if access is permitted by middleware 
        // group, but explicitly blocked by specific actions)
        // ---------------------------------------------------------------------
        if ($userRole === 'student') {
            $blockedRoutes = [
                'students.create', 'students.edit', 'students.update', 'students.destroy',
                'grades.create', 'grades.edit', 'grades.update', 'grades.destroy',
                'subjects.create', 'subjects.edit', 'subjects.update', 'subjects.destroy',
                'teachers.create', 'teachers.edit', 'teachers.update', 'teachers.destroy',
                'subjects.manage', 'grades.add_subjects', 'students.add_subjects', 'students.store_subjects', 'grades.store_subjects'
            ];
            if ($request->routeIs($blockedRoutes)) {
                return redirect()->route('students.index');
            }
        }

        // ---------------------------------------------------------------------
        // Strict Teacher Redirection
        // ---------------------------------------------------------------------
        if ($userRole === 'teacher') {
            $teacherBlocked = [
                'grades.create', 'grades.edit', 'grades.update', 'grades.destroy',
                'subjects.create', 'subjects.edit', 'subjects.update', 'subjects.destroy',
                'teachers.create', 'teachers.edit', 'teachers.update', 'teachers.destroy',
                'subjects.manage',
            ];
            if ($request->routeIs($teacherBlocked)) {
                return redirect()->route('students.index');
            }
        }

        return $next($request);
    }
}
