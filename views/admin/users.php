<style>
    .users-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .users-table th, .users-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }
    .users-table th {
        background: #1a1a2e;
        color: white;
        font-weight: 600;
    }
    .users-table tr:hover {
        background: #f8f9fa;
    }
    .role-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .role-admin { background: #e74c3c; color: white; }
    .role-officer { background: #3498db; color: white; }
    .role-user { background: #95a5a6; color: white; }
    .btn-add {
        display: inline-block;
        background: #1a1a2e;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        margin-bottom: 20px;
    }
    .btn-add:hover {
        background: #2c2c54;
    }
</style>

<div style="max-width: 1200px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>👥 Управление пользователями</h2>
        <a href="/admin/add-user" class="btn-add">➕ Добавить пользователя</a>
    </div>

    <?php if (isset($users) && count($users) > 0): ?>
        <table class="users-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Логин</th>
                <th>Роль</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user->id ?></td>
                    <td><?= htmlspecialchars($user->name) ?></td>
                    <td><?= htmlspecialchars($user->login) ?></td>
                    <td>
                        <?php if ($user->role && $user->role->name === 'admin'): ?>
                            <span class="role-badge role-admin">👑 Администратор</span>
                        <?php elseif ($user->role && $user->role->name === 'science_officer'): ?>
                            <span class="role-badge role-officer">📋 Сотрудник</span>
                        <?php else: ?>
                            <span class="role-badge role-user">🎓 Аспирант</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Пользователи не найдены</p>
    <?php endif; ?>
</div>