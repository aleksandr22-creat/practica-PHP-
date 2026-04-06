<?php

namespace Controller;

use Model\Publication;
use Model\Aspirant;
use Model\Supervisor;
use Src\Request;
use Src\View;
use Src\Auth\Auth;

class PublicationsController
{
    // Список публикаций
    public function index(Request $request): string
    {
        $publications = Publication::with('aspirants', 'supervisors')->get();
        return (new View())->render('publications.index', ['publications' => $publications]);
    }

    // Форма добавления
    public function create(Request $request): string
    {
        $aspirants = Aspirant::all();
        $supervisors = Supervisor::all();
        return (new View())->render('publications.create', [
            'aspirants' => $aspirants,
            'supervisors' => $supervisors
        ]);
    }

    // Сохранение новой публикации
    public function store(Request $request): void
    {
        $publication = Publication::create($request->all());

        // Привязываем аспирантов
        if ($request->has('aspirant_ids')) {
            $publication->aspirants()->attach($request->aspirant_ids);
        }

        // Привязываем руководителей
        if ($request->has('supervisor_ids')) {
            $publication->supervisors()->attach($request->supervisor_ids);
        }

        app()->route->redirect('/publications');
    }

    // Форма редактирования
    public function edit(Request $request): string
    {
        $publication = Publication::find($request->id);
        $aspirants = Aspirant::all();
        $supervisors = Supervisor::all();

        return (new View())->render('publications.edit', [
            'publication' => $publication,
            'aspirants' => $aspirants,
            'supervisors' => $supervisors
        ]);
    }

    // Обновление публикации
    public function update(Request $request): void
    {
        $publication = Publication::find($request->id);
        $publication->update($request->all());

        // Обновляем связи
        $publication->aspirants()->sync($request->aspirant_ids ?? []);
        $publication->supervisors()->sync($request->supervisor_ids ?? []);

        app()->route->redirect('/publications');
    }

    // Удаление публикации
    public function destroy(Request $request): void
    {
        $publication = Publication::find($request->id);
        $publication->aspirants()->detach();
        $publication->supervisors()->detach();
        $publication->delete();

        app()->route->redirect('/publications');
    }
}