<!DOCTYPE html>
<html>
<head>
    <title>Деканат - Научная деятельность</title>
    <style>
        body { font-family: Arial; margin: 0; padding: 20px; }
        nav { background: #333; padding: 10px; margin-bottom: 20px; }
        nav a { color: white; margin-right: 15px; text-decoration: none; }
        .container { max-width: 1200px; margin: auto; }
        .btn { background: #007bff; color: white; padding: 5px 10px; text-decoration: none; display: inline-block; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        .message { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
<?php $user = \Src\Auth\Auth::user(); ?>
<?php if ($user): ?>
    <nav>
        <a href="/hello">Главная</a>

        <strong>Публикации:</strong>
        <a href="/publications">Список</a>
        <a href="/publications/create">Добавить</a>

        <strong>Диссертации:</strong>
        <a href="/dissertations">Список</a>
        <a href="/dissertations/create">Добавить</a>

        <strong>Аспиранты:</strong>
        <a href="/aspirants">Список</a>
        <a href="/aspirants/create">Добавить</a>

        <strong>Руководители:</strong>
        <a href="/supervisors">Список</a>
        <a href="/supervisors/create">Добавить</a>

        <a href="/reports/defenses">Отчёт по защитам</a>
        <a href="/aspirants/by-supervisor">Поиск по руководителю</a>

        <?php if ($user && $user->isAdmin()): ?>
            <strong>Админка:</strong>
            <a href="/admin/users">Пользователи</a>
            <a href="/admin/add-user">Добавить пользователя</a>
        <?php endif; ?>

        <a href="/logout" style="float:right">Выход (<?= $user->name ?? 'Гость' ?>)</a>
    </nav>

<?php endif; ?>
<div class="container">
    <?= $content ?? '' ?>
</div>
</body>
</html>