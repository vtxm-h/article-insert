(function () {
  function getRequestToken() {
    if (window.Contao && window.Contao.request_token) {
      return window.Contao.request_token;
    }
    var el = document.querySelector('input[name="REQUEST_TOKEN"]');
    return el ? el.value : '';
  }

  function findInputs() {
    var page = document.getElementById('ctrl_page');
    var article = document.getElementById('ctrl_article');
    return { page: page, article: article };
  }

  function setLoading(selectEl) {
    selectEl.innerHTML = '';
    var opt = document.createElement('option');
    opt.value = '';
    opt.textContent = 'Lade Artikel …';
    selectEl.appendChild(opt);
    selectEl.value = '';
    triggerChosenUpdate(selectEl);
  }

  function setEmpty(selectEl) {
    selectEl.innerHTML = '';
    var opt = document.createElement('option');
    opt.value = '';
    opt.textContent = '-';
    selectEl.appendChild(opt);
    selectEl.value = '';
    triggerChosenUpdate(selectEl);
  }

  function triggerChosenUpdate(selectEl) {
    // Chosen Update (wenn jQuery + chosen da ist)
    if (window.jQuery) {
      window.jQuery(selectEl).trigger('chosen:updated');
    }
  }

  function loadArticles(pageId, selectEl) {
    if (!pageId || pageId <= 0) {
      setEmpty(selectEl);
      return;
    }

    setLoading(selectEl);

    var token = getRequestToken();
    var body = new URLSearchParams();
    body.append('pageId', String(pageId));
    body.append('REQUEST_TOKEN', token);

    fetch('/contao/_article_insert/articles', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
      body: body.toString(),
      credentials: 'same-origin'
    })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        var current = selectEl.value;

        selectEl.innerHTML = '';

        var blank = document.createElement('option');
        blank.value = '';
        blank.textContent = '-';
        selectEl.appendChild(blank);

        if (Array.isArray(data)) {
          data.forEach(function (row) {
            var opt = document.createElement('option');
            opt.value = String(row.id);
            opt.textContent = row.label;
            selectEl.appendChild(opt);
          });
        }

        if (current && selectEl.querySelector('option[value="' + current + '"]')) {
          selectEl.value = current;
        } else {
          selectEl.value = '';
        }

        triggerChosenUpdate(selectEl);
      })
      .catch(function () {
        setEmpty(selectEl);
      });
  }

  function hook() {
    var els = findInputs();
    if (!els.page || !els.article) return;

    loadArticles(parseInt(els.page.value || '0', 10), els.article);

    els.page.addEventListener('change', function () {
      var pageId = parseInt(els.page.value || '0', 10);
      loadArticles(pageId, els.article);
    });

    var tree = els.page.closest('.widget') || els.page.parentNode;
    if (tree) {
      tree.addEventListener('click', function () {

        window.setTimeout(function () {
          var pageId = parseInt(els.page.value || '0', 10);
          loadArticles(pageId, els.article);
        }, 50);
      });
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', hook);
  } else {
    hook();
  }
})();
