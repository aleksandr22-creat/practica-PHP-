<h1>Отчёт по защитам диссертаций</h1>
<form method="POST">
    <label>С даты: <input type="date" name="start_date" required></label>

    <label>По дату: <input type="date" name="end_date" required></label>

    <button type="submit">Сформировать</button>
</form>
<?php if (isset($count)): ?>
    <h3>Количество защит за период: <?= $count ?></h3>
<?php endif; ?>
