<?php

namespace Controller;

use Model\User;
use Src\Request;
use Src\View;
use Src\Auth\Auth;

class AdminController
{
    public function users(Request $request): string
    {
        if (!Auth::user()->isAdmin()) {
            app()->route->redirect('/hello');
        }

        $users = User::with('role')->get();
        return (new View())->render('admin.users', ['users' => $users]);
    }

    public function addUser(Request $request): string
    {
        if (!Auth::user()->isAdmin()) {
            app()->route->redirect('/hello');
        }

        if ($request->method === 'POST') {
            User::create($request->all());
            app()->route->redirect('/admin/users');
        }
        return (new View())->render('admin.add_user');
    }
}