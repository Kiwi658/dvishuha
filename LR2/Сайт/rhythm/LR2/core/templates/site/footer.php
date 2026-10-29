<?php
// Конец страницы публичной части сайта: закрытие main, подвал и сценарии.
// Разделы, которых в ЛР 2 ещё нет, перечислены без ссылок.
?>
</main>

<footer class="pagefoot">
  <div class="container">
    <div class="foot-grid row g-4">
      <div class="col-12 col-md-4">
        <h2>Ритм</h2>
        <p>Учебный демостенд для лабораторных работ по веб-разработке. Все данные, имена и счётчики на этой странице — демонстрационные.</p>
      </div>
      <div class="col-12 col-md-4">
        <h2>Разделы</h2>
        <ul class="list-unstyled d-flex flex-column gap-2">
          <li><a href="<?= SITE_DIR ?>">Привычки</a></li>
          <li>Импорт и экспорт</li>
          <li>Войти</li>
          <li>Регистрация</li>
        </ul>
      </div>
      <div class="col-12 col-md-4">
        <h2>Для преподавателей</h2>
        <p>Пример ЛР 2: каталог привычек выводится из таблицы habits базы данных, фильтр работает через GET-параметры.</p>
      </div>
    </div>
    <p class="foot-bottom">© 2026 «Ритм» — демонстрационный стенд для учебных целей. Разработка — <a href="https://www.intervolga.ru/">ИНТЕРВОЛГА</a>.</p>
  </div>
</footer>

<a class="to-top" href="#top" id="to-top" aria-label="Наверх страницы">
  <svg width="24" height="24" class="icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 19V6M6 12l6-6 6 6"/></svg>
</a>

<script src="<?= SITE_DIR ?>assets/js/to-top.js"></script>

</body>
</html>
