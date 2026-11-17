(function () {
  'use strict';

  var navbar = document.getElementById('navbarSe');
  var keAtas = document.getElementById('keAtas');

  // Bayangan navbar dan tombol "ke atas" muncul setelah halaman digulir
  function saatGulir() {
    var y = window.scrollY || document.documentElement.scrollTop;
    if (navbar) navbar.classList.toggle('berbayang', y > 10);
    if (keAtas) keAtas.classList.toggle('tampil', y > 500);
  }
  window.addEventListener('scroll', saatGulir, { passive: true });
  saatGulir();

  if (keAtas) {
    keAtas.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // Validasi pencarian: minimal 2 huruf
  var form = document.getElementById('formCari');
  var pesan = document.getElementById('pesanCari');
  if (form) {
    form.addEventListener('submit', function (e) {
      var q = form.querySelector('input[name="q"]').value.trim();
      if (q.length < 2) {
        e.preventDefault();
        if (pesan) pesan.hidden = false;
      } else if (pesan) {
        pesan.hidden = true;
      }
    });
  }

  // Menu mobile menutup setelah tautan dipilih
  var menu = document.getElementById('menuUtama');
  if (menu && window.bootstrap) {
    menu.querySelectorAll('.nav-link').forEach(function (a) {
      a.addEventListener('click', function () {
        var inst = bootstrap.Collapse.getInstance(menu);
        if (inst && menu.classList.contains('show')) inst.hide();
      });
    });
  }

  // Elemen muncul perlahan saat terlihat; dilewati bila pengguna mengurangi animasi
  var reveal = document.querySelectorAll('.reveal');
  var kurangiGerak = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (!('IntersectionObserver' in window) || kurangiGerak) {
    reveal.forEach(function (el) { el.classList.add('terlihat'); });
  } else {
    var obs = new IntersectionObserver(function (items) {
      items.forEach(function (it) {
        if (it.isIntersecting) {
          it.target.classList.add('terlihat');
          obs.unobserve(it.target);
        }
      });
    }, { threshold: 0.12 });
    reveal.forEach(function (el) { obs.observe(el); });
  }
})();
