<?php

namespace Controller;

use Model\Publication;
use Model\Aspirants;
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
        $aspirants = Aspirants::all();
        $supervisors = Supervisor::all();
        return (new View())->render('publications.create', [
            'aspirants' => $aspirants,
            'supervisors' => $supervisors
        ]);
    }

    // Сохранение новой публикации
    public function store(Request $request): void
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isScienceOfficer()) {
            app()->route->redirect('/');
        }

        // Получаем все данные из запроса
        $data = $request->all();

        // Получаем ID аспирантов и руководителей
        $aspirantIds = $data['aspirant_ids'] ?? [];
        $supervisorIds = $data['supervisor_ids'] ?? [];

        // Удаляем эти ключи из данных для публикации
        unset($data['aspirant_ids'], $data['supervisor_ids']);

        // Создаем публикацию
        $publication = Publication::create($data);

        // Привязываем аспирантов (если есть)
        if (!empty($aspirantIds)) {
            $publication->aspirants()->attach($aspirantIds);
        }

        // Привязываем научных руководителей (если есть)
        if (!empty($supervisorIds)) {
            $publication->supervisors()->attach($supervisorIds);
        }

        app()->route->redirect('/publications');
    }

    // Форма редактирования - получаем id из параметра маршрута
    public function edit($id): string
    {
        $publication = Publication::with('aspirants', 'supervisors')->find($id);

        if (!$publication) {
            app()->route->redirect('/publications');
        }

        $aspirants = Aspirants::all();
        $supervisors = Supervisor::all();

        return (new View())->render('publications.edit', [
            'publication' => $publication,
            'aspirants' => $aspirants,
            'supervisors' => $supervisors
        ]);
    }

    // Обновление публикации - ИСПРАВЛЕНО: сначала $id, потом $request
    public function update($id, Request $request): void
    {
        $publication = Publication::find($id);

        if (!$publication) {
            app()->route->redirect('/publications');
        }

        $data = $request->all();

        $aspirantIds = $data['aspirant_ids'] ?? [];
        $supervisorIds = $data['supervisor_ids'] ?? [];

        unset($data['aspirant_ids'], $data['supervisor_ids']);

        $publication->update($data);
        $publication->aspirants()->sync($aspirantIds);
        $publication->supervisors()->sync($supervisorIds);

        app()->route->redirect('/publications');
    }

    // Удаление публикации - получаем id из параметра маршрута
    public function destroy($id): void
    {
        $publication = Publication::find($id);

        if ($publication) {
            $publication->aspirants()->detach();
            $publication->supervisors()->detach();
            $publication->delete();
        }

        app()->route->redirect('/publications');
    }
}