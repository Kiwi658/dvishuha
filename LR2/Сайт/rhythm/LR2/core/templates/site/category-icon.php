<?php
// Значок категории текущей привычки из вёрстки «Ритма». Перед подключением задаётся $habit.
// Для кода, которого нет в вёрстке, значок не выводится. Каждое условие записано одной
// строкой: перевод строки сразу после закрывающего тега PHP не выводит, лишних пробелов
// рядом со значком нет.
?>
<?php if ('health' === $habit['category_code']): ?><svg width="24" height="24" class="icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 3C12 3 6 10.5 6 15a6 6 0 0 0 12 0c0-4.5-6-12-6-12Z"/></svg><?php endif; ?>
<?php if ('sport' === $habit['category_code']): ?><svg width="24" height="24" class="icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="6" cy="12" r="2.6"/><circle cx="18" cy="12" r="2.6"/><path d="M8.6 12h6.8"/></svg><?php endif; ?>
<?php if ('study' === $habit['category_code']): ?><svg width="24" height="24" class="icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M3 5c3-1 6-1 9 0v14c-3-1-6-1-9 0V5ZM21 5c-3-1-6-1-9 0v14c3-1 6-1 9 0V5Z"/></svg><?php endif; ?>
<?php if ('home' === $habit['category_code']): ?><svg width="24" height="24" class="icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M4 11 12 4l8 7M6 10v9h5v-5h2v5h5v-9"/></svg><?php endif; ?>
