document.addEventListener('DOMContentLoaded', function() {
    getPagination('.list-item');
});

function getPagination(itemSelector) {
    var lastPage = 1;
    var maxRows = 10;

    var paginationList = document.querySelector('.pagination');
    var items = document.querySelectorAll(itemSelector);
    var totalRows = items.length;
    var paginationNav = document.querySelector('.pagination-container');

    // Determine the correct display style based on the element type
    var displayStyle = 'block';
    if (items.length > 0 && items[0].tagName.toLowerCase() === 'tr') {
        displayStyle = 'table-row';
    }

    if (totalRows <= maxRows) {
        paginationNav.style.display = 'none';
        items.forEach(function(item) {
            item.style.display = displayStyle;
        });
        return;
    } else {
        paginationNav.style.display = 'block';
    }

    // Set initial display for the first page
    items.forEach(function(item, index) {
        if (index >= maxRows) {
            item.style.display = 'none';
        } else {
            item.style.display = displayStyle;
        }
    });

    // Create page number buttons
    var pagenum = Math.ceil(totalRows / maxRows);
    var prevBtn = document.querySelector('.pagination #prev');
    var nextBtn = document.querySelector('.pagination [data-page="next"]');
    for (var i = 1; i <= pagenum; i++) {
        var newLi = document.createElement('li');
        newLi.setAttribute('data-page', i);
        newLi.innerHTML = `<span>${i}<span class="sr-only">(current)</span></span>`;
        if (i === 1) {
            newLi.classList.add('active');
        }
        paginationList.insertBefore(newLi, nextBtn);
    }

    // Handle click events for pagination buttons
    paginationList.addEventListener('click', function(evt) {
        var targetLi = evt.target.closest('li');
        if (!targetLi) return;

        var pageNum = targetLi.getAttribute('data-page');
        
        if (pageNum === 'prev') {
            if (lastPage === 1) return;
            pageNum = --lastPage;
        } else if (pageNum === 'next') {
            if (lastPage === pagenum) return;
            pageNum = ++lastPage;
        }

        lastPage = parseInt(pageNum);

        // Update active class
        document.querySelectorAll('.pagination li').forEach(function(li) {
            li.classList.remove('active');
        });
        document.querySelector('.pagination [data-page="' + lastPage + '"]').classList.add('active');
        
        // Show/hide items based on the selected page
        items.forEach(function(item, index) {
            if (index >= maxRows * lastPage || index < maxRows * (lastPage - 1)) {
                item.style.display = 'none';
            } else {
                item.style.display = displayStyle;
            }
        });
        
        limitPagging();
    });

    // Function to handle ellipsis for long pagination lists
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
    
    // Initial call to limit pagination
    limitPagging();
}