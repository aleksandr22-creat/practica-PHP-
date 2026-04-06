<?php

namespace Controller;

use Model\Aspirant;
use Model\User;
use Model\Supervisor;
use Src\Request;
use Src\View;

class AspirantsController
{
    // Список аспирантов
    public function index(Request $request): string
    {
        $aspirants = Aspirant::with('user', 'supervisor', 'dissertations')->get();
        return (new View())->render('aspirants.index', ['aspirants' => $aspirants]);
    }

    // Форма добавления
    public function create(Request $request): string
    {
        $users = User::all();
        $supervisors = Supervisor::all();
        return (new View())->render('aspirants.create', [
            'users' => $users,
            'supervisors' => $supervisors
        ]);
    }

    // Сохранение
    public function store(Request $request): void
    {
        Aspirant::create($request->all());
        app()->route->redirect('/aspirants');
    }

    // Форма редактирования
    public function edit(Request $request): string
    {
        $aspirant = Aspirant::find($request->id);
        $users = User::all();
        $supervisors = Supervisor::all();
        return (new View())->render('aspirants.edit', [
            'aspirant' => $aspirant,
            'users' => $users,
            'supervisors' => $supervisors
        ]);
    }

    public function update(Request $request): void
    {
        $aspirant = Aspirant::find($request->id);
        $aspirant->update($request->all());
        app()->route->redirect('/aspirants');
    }

    // Удаление
    public function destroy(Request $request): void
    {
        Aspirant::find($request->id)->delete();
        app()->route->redirect('/aspirants');
    }
}
