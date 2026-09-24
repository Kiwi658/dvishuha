<?php
// Начало страницы публичной части сайта: head, шапка и открытие main. У админки свой шаблон в templates/admin/.
// Перед подключением задаются $pageTitle и $isCatalogPage — отметить ли в меню пункт «Привычки».
// Импорта, входа и регистрации в ЛР 2 нет: пункты меню и кнопки выводятся неактивными.
?>
<!doctype html>
<html lang="ru">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= safe($pageTitle) ?> — Ритм</title>
<link rel="icon" href="<?= SITE_DIR ?>assets/img/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="<?= SITE_DIR ?>assets/css/fonts.css">
<?php // Bootstrap подключается первым, тема стенда — после него и переопределяет нужное ?>
<link rel="stylesheet" href="<?= SITE_DIR ?>assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?= SITE_DIR ?>assets/css/theme.css">
</head>
<body id="top">

<header class="page-head navbar navbar-expand-lg">
  <div class="container head-inner d-flex flex-wrap align-items-center gap-3">
    <a class="brand d-inline-flex align-items-center gap-2" href="<?= SITE_DIR ?>" aria-label="Ритм — на главную">
      <svg width="34" height="34" class="logo-mark" viewBox="0 0 34 34" aria-hidden="true" focusable="false">
        <circle class="cycle" cx="17" cy="17" r="12.1" fill="none" stroke="currentColor" stroke-width="3.2" stroke-linecap="round"/>
        <g class="beats" fill="currentColor">
          <rect x="9.8" y="18" width="3.4" height="5" rx="1.7"/>
          <rect x="15.3" y="14.5" width="3.4" height="8.5" rx="1.7"/>
          <rect x="20.8" y="11.5" width="3.4" height="11.5" rx="1.7"/>
        </g>
        <circle class="beat-now" cx="25.9" cy="8.8" r="2.7" fill="var(--accent)"/>
      </svg>
      <span class="brand-name">Ритм</span>
    </a>
    <nav aria-label="Основное меню">
      <ul class="nav mainnav gap-4">
        <li class="nav-item"><a class="nav-link" href="<?= SITE_DIR ?>"<?= $isCatalogPage ? ' aria-current="page"' : '' ?>>Привычки</a></li>
        <li class="nav-item"><a class="nav-link disabled" aria-disabled="true">Импорт и экспорт</a></li>
      </ul>
    </nav>
    <div class="userbox d-flex align-items-center gap-2 ms-auto">
      <span class="who">Гость</span>
      <button type="button" class="btn btn-neutral btn-sm" disabled>Войти</button>
      <button type="button" class="btn btn-primary btn-sm" disabled>Регистрация</button>
    </div>
  </div>
</header>

<main class="page">
