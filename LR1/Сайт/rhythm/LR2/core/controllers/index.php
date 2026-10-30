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
$priceMin = query_int('price_min', 0);
$priceMax = query_int('price_max', 0);

// ---------- 2. Условия WHERE собираются по частям ----------
// В запрос попадает только то, что посетитель действительно задал.
// Значения не вклеиваются в строку SQL, а передаются отдельно через именованные метки.

$where = [];
$params = [];

if (strlen($q)) {
    $where[] = 'menu_items.name LIKE :q';
    $params['q'] = '%' . $q . '%';
}
if (intval($categoryId)) {
    $where[] = 'menu_items.category_id = :category_id';
    $params['category_id'] = $categoryId;
}

// Диапазоны: условие добавляется, только если в поле целое число больше нуля.
// Ноль в границе пропускается так же, как пустое поле

// Диапазон цены
if (intval($priceMin)) {
    $where[] = 'menu_items.price >= :price_min';
    $params['price_min'] = $priceMin;
}
if (intval($priceMax)) {
    $where[] = 'menu_items.price <= :price_max';
    $params['price_max'] = $priceMax;
}

// ---------- 3. Запросы к базе ----------

$sql = 'SELECT menu_items.id, menu_items.name, menu_items.recipe, menu_items.price, menu_items.image,
               categories.name AS category_name
        FROM menu_items
        INNER JOIN categories ON categories.id = menu_items.category_id';

if (count($where)) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}

$sql .= ' ORDER BY menu_items.name ASC';

$statement = db()->prepare($sql);
$statement->execute($params);
$menuItems = $statement->fetchAll();

// Все категории для выпадающего списка
$categories = db()->query('SELECT id, name FROM categories ORDER BY name')->fetchAll();

$isFiltered = count($where) > 0;
$found = count($menuItems);
