/*
  Paginação adaptada para divs com a classe 'historial-item'.
  - Define um número fixo de 10 registros por página.
  - Adiciona e remove as 'li' de paginação dinamicamente.
  - Manipula a navegação 'próxima' e 'anterior' e limita a exibição de botões de página.
*/

document.addEventListener('DOMContentLoaded', function() {
  getPagination('.historial-item');
});

function getPagination(itemSelector) {
  var lastPage = 1;
  var maxRows = 2; // Número fixo de registros por página

  var paginationList = document.querySelector('.pagination');
  var items = document.querySelectorAll(itemSelector);
  var totalRows = items.length;
  var paginationNav = document.querySelector('.pagination-container');

  if (totalRows <= maxRows) {
    paginationNav.style.display = 'none';
    items.forEach(function(item) {
      item.style.display = 'block';
    });
    return;
  } else {
    paginationNav.style.display = 'block';
  }

  // Oculta todos os itens e mostra apenas os primeiros 10
  items.forEach(function(item, index) {
    if (index >= maxRows) {
      item.style.display = 'none';
    } else {
      item.style.display = 'block';
    }
  });

  // Cria os botões de paginação
  var pagenum = Math.ceil(totalRows / maxRows);
  for (var i = 1; i <= pagenum; ) {
    var prevBtn = document.querySelector('.pagination #prev');
    var newLi = document.createElement('li');
    newLi.setAttribute('data-page', i);
    newLi.innerHTML = `<span>${i++}<span class="sr-only">(current)</span></span>`;
    paginationList.insertBefore(newLi, prevBtn);
  }

  document.querySelector('.pagination [data-page="1"]').classList.add('active');
  limitPagging();

  paginationList.addEventListener('click', function(evt) {
    var targetLi = evt.target.closest('li');
    if (!targetLi) return;

    var pageNum = targetLi.getAttribute('data-page');
    
    if (pageNum === 'prev') {
      if (lastPage === 1) return;
      pageNum = --lastPage;
    }
    if (pageNum === 'next') {
      if (lastPage === document.querySelectorAll('.pagination li').length - 2) return;
      pageNum = ++lastPage;
    }

    lastPage = parseInt(pageNum);
    document.querySelectorAll('.pagination li').forEach(function(li) {
      li.classList.remove('active');
    });
    document.querySelector('.pagination [data-page="' + lastPage + '"]').classList.add('active');
    
    var itemIndex = 0;
    items.forEach(function(item) {
      itemIndex++;
      if (itemIndex > maxRows * pageNum || itemIndex <= maxRows * pageNum - maxRows) {
        item.style.display = 'none';
      } else {
        item.style.display = 'block';
      }
    });
    limitPagging();
  });

  function limitPagging() {
    var paginationItems = document.querySelectorAll('.pagination li');
    if (paginationItems.length > 7) {
      var activePage = parseInt(document.querySelector('.pagination li.active').getAttribute('data-page'));
      
      document.querySelectorAll('.pagination li:not([data-page="prev"]):not([data-page="next"])').forEach(function(li) {
        li.style.display = 'none';
      });
      
      var start = Math.max(1, activePage - 2);
      var end = Math.min(paginationItems.length - 2, activePage + 2);
      
      for (var i = start; i <= end; i++) {
        document.querySelector('.pagination [data-page="' + i + '"]').style.display = 'block';
      }
      
      if (start > 1) {
        document.querySelector('.pagination [data-page="1"]').style.display = 'block';
        if (start > 2) {
          var ellipsis = document.querySelector('.ellipsis-start');
          if (!ellipsis) {
            ellipsis = document.createElement('li');
            ellipsis.classList.add('ellipsis-start');
            ellipsis.innerHTML = '<span>...</span>';
            document.querySelector('.pagination [data-page="1"]').after(ellipsis);
          }
        }
      } else {
        var ellipsis = document.querySelector('.ellipsis-start');
        if(ellipsis) ellipsis.remove();
      }
      
      if (end < paginationItems.length - 2) {
        document.querySelector('.pagination [data-page="' + (paginationItems.length - 2) + '"]').style.display = 'block';
        if (end < paginationItems.length - 3) {
          var ellipsis = document.querySelector('.ellipsis-end');
          if (!ellipsis) {
            ellipsis = document.createElement('li');
            ellipsis.classList.add('ellipsis-end');
            ellipsis.innerHTML = '<span>...</span>';
            document.querySelector('.pagination [data-page="' + (paginationItems.length - 2) + '"]').before(ellipsis);
          }
        }
      } else {
        var ellipsis = document.querySelector('.ellipsis-end');
        if(ellipsis) ellipsis.remove();
      }

      document.querySelector('.pagination [data-page="prev"]').style.display = 'block';
      document.querySelector('.pagination [data-page="next"]').style.display = 'block';
    } else {
      paginationItems.forEach(function(li) {
        li.style.display = 'block';
      });
      var ellipsis = document.querySelector('.ellipsis-start');
      if(ellipsis) ellipsis.remove();
      ellipsis = document.querySelector('.ellipsis-end');
      if(ellipsis) ellipsis.remove();
    }
  }
}