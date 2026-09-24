<?php
// Логика главной страницы index.php: читает фильтр из адресной строки и получает привычки из базы.
// Контроллер лежит по тому же пути от core/controllers/, что и его страница от корня сайта:
// для admin/habits.php это будет core/controllers/admin/habits.php.
// Подключается из страницы после init.php. Разметки здесь нет, файл только готовит
// переменные для представления:
// $q, $categoryId, $followersMin, $followersMax, $doneMin, $doneMax — значения полей формы;
// $habits — найденные привычки, $categories — все категории справочника;
// $isFiltered — задано ли хоть одно условие, $found — сколько привычек найдено.

// ---------- 1. Параметры фильтра из адресной строки ----------

$q = query_param('q');
$categoryId = query_int('category_id', 1);
$followersMin = query_int('followers_min', 0);
$followersMax = query_int('followers_max', 0);
$doneMin = query_int('done_min', 0);
$doneMax = query_int('done_max', 0);

// ---------- 2. Условия WHERE собираются по частям ----------
// В запрос попадает только то, что посетитель действительно задал.
// Значения не вклеиваются в строку SQL, а передаются отдельно через именованные метки.

$where = [];
$params = [];

if (strlen($q)) {
    $where[] = 'habits.title LIKE :q';
    $params['q'] = '%' . $q . '%';
}
if (intval($categoryId)) {
    $where[] = 'habits.category_id = :category_id';
    $params['category_id'] = $categoryId;
}

// Диапазоны: условие добавляется, только если в поле целое число больше нуля.
// Ноль в границе пропускается так же, как пустое поле
if (intval($followersMin)) {
    $where[] = 'habits.followers_count >= :followers_min';
    $params['followers_min'] = $followersMin;
}
if (intval($followersMax)) {
    $where[] = 'habits.followers_count <= :followers_max';
    $params['followers_max'] = $followersMax;
}
if (intval($doneMin)) {
    $where[] = 'habits.done_count >= :done_min';
    $params['done_min'] = $doneMin;
}
if (intval($doneMax)) {
    $where[] = 'habits.done_count <= :done_max';
    $params['done_max'] = $doneMax;
}

// ---------- 3. Запросы к базе ----------

// Название и код оформления категории приходят из справочника categories через JOIN
$sql = 'SELECT habits.id, habits.title, habits.description, habits.image_file, habits.image_alt,
               habits.followers_count, habits.done_count,
               categories.title AS category_title, categories.code AS category_code
        FROM habits
        INNER JOIN categories ON categories.id = habits.category_id';
if (count($where)) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}
// Порядок постоянный: выбор сортировки посетителем — задание на дополнительные баллы
$sql .= ' ORDER BY habits.title ASC';

$statement = db()->prepare($sql);
$statement->execute($params);
$habits = $statement->fetchAll();

// Варианты списка — все строки справочника: в value номер категории, в тексте её название
$categories = db()->query('SELECT id, title FROM categories ORDER BY title')->fetchAll();

$isFiltered = count($where) > 0;
$found = count($habits);
