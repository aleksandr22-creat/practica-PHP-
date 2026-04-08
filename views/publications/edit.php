<h1>Редактировать публикацию</h1>

<form method="POST" action="/publications/update/<?= $publication->id ?>">
    <div>
        <label>Название:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($publication->title) ?>" required style="width: 100%; padding: 5px;">
    </div>

    <div>
        <label>Издание (журнал/сборник):</label>
        <input type="text" name="journal" value="<?= htmlspecialchars($publication->journal_or_collection) ?>" required style="width: 100%; padding: 5px;">
    </div>

    <div>
        <label>Дата публикации:</label>
        <input type="date" name="publication_date" value="<?= $publication->publication_date ?>" required>
    </div>

    <div>
        <label>Индекс:</label>
        <select name="index_type">
            <option value="РИНЦ" <?= $publication->index_type == 'РИНЦ' ? 'selected' : '' ?>>РИНЦ</option>
            <option value="Scopus" <?= $publication->index_type == 'Scopus' ? 'selected' : '' ?>>Scopus</option>
        </select>
    </div>

    <div>
        <label>Привязать аспирантов:</label>
        <?php foreach ($aspirants as $aspirant): ?>
            <div>
                <input type="checkbox" name="aspirant_ids[]" value="<?= $aspirant->id ?>"
                    <?= $publication->aspirants->contains($aspirant->id) ? 'checked' : '' ?>>
                <?= htmlspecialchars($aspirant->full_name) ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div>
        <label>Привязать руководителей:</label>
        <?php foreach ($supervisors as $supervisor): ?>
            <div>
                <input type="checkbox" name="supervisor_ids[]" value="<?= $supervisor->id ?>"
                    <?= $publication->supervisors->contains($supervisor->id) ? 'checked' : '' ?>>
                <?= htmlspecialchars($supervisor->full_name) ?>
            </div>
        <?php endforeach; ?>
    </div>

    <button type="submit" class="btn">Сохранить</button>
    <a href="/publications">Отмена</a>
</form>