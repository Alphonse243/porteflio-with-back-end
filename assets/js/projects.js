let currentPage = 1;
let isLoading = false;

function loadProjects() {
    if (isLoading) return;
    
    isLoading = true;
    const loading = document.getElementById('loading');
    const loadMore = document.getElementById('load-more');
    const errorMessage = document.getElementById('error-message');
    
    loading.style.display = 'block';
    loadMore.style.display = 'none';
    errorMessage.style.display = 'none';

    fetch(`ajax/load_projects.php?page=${currentPage}`)
        .then(async response => {
            const text = await response.text();
            console.log('Response raw:', text); // Debug

            if (!response.ok) {
                try {
                    const errorData = JSON.parse(text);
                    throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
                } catch (e) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
            }

            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('Invalid JSON:', text);
                throw new Error('Invalid JSON response');
            }
        })
        .then(data => {
            console.log('Données reçues:', data); // Debug
            const container = document.getElementById('projects-container');
            
            if (!data.html) {
                console.error('Pas de contenu HTML dans la réponse');
                return;
            }

            if (currentPage === 1) {
                container.innerHTML = data.html;
            } else {
                container.insertAdjacentHTML('beforeend', data.html);
            }

            loading.style.display = 'none';
            loadMore.style.display = 'block';
            loadMore.style.display = data.hasMore ? 'block' : 'none';

            isLoading = false;
        })
        .catch(error => {
            console.error('Erreur lors du chargement:', error);
            loading.style.display = 'none';
            loadMore.style.display = 'block';
            errorMessage.style.display = 'block';
            errorMessage.textContent = 'Erreur lors du chargement des projets. Veuillez réessayer.';
            isLoading = false;
        });
}

document.addEventListener('DOMContentLoaded', function() {
    loadProjects();

    document.getElementById('load-more').addEventListener('click', function() {
        currentPage++;
        loadProjects();
    });
});
