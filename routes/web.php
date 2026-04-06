<?php

use Src\Route;

Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);

// Защищённые маршруты (с middleware 'auth')
Route::add('GET', '/hello', [Controller\Site::class, 'hello'])->middleware('auth');

// Отчёт по защитам
Route::add(['GET', 'POST'], '/reports/defenses', [Controller\DefenseReportController::class, 'show'])->middleware('auth');

// Поиск аспирантов по руководителю
Route::add(['GET', 'POST'], '/aspirants/by-supervisor', [Controller\AspirantsController::class, 'findBySupervisor'])->middleware('auth');

// Админские маршруты (проверка внутри контроллера)
Route::add('GET', '/admin/users', [Controller\AdminController::class, 'users'])->middleware('auth');
Route::add(['GET', 'POST'], '/admin/add-user', [Controller\AdminController::class, 'addUser'])->middleware('auth');
Route::add('GET', '/publications', [Controller\PublicationsController::class, 'index'])->middleware('auth');
Route::add('GET', '/publications/create', [Controller\PublicationsController::class, 'create'])->middleware('auth');
Route::add('POST', '/publications/store', [Controller\PublicationsController::class, 'store'])->middleware('auth');
Route::add('GET', '/publications/edit/{id}', [Controller\PublicationsController::class, 'edit'])->middleware('auth');
Route::add('POST', '/publications/update/{id}', [Controller\PublicationsController::class, 'update'])->middleware('auth');
Route::add('GET', '/publications/destroy/{id}', [Controller\PublicationsController::class, 'destroy'])->middleware('auth');

// ============ ДИССЕРТАЦИИ ============
Route::add('GET', '/dissertations', [Controller\DissertationController::class, 'index'])->middleware('auth');
Route::add('GET', '/dissertations/create', [Controller\DissertationController::class, 'create'])->middleware('auth');
Route::add('POST', '/dissertations/store', [Controller\DissertationController::class, 'store'])->middleware('auth');
Route::add('GET', '/dissertations/edit/{id}', [Controller\DissertationController::class, 'edit'])->middleware('auth');
Route::add('POST', '/dissertations/update/{id}', [Controller\DissertationController::class, 'update'])->middleware('auth');
Route::add('GET', '/dissertations/destroy/{id}', [Controller\DissertationController::class, 'destroy'])->middleware('auth');

// ============ АСПИРАНТЫ ============
Route::add('GET', '/aspirants', [Controller\AspirantsController::class, 'index'])->middleware('auth');
Route::add('GET', '/aspirants/create', [Controller\AspirantsController::class, 'create'])->middleware('auth');
Route::add('POST', '/aspirants/store', [Controller\AspirantsController::class, 'store'])->middleware('auth');
Route::add('GET', '/aspirants/edit/{id}', [Controller\AspirantsController::class, 'edit'])->middleware('auth');
Route::add('POST', '/aspirants/update/{id}', [Controller\AspirantsController::class, 'update'])->middleware('auth');
Route::add('GET', '/aspirants/destroy/{id}', [Controller\AspirantsController::class, 'destroy'])->middleware('auth');

// ============ НАУЧНЫЕ РУКОВОДИТЕЛИ ============
Route::add('GET', '/supervisors', [Controller\SupervisorController::class, 'index'])->middleware('auth');
Route::add('GET', '/supervisors/create', [Controller\SupervisorController::class, 'create'])->middleware('auth');
Route::add('POST', '/supervisors/store', [Controller\SupervisorController::class, 'store'])->middleware('auth');
Route::add('GET', '/supervisors/edit/{id}', [Controller\SupervisorController::class, 'edit'])->middleware('auth');
Route::add('POST', '/supervisors/update/{id}', [Controller\SupervisorController::class, 'update'])->middleware('auth');
Route::add('GET', '/supervisors/destroy/{id}', [Controller\SupervisorController::class, 'destroy'])->middleware('auth');