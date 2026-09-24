<?php
// Каталог привычек: вёрстка главной страницы ЛР 1, данные — из таблицы habits.
// Сначала логика (получить данные), потом представление (вывести их в разметку).

require __DIR__ . '/core/init.php';
// Логика страницы: фильтр и запросы к базе. Файл заполняет $habits, $categories и значения полей формы
require __DIR__ . '/core/controllers/index.php';

$pageTitle = 'Привычки';
$isCatalogPage = true;
require __DIR__ . '/core/templates/site/header.php';
?>

<section class="hero">
  <div class="container hero-inner">
    <h1>Трекер привычек <em>«Ритм»</em></h1>
    <p>Отмечайте выполнение, читайте комментарии участников и выбирайте, к чему присоединиться</p>
  </div>
  <div class="hero-spacer"></div>
</section>

<section class="band">
  <div class="container">
    <form method="get" action="<?= SITE_DIR ?>" role="search">
      <div class="filterbar row g-3 align-items-end">
        <div class="field col-12 col-sm-6 col-lg-auto d-flex flex-column gap-2">
          <label class="form-label" for="q">Название</label>
          <input class="form-control" id="q" name="q" type="search" value="<?= safe($q) ?>" placeholder="Например, вода">
        </div>
        <div class="field col-12 col-sm-6 col-lg-auto d-flex flex-column gap-2">
          <label class="form-label" for="category">Категория</label>
          <select class="form-select" id="category" name="category_id">
            <option value="">Все категории</option>
            <?php foreach ($categories as $category): ?>
              <option value="<?= (int) $category['id'] ?>"<?= (int) $category['id'] === $categoryId ? ' selected' : '' ?>><?= safe($category['title']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="field field--range col-12 col-sm-6 col-lg-auto d-flex flex-column gap-2">
          <span class="form-label" id="followers-title">Сколько придерживается</span>
          <div class="range-inputs d-flex align-items-center gap-2" role="group" aria-labelledby="followers-title">
            <label class="visually-hidden" for="followers-min">Придерживается, от</label>
            <input class="form-control" id="followers-min" name="followers_min" type="number" min="0" step="1" inputmode="numeric" placeholder="от" value="<?= $followersMin ?>">
            <span class="dash" aria-hidden="true">—</span>
            <label class="visually-hidden" for="followers-max">Придерживается, до</label>
            <input class="form-control" id="followers-max" name="followers_max" type="number" min="0" step="1" inputmode="numeric" placeholder="до" value="<?= $followersMax ?>">
          </div>
        </div>
        <div class="field field--range col-12 col-sm-6 col-lg-auto d-flex flex-column gap-2">
          <span class="form-label" id="done-title">Выполнено всеми</span>
          <div class="range-inputs d-flex align-items-center gap-2" role="group" aria-labelledby="done-title">
            <label class="visually-hidden" for="done-min">Выполнено всеми, от</label>
            <input class="form-control" id="done-min" name="done_min" type="number" min="0" step="1" inputmode="numeric" placeholder="от" value="<?= $doneMin ?>">
            <span class="dash" aria-hidden="true">—</span>
            <label class="visually-hidden" for="done-max">Выполнено всеми, до</label>
            <input class="form-control" id="done-max" name="done_max" type="number" min="0" step="1" inputmode="numeric" placeholder="до" value="<?= $doneMax ?>">
          </div>
        </div>
        <div class="filter-actions col-12 col-lg-auto d-flex gap-2">
          <button type="submit" class="btn btn-primary">Применить</button>
          <?php // Сброс — ссылка на страницу без параметров, а не type="reset" ?>
          <a class="btn btn-neutral" href="<?= SITE_DIR ?>">Сбросить</a>
        </div>
      </div>

      <div class="listbar d-flex flex-wrap align-items-center justify-content-between">
        <p class="count-note">Найдено: <b><?= $found ?> <?= plural($found, 'привычка', 'привычки', 'привычек') ?></b></p>
        <div class="field col-12 col-md-auto ms-md-auto d-flex flex-column flex-sm-row align-items-sm-center gap-2">
          <label class="form-label" for="sort">Сортировка</label>
          <?php // Заготовка из вёрстки: сортировка не работает — задание на дополнительные баллы ?>
          <select class="form-select" id="sort" name="sort" disabled>
            <option value="title" selected>По названию: А–Я</option>
            <option value="done">По числу выполнений: сначала больше</option>
          </select>
        </div>
      </div>
    </form>

    <?php if (0 === $found): ?>

      <?php // В вёрстке ЛР 1 этот блок стоял рядом со списком в пунктирной рамке. Теперь выводится либо он, либо карточки ?>
      <div class="empty-state">
        <?php if ($isFiltered): ?>
          <h2>Ничего не найдено</h2>
          <p>Ни одна привычка не подходит под выбранные условия. Измените фильтр или сбросьте его.</p>
          <a class="btn btn-neutral" href="<?= SITE_DIR ?>">Сбросить фильтр</a>
        <?php else: ?>
          <h2>Каталог пока пуст</h2>
          <p>В таблице habits нет ни одной записи.</p>
        <?php endif; ?>
      </div>

    <?php else: ?>

      <div class="row cards g-4">
        <?php foreach ($habits as $habit): ?>
          <div class="col-12 col-md-6 col-lg-4">
            <article class="card h-100 d-flex" data-cat="<?= safe($habit['category_code']) ?>">
              <div class="card-media">
                <span class="media-chip badge"><?php require __DIR__ . '/core/templates/site/category-icon.php'; ?><?= safe($habit['category_title']) ?></span>
                <img src="<?= SITE_DIR . HABIT_IMAGE_DIR ?><?= safe($habit['image_file']) ?>" <?= image_size_attrs($habit['image_file']) ?> class="img-fluid" alt="<?= safe($habit['image_alt']) ?>">
              </div>
              <div class="card-body d-flex flex-column gap-3">
                <h2 class="card-title d-flex align-items-center gap-2">
                  <span class="habit-icon"><?php require __DIR__ . '/core/templates/site/category-icon.php'; ?></span>
                  <?php // Страницы привычки в ЛР 2 нет, поэтому название и картинка без ссылки ?>
                  <?= safe($habit['title']) ?>
                </h2>
                <p class="card-meta"><span class="cat-name"><?= safe($habit['category_title']) ?></span></p>
                <p class="desc"><?= safe($habit['description']) ?></p>
                <div class="counters d-flex flex-wrap gap-4">
                  <span>Придерживаются<b><?= format_count($habit['followers_count']) ?></b></span>
                  <span>Выполнено всеми<b><?= format_count($habit['done_count']) ?></b></span>
                </div>
                <div class="card-actions d-flex flex-wrap align-items-center">
                  <button type="button" class="btn btn-positive">Начать</button>
                </div>
              </div>
            </article>
          </div>
        <?php endforeach; ?>
      </div>

      <?php // Заготовка из вёрстки: все привычки на одной странице, переходов нет — постраничная навигация задание на дополнительные баллы ?>
      <nav class="pager d-flex justify-content-center" aria-label="Постраничная навигация по каталогу">
        <ul class="pagination">
          <li class="page-item disabled"><span class="page-link" aria-label="Предыдущая страница">←</span></li>
          <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
          <li class="page-item disabled"><span class="page-link" aria-label="Следующая страница">→</span></li>
        </ul>
      </nav>

    <?php endif; ?>
  </div>
</section>

<?php require __DIR__ . '/core/templates/site/footer.php'; ?>
