<?php

namespace Controller;

use Model\Dissertation;
use Model\Aspirant;
use Src\Request;
use Src\View;

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
        $aspirants = Aspirant::all();
        return (new View())->render('dissertations.create', ['aspirants' => $aspirants]);
    }

    // Сохранение
    public function store(Request $request): void
    {
        Dissertation::create($request->all());
        app()->route->redirect('/dissertations');
    }

    // Форма редактирования
    public function edit(Request $request): string
    {
        $dissertation = Dissertation::find($request->id);
        $aspirants = Aspirant::all();
        return (new View())->render('dissertations.edit', [
            'dissertation' => $dissertation,
            'aspirants' => $aspirants
        ]);
    }

    // Обновление
    public function update(Request $request): void
    {
        $dissertation = Dissertation::find($request->id);
        $dissertation->update($request->all());
        app()->route->redirect('/dissertations');
    }

    // Удаление
    public function destroy(Request $request): void
    {
        Dissertation::find($request->id)->delete();
        app()->route->redirect('/dissertations');
    }
}