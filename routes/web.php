<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CriterionController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\AqarController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->prefix('iqac')->name('criteria.')->group(function () {
    Route::get('/criteria', [CriterionController::class, 'index'])->name('index');
    Route::get('/criteria/{criterion}', [CriterionController::class, 'show'])->name('show');
    Route::post('/criteria/{criterion}/key-indicator', [CriterionController::class, 'storeKeyIndicator'])->name('key-indicator.store');
    Route::put('/criteria/{criterion}/key-indicator/{keyIndicator}', [CriterionController::class, 'updateKeyIndicator'])->name('key-indicator.update');
    Route::delete('/criteria/{criterion}/key-indicator/{keyIndicator}', [CriterionController::class, 'destroyKeyIndicator'])->name('key-indicator.destroy');
    Route::post('/criteria/{criterion}/key-indicator/{keyIndicator}/metric', [CriterionController::class, 'storeMetric'])->name('metric.store');
    Route::put('/criteria/{criterion}/key-indicator/{keyIndicator}/metric/{metric}', [CriterionController::class, 'updateMetric'])->name('metric.update');
    Route::post('/criteria/{criterion}/key-indicator/{keyIndicator}/metric/{metric}/documents', [CriterionController::class, 'storeMetricDocument'])->name('metric.document.store');
    Route::delete('/criteria/{criterion}/key-indicator/{keyIndicator}/metric/{metric}', [CriterionController::class, 'destroyMetric'])->name('metric.destroy');
});

Route::middleware(['auth'])->prefix('iqac')->name('activities.')->group(function () {
    Route::get('/activities', [ActivityController::class, 'index'])->name('index');
    Route::get('/activities/create', [ActivityController::class, 'create'])->name('create');
    Route::post('/activities', [ActivityController::class, 'store'])->name('store');
    Route::get('/activities/{activity}', [ActivityController::class, 'show'])->name('show');
    Route::get('/activities/{activity}/edit', [ActivityController::class, 'edit'])->name('edit');
    Route::put('/activities/{activity}', [ActivityController::class, 'update'])->name('update');
    Route::delete('/activities/{activity}', [ActivityController::class, 'destroy'])->name('destroy');
    Route::get('/api/key-indicators/{criterionId}', [ActivityController::class, 'getKeyIndicators'])->name('key-indicators');
    Route::get('/api/metrics/{keyIndicatorId}', [ActivityController::class, 'getMetrics'])->name('metrics');
});

Route::middleware(['auth'])->prefix('iqac')->name('documents.')->group(function () {
    Route::get('/documents', [DocumentController::class, 'index'])->name('index');
    Route::post('/documents', [DocumentController::class, 'store'])->name('store');
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('download');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('destroy');
    Route::delete('/metric-documents/{document}', [CriterionController::class, 'destroyMetricDocument'])->name('metric.destroy');
});

Route::middleware(['auth'])->prefix('iqac')->name('meetings.')->group(function () {
    Route::get('/meetings', [MeetingController::class, 'index'])->name('index');
    Route::get('/meetings/create', [MeetingController::class, 'create'])->name('create');
    Route::post('/meetings', [MeetingController::class, 'store'])->name('store');
    Route::get('/meetings/{meeting}', [MeetingController::class, 'show'])->name('show');
    Route::get('/meetings/{meeting}/edit', [MeetingController::class, 'edit'])->name('edit');
    Route::put('/meetings/{meeting}', [MeetingController::class, 'update'])->name('update');
    Route::delete('/meetings/{meeting}', [MeetingController::class, 'destroy'])->name('destroy');
    Route::put('/meetings/{meeting}/attendance', [MeetingController::class, 'updateAttendance'])->name('attendance.update');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::get('/departments/create', [DepartmentController::class, 'create'])->name('departments.create');
    Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
    Route::get('/departments/{department}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
    Route::put('/departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
});

Route::middleware(['auth'])->prefix('iqac')->name('feedback.')->group(function () {
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('index');
    Route::get('/feedback/create', [FeedbackController::class, 'create'])->name('create');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('store');
    Route::get('/feedback/{survey}', [FeedbackController::class, 'show'])->name('show');
    Route::get('/feedback/{survey}/edit', [FeedbackController::class, 'edit'])->name('edit');
    Route::put('/feedback/{survey}', [FeedbackController::class, 'update'])->name('update');
    Route::delete('/feedback/{survey}', [FeedbackController::class, 'destroy'])->name('destroy');
    Route::get('/feedback/{survey}/export', [FeedbackController::class, 'exportResponses'])->name('export');
});

Route::middleware(['auth'])->prefix('iqac')->name('feedback.')->group(function () {
    Route::get('/survey/{survey}/respond', [FeedbackController::class, 'respond'])->name('respond');
    Route::post('/survey/{survey}/submit', [FeedbackController::class, 'submitResponse'])->name('submit');
    Route::get('/survey/thank-you', [FeedbackController::class, 'thankyou'])->name('thankyou');
});

Route::middleware(['auth'])->prefix('iqac/aqar')->name('aqar.')->group(function () {
    Route::get('/', [AqarController::class, 'index'])->name('index');
    Route::get('/create', [AqarController::class, 'create'])->name('create');
    Route::post('/', [AqarController::class, 'store'])->name('store');
    Route::get('/{report}', [AqarController::class, 'show'])->name('show');
    Route::get('/{report}/edit', [AqarController::class, 'edit'])->name('edit');
    Route::put('/{report}', [AqarController::class, 'update'])->name('update');
    Route::delete('/{report}', [AqarController::class, 'destroy'])->name('destroy');
    Route::get('/{report}/pdf', [AqarController::class, 'generatePdf'])->name('pdf');
});

require __DIR__.'/auth.php';
