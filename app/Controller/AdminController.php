<?php

namespace Controller;

use Src\View;
use Src\Request;
use Model\User;
use Model\Role;

class AdminController
{
    // Список всех пользователей
    public function users(Request $request): string
    {
        $users = User::with('role')->get();
        return new View('admin.users', ['users' => $users]);
    }

    // Форма добавления пользователя + обработка
    public function addUser(Request $request): string
    {
        if ($request->method === 'POST') {
            // Валидация
            $errors = [];

            if (empty($request->get('name'))) {
                $errors['name'] = 'Имя обязательно';
            }

            if (empty($request->get('login'))) {
                $errors['login'] = 'Логин обязателен';
            } elseif (User::where('login', $request->get('login'))->exists()) {
                $errors['login'] = 'Такой логин уже существует';
            }

            if (empty($request->get('password'))) {
                $errors['password'] = 'Пароль обязателен';
            } elseif (strlen($request->get('password')) < 4) {
                $errors['password'] = 'Пароль должен быть не менее 4 символов';
            }

            if (empty($request->get('role_id'))) {
                $errors['role'] = 'Выберите роль';
            }

            if (empty($errors)) {
                $user = User::create([
                    'name' => $request->get('name'),
                    'login' => $request->get('login'),
                    'password' => md5($request->get('password')),
                    'role_id' => $request->get('role_id')
                ]);

                if ($user) {
                    app()->route->redirect('/admin/users');
                }
            }

            $roles = Role::all();
            return new View('admin.add-user', [
                'errors' => $errors,
                'roles' => $roles,
                'data' => $request->all()
            ]);
        }

        $roles = Role::all();
        return new View('admin.add-user', ['roles' => $roles]);
    }
}