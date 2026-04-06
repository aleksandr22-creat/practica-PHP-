<h1>Добавить публикацию</h1>

<form method="POST" action="/publications/store">
    <div>
        <label>Название:</label>

        <input type="text" name="title" required style="width: 100%; padding: 5px;">
    </div>


    <div>
        <label>Издание (журнал/сборник):</label>

        <input type="text" name="journal" required style="width: 100%; padding: 5px;">
    </div>


    <div>
        <label>Дата публикации:</label>

        <input type="date" name="publication_date" required>
    </div>


    <div>
        <label>Индекс:</label>

        <select name="index_type">
            <option value="РИНЦ">РИНЦ</option>
            <option value="Scopus">Scopus</option>
        </select>
    </div>


    <div>
        <label>Привязать аспирантов:</label>

        <?php foreach ($aspirants as $aspirant): ?>
            <input type="checkbox" name="aspirant_ids[]" value="<?= $aspirant->id ?>">
            <?= $aspirant->full_name ?>

        <?php endforeach; ?>
    </div>


    <div>
        <label>Привязать руководителей:</label>

        <?php foreach ($supervisors as $supervisor): ?>
            <input type="checkbox" name="supervisor_ids[]" value="<?= $supervisor->id ?>">
            <?= $supervisor->full_name ?>

        <?php endforeach; ?>
    </div>


    <button type="submit" class="btn">Сохранить</button>
    <a href="/publications">Отмена</a>
</form>