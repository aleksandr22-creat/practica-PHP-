<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Аспирантура / Научный отдел</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family:  sans-serif;
            background: #f0f2f5;
            color: #1a1a2e;
        }

        .header {
            background: #1a1a2e ;
            color: white;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }

        .header .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 30px;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            font-size: 32px;
        }

        .logo-text h1 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .logo-text p {
            font-size: 12px;
            opacity: 0.8;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .user-details {
            text-align: right;
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
        }

        .user-role {
            font-size: 11px;
            opacity: 0.7;
        }

        .logout-btn {
            background: rgba(231, 76, 60, 0.9);
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logout-btn:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }

        .nav-menu {
            padding: 12px 0;
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .nav-group {
            position: relative;
            margin: 0 5px;
        }

        .nav-group-title {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
            background: none;
            border: none;
        }

        .nav-group-title:hover {
            background: rgba(255,255,255,0.1);
        }

        .nav-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            min-width: 200px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 100;
        }

        .nav-group:hover .nav-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .nav-dropdown a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            color: #333;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
            border-bottom: 1px solid #eee;
        }

        .nav-dropdown a:last-child {
            border-bottom: none;
        }

        .nav-dropdown a:hover {
            background: #f8f9fa;
            padding-left: 25px;
            color: #1a1a2e;
        }

        .nav-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background: #FFFFFF26;
        }

        .nav-link-highlight {
            background: #FFFFFF26;
        }

        .main-container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 30px;
            min-height: calc(100vh - 180px);
        }

        .footer {
            background: #1a1a2e;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
            font-size: 13px;
            opacity: 0.8;
        }
    </style>
</head>
<body>
<?php $user = \Src\Auth\Auth::user(); ?>

<?php
$current_uri = $_SERVER['REQUEST_URI'] ?? '';
$hide_header_routes = ['/login', '/signup'];
$should_hide_header = in_array($current_uri, $hide_header_routes);

if ($user && !$should_hide_header):
    ?>
    <header class="header">
        <div class="container">
            <div class="header-top">
                <div class="logo">
                    <div class="logo-icon"></div>
                    <div class="logo-text">
                        <h1>Аспирантура / Научный отдел</h1>
                        <p>Управление научной деятельностью</p>
                    </div>
                </div>
                <div class="user-info">
                    <div class="user-details">
                        <div class="user-name"><?= htmlspecialchars($user->name ?? 'Пользователь') ?></div>
                        <div class="user-role">
                            <?php if ($user->isAdmin()): ?>Администратор
                            <?php elseif ($user->isScienceOfficer()): ?>Сотрудник научного отдела
                            <?php else: ?>Аспирант
                            <?php endif; ?>
                        </div>
                    </div>
                    <a href="/logout" class="logout-btn">
                        <span></span> Выход
                    </a>
                </div>
            </div>
            <nav class="nav-menu" id="navMenu">

                <a href="/hello" class="nav-link">
                    <span></span> Главная
                </a>

                <div class="nav-group">
                    <button class="nav-group-title">
                        <span></span> Аспиранты
                        <span></span>
                    </button>
                    <div class="nav-dropdown">
                        <a href="/aspirants"> Список аспирантов</a>
                        <a href="/aspirants/create"> Добавить аспиранта</a>
                        <a href="/aspirants/by-supervisor">Поиск по руководителю</a>
                    </div>
                </div>

                <div class="nav-group">
                    <button class="nav-group-title">
                        <span></span> Руководители
                        <span></span>
                    </button>
                    <div class="nav-dropdown">
                        <a href="/supervisors"> Список руководителей</a>
                        <a href="/supervisors/create"> Добавить руководителя</a>
                    </div>
                </div>

                <div class="nav-group">
                    <button class="nav-group-title">
                        <span></span> Диссертации
                        <span></span>
                    </button>
                    <div class="nav-dropdown">
                        <a href="/dissertations"> Список диссертаций</a>
                        <a href="/dissertations/create"> Добавить диссертацию</a>
                    </div>
                </div>

                <div class="nav-group">
                    <button class="nav-group-title">
                        <span></span> Публикации
                        <span></span>
                    </button>
                    <div class="nav-dropdown">
                        <a href="/publications">Список публикаций</a>
                        <a href="/publications/create">Добавить публикацию</a>
                    </div>
                </div>

                <div class="nav-group">
                    <button class="nav-group-title">
                        <span></span> Отчёты
                        <span></span>
                    </button>
                    <div class="nav-dropdown">
                        <a href="/reports/defenses"> Отчёт по защитам</a>
                    </div>
                </div>

                <?php if ($user->isAdmin()): ?>
                    <div class="nav-group">
                        <button class="nav-group-title">
                            <span></span>
                            <span></span>
                        </button>
                        <div class="nav-dropdown">
                            <a href="/admin/users"> Управление пользователями</a>
                            <a href="/admin/add-user"> Добавить пользователя</a>
                        </div>
                    </div>
                <?php endif; ?>
            </nav>
        </div>
    </header>
<?php endif; ?>

<main class="main-container">
    <?= $content ?? '' ?>
</main>

<?php if ($user && !in_array($current_route ?? '', ['login', 'signup'])): ?>
    <footer class="footer">
    </footer>
<?php endif; ?>

<script>
    function toggleMenu() {
        const menu = document.getElementById('navMenu');
        menu.classList.toggle('active');
    }
</script>
</body>
</html>