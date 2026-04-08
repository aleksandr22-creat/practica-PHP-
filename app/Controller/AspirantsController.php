<?php

namespace Controller;

use Model\Aspirants;
use Model\Supervisor;
use Src\Request;
use Src\View;
use Src\Auth\Auth;

class AspirantsController
{
    // Список аспирантов
    public function index(): string
    {
        $aspirants = Aspirants::with('supervisor')->get();
        return (new View())->render('aspirants.index', ['aspirants' => $aspirants]);
    }

    // Форма создания аспиранта
    public function create(): string
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isScienceOfficer()) {
            app()->route->redirect('/');
        }

        $supervisors = Supervisor::all();
        return (new View())->render('aspirants.create', ['supervisors' => $supervisors]);
    }

    // Сохранение аспиранта
    public function store(Request $request): void
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isScienceOfficer()) {
            app()->route->redirect('/');
        }

        $data = $request->all();

        // Преобразуем пустую строку в NULL для supervisor_id
        if (empty($data['supervisor_id'])) {
            $data['supervisor_id'] = null;
        }

        Aspirants::create($data);
        app()->route->redirect('/aspirants');
    }

    // Форма редактирования аспиранта (принимаем id из маршрута)
    public function edit($id): string
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isScienceOfficer()) {
            app()->route->redirect('/');
        }

        $aspirant = Aspirants::find($id);

        if (!$aspirant) {
            app()->route->redirect('/aspirants');
        }

        $supervisors = Supervisor::all();

        return (new View())->render('aspirants.edit', [
            'aspirant' => $aspirant,
            'supervisors' => $supervisors
        ]);
    }

    // Обновление аспиранта (принимаем id из маршрута)
    public function update(Request $request, $id): void
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isScienceOfficer()) {
            app()->route->redirect('/');
        }

        $aspirant = Aspirants::find($id);

        if (!$aspirant) {
            app()->route->redirect('/aspirants');
        }

        $data = $request->all();

        // Преобразуем пустую строку в NULL для supervisor_id
        if (empty($data['supervisor_id'])) {
            $data['supervisor_id'] = null;
        }

        $aspirant->update($data);
        app()->route->redirect('/aspirants');
    }

    // Удаление аспиранта
    public function destroy($id): void
    {
        if (!Auth::user()->isAdmin()) {
            app()->route->redirect('/');
        }

        $aspirant = Aspirants::find($id);

        if ($aspirant) {
            $aspirant->delete();
        }

        app()->route->redirect('/aspirants');
    }

    // Поиск аспирантов по руководителю
    // Поиск аспирантов по руководителю
    public function findBySupervisor(Request $request): string
    {
        $supervisorId = $request->all()['supervisor_id'] ?? null;
        $aspirants = Aspirants::with('supervisor');

        if ($supervisorId) {
            $aspirants = $aspirants->where('supervisor_id', $supervisorId);
        }

        $aspirants = $aspirants->get();
        $supervisors = Supervisor::all();

        // Убедитесь, что путь к шаблону правильный
        return (new View())->render('aspirants.by_supervisor', [
            'aspirants' => $aspirants,
            'supervisors' => $supervisors,
            'selected_supervisor' => $supervisorId
        ]);
    }
}