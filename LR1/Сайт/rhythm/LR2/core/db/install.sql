-- Таблицы каталога привычек для ЛР 2: справочник категорий и восемь привычек с главной «Ритма».
-- В лабораторной таблицы создаются руками в phpMyAdmin; этот файл нужен, чтобы
-- повторить ту же структуру одной командой и чтобы она хранилась в репозитории.
--
-- Порядок в phpMyAdmin: создать базу rhythm с кодировкой utf8mb4_unicode_ci,
-- открыть её, вкладка «Импорт», выбрать этот файл, «Импорт».

CREATE TABLE categories (
  id    INT UNSIGNED NOT NULL AUTO_INCREMENT,
  title VARCHAR(80)  NOT NULL,
  code  VARCHAR(20)  NOT NULL,                         -- оформление карточки в theme.css: health, sport, study, home
  PRIMARY KEY (id),
  UNIQUE KEY uq_categories_title (title)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE habits (
  id              INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  category_id     INT UNSIGNED  NOT NULL,              -- номер категории из categories, а не её название
  title           VARCHAR(120)  NOT NULL,
  description     TEXT          NOT NULL,
  image_file      VARCHAR(100)  NOT NULL,              -- имя файла в img/, а не сама картинка
  image_alt       VARCHAR(255)  NOT NULL,
  followers_count INT UNSIGNED  NOT NULL DEFAULT 0,    -- «Придерживаются»
  done_count      INT UNSIGNED  NOT NULL DEFAULT 0,    -- «Выполнено всеми»
  PRIMARY KEY (id),
  CONSTRAINT fk_habits_category
    FOREIGN KEY (category_id) REFERENCES categories (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Номера категорий заданы явно: по ним ниже ссылаются привычки
INSERT INTO categories (id, title, code) VALUES
(1, 'Здоровье', 'health'),
(2, 'Спорт', 'sport'),
(3, 'Учёба', 'study'),
(4, 'Быт', 'home');

INSERT INTO habits (category_id, title, description, image_file, image_alt, followers_count, done_count) VALUES
(2, 'Гулять десять тысяч шагов', 'Проходить не меньше десяти тысяч шагов за день: часть дороги пешком и прогулка после ужина.', 'habit-walking-16bit.jpg', 'Пиксель-арт: аллея в парке со скамейками и фонарями, человек уходит по дорожке вдаль', 187, 4268),
(4, 'Заправлять постель утром', 'Застилать кровать сразу после подъёма. Маленькое дело, с которого начинается порядок в комнате.', 'habit-bedmaking-16bit.jpg', 'Пиксель-арт: заправленная кровать с синим покрывалом и белыми подушками между двумя окнами', 61, 803),
(1, 'Медитация перед сном', 'Десять минут тишины и дыхательных упражнений перед сном. Помогает отложить телефон и быстрее засыпать.', 'habit-meditation-16bit.png', 'Пиксель-арт: человек медитирует перед сном в комнате с ночным окном', 54, 611),
(1, 'Пить воду', 'Выпивать достаточно воды в течение дня для самочувствия и концентрации.', 'habit-water-16bit.png', 'Пиксель-арт: стакан свежей воды на столе у окна', 342, 12480),
(4, 'Уборка за собой сразу', 'Не откладывать мелкую уборку: мыть посуду и убирать вещи сразу после использования.', 'habit-cleaning-16bit.png', 'Пиксель-арт: человек сразу убирает за собой посуду', 96, 1042),
(2, 'Утренняя зарядка', 'Десять минут разминки сразу после подъёма. Привычка только что добавлена в каталог.', 'habit-exercise-16bit.png', 'Пиксель-арт: утренняя разминка на коврике у окна', 0, 0),
(3, 'Учить английский по пятнадцать новых слов каждый день', 'Повторять выученное и заучивать пятнадцать новых английских слов ежедневно.', 'habit-english-16bit.png', 'Пиксель-арт: словарь и карточки для ежедневного изучения английских слов', 73, 12345),
(3, 'Читать 20 минут в день', 'Читать художественную или учебную литературу хотя бы двадцать минут в день.', 'habit-reading-16bit.png', 'Пиксель-арт: человек читает книгу в уютном кресле у лампы', 128, 956);
