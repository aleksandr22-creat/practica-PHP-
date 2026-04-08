<?php

namespace Controller;

use Model\Dissertation;
use Model\Aspirants;
use Src\Request;
use Src\View;
use Src\Auth\Auth;

class DissertationController
{
    // Список диссертаций
    public function index(Request $request): string
    {
        $dissertations = Dissertation::with('aspirant')->get();
        return (new View())->render('dissertations.index', ['dissertations' => $dissertations]);
    }

    // Форма добавления
    public function create(Request $request): string
    {
        $aspirants = Aspirants::all();
        return (new View())->render('dissertations.create', ['aspirants' => $aspirants]);
    }

    // Сохранение
    public function store(Request $request): void
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isScienceOfficer()) {
            app()->route->redirect('/');
        }

        Dissertation::create($request->all());
        app()->route->redirect('/dissertations');
    }

    // Форма редактирования - получаем id из параметра маршрута
    public function edit($id): string
    {
        $dissertation = Dissertation::with('aspirant')->find($id);

        if (!$dissertation) {
            app()->route->redirect('/dissertations');
        }

        $aspirants = Aspirants::all();
        return (new View())->render('dissertations.edit', [
            'dissertation' => $dissertation,
            'aspirants' => $aspirants
        ]);
    }

    // Обновление - сначала id, потом Request
    public function update($id, Request $request): void
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isScienceOfficer()) {
            app()->route->redirect('/');
        }

        $dissertation = Dissertation::find($id);

        if (!$dissertation) {
            app()->route->redirect('/dissertations');
        }

        $dissertation->update($request->all());
        app()->route->redirect('/dissertations');
    }

    // Удаление - получаем id из параметра маршрута
    public function destroy($id): void
    {
        if (!Auth::user()->isAdmin()) {
            app()->route->redirect('/');
        }

        $dissertation = Dissertation::find($id);

        if ($dissertation) {
            $dissertation->delete();
        }

        app()->route->redirect('/dissertations');
    }
}