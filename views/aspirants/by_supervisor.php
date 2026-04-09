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
            font-family: Arial, sans-serif;
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
            background: black;
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

        .primary {
            background:black;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }


        .secondary {
            background:red;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
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
            background: black;
            color: white;
        }
        .edit{
            display: inline-block;
            padding: 5px 10px;
            background: #ff0000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h1> Поиск аспирантов по научному руководителю</h1>
            <p>Выберите руководителя, чтобы увидеть список его аспирантов</p>
        </div>
        <div class="card-body">
            <form method="POST" action="/aspirants/by-supervisor" class="search-form">
                <div class="form-group">
                    <label for="supervisor_id">Научный руководитель</label>
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
                <button type="submit" class="primary">Найти</button>
                <a href="/aspirants/by-supervisor" class="secondary">Сбросить</a>
            </form>

            <?php if ($selected_supervisor): ?>
                <div class="info">
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
                                    'writing' => '<span class="badge badge-writing">Пишется</span>',
                                    'pre_defense' => '<span class="badge badge-pre_defense">Предзащита</span>',
                                    'defended' => '<span class="badge badge-defended">Защищена</span>'
                                ];
                                echo $statusLabels[$aspirant->status] ?? '—';
                                ?>
                            </td>
                            <td>
                                <a href="/aspirants/edit/<?= $aspirant->id ?>" class="edit">редактировать</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <?php if ($selected_supervisor): ?>
                    <div class="warning">
                        У выбранного руководителя нет аспирантов.
                    </div>
                <?php else: ?>
                    <div class="info">
                        Выберите научного руководителя для отображения списка аспирантов.
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>