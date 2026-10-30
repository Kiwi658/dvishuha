<?php
// Каталог позиций меню: вёрстка главной страницы ЛР 1, данные — из таблицы menu_items.

require __DIR__ . '/core/init.php';
require __DIR__ . '/core/controllers/index.php';

$pageTitle = 'Меню';
$isCatalogPage = true;
require __DIR__ . '/core/templates/site/header.php';
?>

    <section class="hero">
        <div class="container hero-inner">
            <h1>Сеть доставки пиццы <em>«Додо»</em></h1>
            <p>Выбирайте пиццу, закуски и напитки. Быстрая доставка и всегда свежие ингредиенты</p>
        </div>
        <div class="hero-spacer"></div>
    </section>

    <section class="band">
        <div class="container">
            <form method="get" action="<?= SITE_DIR ?>" role="search">
                <div class="filterbar row g-3 align-items-end">
                    <div class="field col-12 col-sm-6 col-lg-auto d-flex flex-column gap-2">
                        <label class="form-label" for="q">Название</label>
                        <input class="form-control" id="q" name="q" type="search" value="<?= safe($q) ?>" placeholder="Например, Пепперони">
                    </div>

                    <div class="field col-12 col-sm-6 col-lg-auto d-flex flex-column gap-2">
                        <label class="form-label" for="category">Категория</label>
                        <select class="form-select" id="category" name="category_id">
                            <option value="">Все категории</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= (int) $category['id'] ?>"<?= (int) $category['id'] === $categoryId ? ' selected' : '' ?>>
                                    <?= safe($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="field field--range col-12 col-sm-6 col-lg-auto d-flex flex-column gap-2">
                        <span class="form-label" id="price-title">Цена</span>
                        <div class="range-inputs d-flex align-items-center gap-2" role="group" aria-labelledby="price-title">
                            <label class="visually-hidden" for="price-min">Цена, от</label>
                            <input class="form-control" id="price-min" name="price_min" type="number" min="0" step="1" inputmode="numeric" placeholder="от" value="<?= $priceMin ?>">
                            <span class="dash" aria-hidden="true">—</span>
                            <label class="visually-hidden" for="price-max">Цена, до</label>
                            <input class="form-control" id="price-max" name="price_max" type="number" min="0" step="1" inputmode="numeric" placeholder="до" value="<?= $priceMax ?>">
                        </div>
                    </div>

                    <div class="filter-actions col-12 col-lg-auto d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Применить</button>
                        <a class="btn btn-neutral" href="<?= SITE_DIR ?>">Сбросить</a>
                    </div>
                </div>

                <div class="listbar d-flex flex-wrap align-items-center justify-content-between">
                    <p class="count-note">Найдено: <b><?= $found ?> <?= plural($found, 'позиция', 'позиции', 'позиций') ?></b></p>
                </div>
            </form>

            <?php if (0 === $found): ?>

                <div class="empty-state">
                    <?php if ($isFiltered): ?>
                        <h2>Ничего не найдено</h2>
                        <p>Ни одна позиция не подходит под выбранные условия. Измените фильтр или сбросьте его.</p>
                        <a class="btn btn-neutral" href="<?= SITE_DIR ?>">Сбросить фильтр</a>
                    <?php else: ?>
                        <h2>Каталог пока пуст</h2>
                        <p>В таблице menu_items нет ни одной записи.</p>
                    <?php endif; ?>
                </div>

            <?php else: ?>

                <div class="row cards g-4">
                    <?php foreach ($menuItems as $item): ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <article class="card h-100 d-flex">
                                <div class="card-media">
                                    <span class="media-chip badge"><?= safe($item['category_name']) ?></span>
                                    <?php if (!empty($item['image'])): ?>
                                        <img src="<?= SITE_DIR ?>assets/img/<?= safe($item['image']) ?>" class="img-fluid" alt="<?= safe($item['name']) ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="card-body d-flex flex-column gap-3">
                                    <h2 class="card-title">
                                        <?= safe($item['name']) ?>
                                    </h2>
                                    <p class="card-meta">
                                        <span class="cat-name"><?= safe($item['category_name']) ?></span>
                                    </p>
                                    <p class="desc"><?= safe($item['recipe']) ?></p>
                                    <div class="counters d-flex flex-wrap gap-4">
                                        <span>Цена <b><?= number_format($item['price'], 0, '', ' ') ?> ₽</b></span>
                                    </div>
                                    <div class="card-actions d-flex flex-wrap align-items-center">
                                        <button type="button" class="btn btn-positive">В корзину</button>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php endif; ?>
        </div>
    </section>

<?php require __DIR__ . '/core/templates/site/footer.php'; ?>