// Кнопка «наверх»: появляется, когда страница прокручена ниже первого экрана.
(function () {
  var btn = document.getElementById('to-top');
  if (!btn) return;
  function update() {
    btn.classList.toggle('is-visible', window.scrollY > 600);
  }
  update();
  window.addEventListener('scroll', update, { passive: true });
})();
