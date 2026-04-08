<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поиск аспирантов по руководителю</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .card-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .card-header p {
            opacity: 0.9;
            font-size: 14px;
        }

        .card-body {
            padding: 30px;
        }

        .search-form {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #667eea;
            color: white;
        }

        tr:hover {
            background: #f5f5f5;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .alert-info {
            background: #e3f2fd;
            color: #1976d2;
            border-left: 4px solid #1976d2;
        }

        .alert-warning {
            background: #fff3e0;
            color: #ff9800;
            border-left: 4px solid #ff9800;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-writing {
            background: #fff3e0;
            color: #ff9800;
        }

        .badge-pre_defense {
            background: #e3f2fd;
            color: #2196F3;
        }

        .badge-defended {
            background: #e8f5e9;
            color: #4CAF50;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h1>🔍 Поиск аспирантов по научному руководителю</h1>
            <p>Выберите руководителя, чтобы увидеть список его аспирантов</p>
        </div>
        <div class="card-body">
            <form method="POST" action="/aspirants/by-supervisor" class="search-form">
                <div class="form-group">
                    <label for="supervisor_id">👨‍🏫 Научный руководитель</label>
                    <select name="supervisor_id" id="supervisor_id" class="form-control">
                        <option value="">-- Все руководители --</option>
                        <?php foreach ($supervisors as $supervisor): ?>
                            <option value="<?= $supervisor->id ?>" <?= ($selected_supervisor == $supervisor->id) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($supervisor->full_name) ?>
                                <?= $supervisor->academic_degree ? ' (' . htmlspecialchars($supervisor->academic_degree) . ')' : '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">🔍 Найти</button>
                <a href="/aspirants/by-supervisor" class="btn btn-secondary">Сбросить</a>
            </form>

            <?php if ($selected_supervisor): ?>
                <div class="alert alert-info">
                    📊 Найдено аспирантов: <strong><?= count($aspirants) ?></strong>
                </div>
            <?php endif; ?>

            <?php if (count($aspirants) > 0): ?>
                <table>
                    <thead>
                    <tr>
                        <th>ФИО аспиранта</th>
                        <th>Год поступления</th>
                        <th>Тема диссертации</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($aspirants as $aspirant): ?>
                        <tr>
                            <td><?= htmlspecialchars($aspirant->full_name) ?></td>
                            <td><?= $aspirant->enrollment_year ?? '—' ?></td>
                            <td><?= htmlspecialchars($aspirant->dissertation_topic ?? '—') ?></td>
                            <td>
                                <?php
                                $statusLabels = [
                                    'writing' => '<span class="badge badge-writing">📝 Пишется</span>',
                                    'pre_defense' => '<span class="badge badge-pre_defense">📋 Предзащита</span>',
                                    'defended' => '<span class="badge badge-defended">🏆 Защищена</span>'
                                ];
                                echo $statusLabels[$aspirant->status] ?? '—';
                                ?>
                            </td>
                            <td>
                                <a href="/aspirants/edit/<?= $aspirant->id ?>" class="btn-edit">✏️</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <?php if ($selected_supervisor): ?>
                    <div class="alert alert-warning">
                        ⚠️ У выбранного руководителя нет аспирантов.
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        📌 Выберите научного руководителя для отображения списка аспирантов.
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .btn-edit {
        display: inline-block;
        padding: 5px 10px;
        background: #ff9800;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    .btn-edit:hover {
        background: #e68900;
        transform: translateY(-2px);
    }
</style>
</body>
</html>