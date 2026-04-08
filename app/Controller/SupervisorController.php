<?php

namespace Controller;

use Model\Supervisor;
use Src\Request;
use Src\View;
use Src\Auth\Auth;

class SupervisorController
{
    // Список руководителей
    public function index(Request $request): string
    {
        $supervisors = Supervisor::with('aspirants')->get();
        return (new View())->render('supervisors.index', ['supervisors' => $supervisors]);
    }

    // Форма добавления
    public function create(Request $request): string
    {
        return (new View())->render('supervisors.create');
    }

    // Сохранение
    public function store(Request $request): void
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isScienceOfficer()) {
            app()->route->redirect('/');
        }

        Supervisor::create($request->all());
        app()->route->redirect('/supervisors');
    }

    // Форма редактирования - получаем id из параметра маршрута
    public function edit($id): string
    {
        $supervisor = Supervisor::find($id);

        if (!$supervisor) {
            app()->route->redirect('/supervisors');
        }

        // ПРОВЕРЬТЕ: правильно ли передается переменная
        return (new View())->render('supervisors.edit', ['supervisor' => $supervisor]);
    }

    // Обновление - сначала id, потом Request
    public function update($id, Request $request): void
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isScienceOfficer()) {
            app()->route->redirect('/');
        }

        $supervisor = Supervisor::find($id);

        if (!$supervisor) {
            app()->route->redirect('/supervisors');
        }

        $supervisor->update($request->all());
        app()->route->redirect('/supervisors');
    }

    // Удаление - получаем id из параметра маршрута
    public function destroy($id): void
    {
        if (!Auth::user()->isAdmin()) {
            app()->route->redirect('/');
        }

        $supervisor = Supervisor::find($id);

        if ($supervisor) {
            $supervisor->delete();
        }

        app()->route->redirect('/supervisors');
    }
}