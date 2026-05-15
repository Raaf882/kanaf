<?php

use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Students as AdminStudents;
use App\Livewire\Admin\Subjects as AdminSubjects;
use App\Livewire\Admin\Advisors as AdminAdvisors;
use App\Livewire\Advisor\Dashboard as AdvisorDashboard;
use App\Livewire\Student\Home as StudentHome;
use App\Livewire\Student\CareerFuture;
use App\Livewire\Student\CareerPathDetail;
use App\Livewire\Student\CourseDetails;
use Illuminate\Support\Facades\Route;

Route::get('/locale/{lang}', function (string $lang) {
    if (in_array($lang, ['ar', 'en'])) {
        session(['locale' => $lang]);
    }
    return redirect()->back();
})->name('locale');

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route(match (auth()->user()->role) {
            'admin'   => 'admin.dashboard',
            'advisor' => 'advisor.dashboard',
            default   => 'home',
        });
    }
    return view('landing');
})->name('root');

// Landing page — always accessible (even when authenticated)
Route::get('/landing', fn () => view('landing'))->name('landing');

// ── Auth ──────────────────────────────────────────────────────────
Route::get('/login', fn () => view('auth.login'))->name('login');

Route::post('/login', function () {
    $credentials = request()->only('email', 'password');
    if (auth()->attempt($credentials)) {
        $role = auth()->user()->role;
        return redirect()->route(match ($role) {
            'admin'   => 'admin.dashboard',
            'advisor' => 'advisor.dashboard',
            default   => 'home',
        });
    }
    return back()->withErrors(['email' => 'بيانات الدخول غير صحيحة']);
})->name('login.post');

Route::post('/logout', function () {
    auth()->logout();
    return redirect()->route('login');
})->name('logout');

// ── Student ───────────────────────────────────────────────────────
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/home', StudentHome::class)->name('home');
    Route::get('/academic-journey', fn () => view('academic-journey'))->name('academic-journey');
    Route::get('/academic-journey/course/{course}', CourseDetails::class)->name('course-details');
    Route::get('/career-future', CareerFuture::class)->name('career-future');
    Route::get('/career-future/path/{careerPath}', CareerPathDetail::class)->name('career-path-detail');
});

// ── Advisor ───────────────────────────────────────────────────────
Route::middleware(['auth', 'role:advisor'])->group(function () {
    Route::get('/advisor', AdvisorDashboard::class)->name('advisor.dashboard');
});

// ── Admin ─────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin',          AdminDashboard::class)->name('admin.dashboard');
    Route::get('/admin/students', AdminStudents::class)->name('admin.students');
    Route::get('/admin/subjects', AdminSubjects::class)->name('admin.subjects');
    Route::get('/admin/advisors', AdminAdvisors::class)->name('admin.advisors');
});
