<?php
// Общие функции страниц: подключение к базе, экранирование, чтение параметров и форматирование.
// Подключается из init.php. Классы, которые появятся в следующих работах, сюда не пишутся:
// их место — core/classes/.

/**
 * Одно подключение к базе на весь запрос: при первом вызове создаётся, дальше переиспользуется.
 */
function db(): PDO
{
    static $pdo;

    if (!$pdo instanceof PDO) {
        $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, [
            // Ошибка SQL — исключение с текстом ошибки, а не молчаливый false
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // Строки результата — ассоциативные массивы: $habit['title']
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    return $pdo;
}

/**
 * Экранирует строку для вывода в HTML-текст или атрибут в кавычках.
 * Всё, что пришло из базы или из запроса, выводится через safe().
 */
function safe(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Строковый параметр из адресной строки. Если параметра нет или вместо строки
 * пришёл массив (?q[]=1), возвращается пустая строка: запросу клиента не доверяем.
 */
function query_param(string $name): string
{
    $value = $_GET[$name] ?? '';

    return is_string($value) ? trim($value) : '';
}

/**
 * Целое число из адресной строки не меньше $min: номер записи или граница диапазона.
 * Пустое поле, текст, дробь или слишком маленькое число дают null — такое значение не используется.
 */
function query_int(string $name, int $min): ?int
{
    $number = filter_var(query_param($name), FILTER_VALIDATE_INT, ['options' => ['min_range' => $min]]);

    return false === $number ? null : $number;
}

/**
 * Число с пробелами между разрядами: 12480 → «12 480».
 */
function format_count(int $number): string
{
    return number_format($number, 0, '', ' ');
}

/**
 * Слово в нужной форме после числа: 1 привычка, 3 привычки, 8 привычек.
 */
function plural(int $number, string $one, string $few, string $many): string
{
    $mod100 = $number % 100;
    $mod10 = $number % 10;

    if (11 <= $mod100 && $mod100 <= 14) {
        return $many;
    }
    if (1 === $mod10) {
        return $one;
    }
    if (2 <= $mod10 && $mod10 <= 4) {
        return $few;
    }

    return $many;
}

/**
 * Атрибуты width и height с натуральными размерами картинки привычки из upload/habits/:
 * браузер резервирует место под неё до загрузки. Если файла нет, атрибуты не выводятся.
 */
function image_size_attrs(string $filename): string
{
    $path = ROOT_DIR . '/' . HABIT_IMAGE_DIR . basename($filename);
    $size = is_file($path) ? getimagesize($path) : false;

    if (false === $size) {
        return '';
    }

    return 'width="' . $size[0] . '" height="' . $size[1] . '"';
}
