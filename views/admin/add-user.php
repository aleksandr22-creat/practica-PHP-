
<style>
    .form-container {
        max-width: 500px;
        margin: 0 auto;
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }
    .form-group input, .form-group select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
    }
    .form-group input:focus, .form-group select:focus {
        outline: none;
        border-color: #1a1a2e;
    }
    .error {
        color: #e74c3c;
        font-size: 12px;
        margin-top: 5px;
        display: block;
    }
    .btn-submit {
        background: #1a1a2e;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        width: 100%;
    }
    .btn-submit:hover {
        background: #2c2c54;
    }
    h2 {
        margin-bottom: 25px;
        color: #1a1a2e;
    }
</style>

<div class="form-container">
    <h2>➕ Добавление нового пользователя</h2>

    <?php if (isset($errors) && count($errors) > 0): ?>
        <div style="background: #fee; padding: 10px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #e74c3c;">
            <?php foreach ($errors as $error): ?>
                <small style="color: #e74c3c; display: block;">⚠ <?= $error ?></small>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Имя <span style="color: red;">*</span></label>
            <input type="text" name="name" value="<?= htmlspecialchars($data['name'] ?? '') ?>" placeholder="Введите ФИО">
        </div>

        <div class="form-group">
            <label>Логин <span style="color: red;">*</span></label>
            <input type="text" name="login" value="<?= htmlspecialchars($data['login'] ?? '') ?>" placeholder="Введите логин">
        </div>

        <div class="form-group">
            <label>Пароль <span style="color: red;">*</span></label>
            <input type="password" name="password" placeholder="Минимум 4 символа">
        </div>

        <div class="form-group">
            <label>Роль <span style="color: red;">*</span></label>
            <select name="role_id">
                <option value="">-- Выберите роль --</option>
                <?php if (isset($roles)): ?>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= $role->id ?>" <?= (isset($data['role_id']) && $data['role_id'] == $role->id) ? 'selected' : '' ?>>
                            <?php if ($role->name === 'admin'): ?>
                                👑 Администратор
                            <?php elseif ($role->name === 'science_officer'): ?>
                                📋 Сотрудник научного отдела
                            <?php else: ?>
                                🎓 Аспирант
                            <?php endif; ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <button type="submit" class="btn-submit">✅ Создать пользователя</button>
    </form>
</div>