// Лента «Недавно просмотренных»: вертикальное колесо мыши и перетаскивание мышью
// листают её по горизонтали. Без скрипта лента тоже прокручивается —
// жестом трекпада, пальцем или Shift + колесо; скрипт только добавляет удобства.
(function () {
  document.querySelectorAll('.recent-list').forEach(function (list) {
    function maxScroll() { return list.scrollWidth - list.clientWidth; }

    // Растворяем край, за которым есть ещё элементы
    function update() {
      var max = maxScroll();
      list.classList.toggle('can-scroll-left', list.scrollLeft > 1);
      list.classList.toggle('can-scroll-right', list.scrollLeft < max - 1);
      list.classList.toggle('is-draggable', max > 1);
    }
    list.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', update);
    window.addEventListener('load', update);
    update();

    // Колесо листает ленту. Пока колесо крутят без паузы, лента удерживает его и у края:
    // иначе, долистав до конца, человек внезапно поехал бы по странице. После паузы
    // новое движение колеса у края ленты прокручивает уже страницу — курсор не «запирает» её.
    var WHEEL_PAUSE = 500; // мс без событий колеса, после которых жест считается законченным
    var holdUntil = 0;
    list.addEventListener('wheel', function (e) {
      if (e.ctrlKey || Math.abs(e.deltaX) >= Math.abs(e.deltaY)) return;
      var max = maxScroll();
      if (max <= 1) return; // лента помещается целиком — колесо не трогаем
      var dy = e.deltaMode === 1 ? e.deltaY * 16 : e.deltaY;
      var atEdge = (dy < 0 && list.scrollLeft <= 0) || (dy > 0 && list.scrollLeft >= max - 1);
      var now = performance.now();
      if (atEdge && now > holdUntil) return; // новый жест у края — это прокрутка страницы
      e.preventDefault();
      holdUntil = now + WHEEL_PAUSE;
      if (!atEdge) list.scrollLeft += dy;
    }, { passive: false });

    // Перетаскивание только мышью: палец и перо прокручивают ленту штатно
    var pointer = null, startX = 0, startLeft = 0, dragged = false;
    list.addEventListener('pointerdown', function (e) {
      if (e.pointerType !== 'mouse' || e.button !== 0 || maxScroll() <= 1) return;
      pointer = e.pointerId; startX = e.clientX; startLeft = list.scrollLeft; dragged = false;
    });
    list.addEventListener('pointermove', function (e) {
      if (e.pointerId !== pointer) return;
      var dx = e.clientX - startX;
      if (!dragged && Math.abs(dx) < 5) return; // короткое движение — это клик
      if (!dragged) { dragged = true; list.setPointerCapture(pointer); list.classList.add('is-dragging'); }
      list.scrollLeft = startLeft - dx;
    });
    function end(e) {
      if (e.pointerId !== pointer) return;
      pointer = null;
      list.classList.remove('is-dragging');
      setTimeout(function () { dragged = false; }, 0);
    }
    list.addEventListener('pointerup', end);
    list.addEventListener('pointercancel', end);

    // Отпускание после перетаскивания не должно открывать ссылку
    list.addEventListener('click', function (e) {
      if (dragged) { e.preventDefault(); e.stopPropagation(); }
    }, true);
    list.addEventListener('dragstart', function (e) { e.preventDefault(); });
  });
})();
