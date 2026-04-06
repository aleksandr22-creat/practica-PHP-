<?php

namespace Controller;

use Model\Supervisor;
use Src\Request;
use Src\View;

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
        Supervisor::create($request->all());
        app()->route->redirect('/supervisors');
    }

    // Форма редактирования
    public function edit(Request $request): string
    {
        $supervisor = Supervisor::find($request->id);
        return (new View())->render('supervisors.edit', ['supervisor' => $supervisor]);
    }

    // Обновление
    public function update(Request $request): void
    {
        $supervisor = Supervisor::find($request->id);
        $supervisor->update($request->all());
        app()->route->redirect('/supervisors');
    }

    // Удаление
    public function destroy(Request $request): void
    {
        Supervisor::find($request->id)->delete();
        app()->route->redirect('/supervisors');
    }
}