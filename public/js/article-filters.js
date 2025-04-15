document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const clearSearch = document.getElementById('clearSearch');
    const searchForm = document.getElementById('searchForm');
    const perPageSelect = document.getElementById('perPage');
    const sortSelect = document.getElementById('sort');
    
    // Mostrar/ocultar botón de limpiar
    searchInput.addEventListener('input', function() {
        clearSearch.style.display = this.value.length > 0 ? 'block' : 'none';
    });
    
    // Limpiar búsqueda
    clearSearch.addEventListener('click', function(e) {
        e.preventDefault();
        searchInput.value = '';
        searchForm.submit();
    });
    
    // Enviar formulario cuando cambia el selector de perPage o sort
    perPageSelect.addEventListener('change', function() {
        searchForm.submit();
    });
    
    sortSelect.addEventListener('change', function() {
        searchForm.submit();
    });
    
    // Buscar automáticamente después de escribir
    let timeout = null;
    searchInput.addEventListener('input', function() {
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            if (searchInput.value.length >= 2 || searchInput.value.length === 0) {
                searchForm.submit();
            }
        }, 500);
    });
});