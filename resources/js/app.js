//import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


document.addEventListener('DOMContentLoaded', function() {
    // Vérifier si on est sur la page dashboard avec le carrousel
    const carouselContainer = document.getElementById('featured-carousel');
    if (!carouselContainer) return;
    
    const slides = document.querySelectorAll('.carousel-slide');
    const indicators = document.querySelectorAll('.carousel-indicator');
    const currentSlideSpan = document.getElementById('current-slide');
    
    if (slides.length === 0) return;
    
    let currentIndex = 0;
    let intervalId;
    
    function showSlide(index) {
        // Désactiver toutes les slides
        slides.forEach(slide => {
            slide.classList.remove('active');
        });
        
        // Désactiver tous les indicateurs
        indicators.forEach(indicator => {
            indicator.classList.remove('bg-white', 'scale-125');
            indicator.classList.add('bg-white/40');
        });
        
        // Activer la slide sélectionnée
        slides[index].classList.add('active');
        
        // Activer l'indicateur correspondant
        if (indicators[index]) {
            indicators[index].classList.add('bg-white', 'scale-125');
            indicators[index].classList.remove('bg-white/40');
        }
        
        // Mettre à jour le compteur
        if (currentSlideSpan) {
            currentSlideSpan.textContent = index + 1;
        }
    }
    
    function nextSlide() {
        currentIndex = (currentIndex + 1) % slides.length;
        showSlide(currentIndex);
    }
    
    function startCarousel() {
        intervalId = setInterval(nextSlide, 8000); // 8 secondes
    }
    
    function stopCarousel() {
        clearInterval(intervalId);
    }
    
    // Démarrer le carrousel
    startCarousel();
    
    // Gérer le clic sur les indicateurs
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            currentIndex = index;
            showSlide(currentIndex);
            stopCarousel();
            startCarousel(); // Redémarrer le timer
        });
    });
    
    // Pause au survol
    carouselContainer.addEventListener('mouseenter', stopCarousel);
    carouselContainer.addEventListener('mouseleave', startCarousel);
    
    // Pause quand la page n'est pas visible
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            stopCarousel();
        } else {
            startCarousel();
        }
    });

    // Gestion des carrousels de sections
    document.querySelectorAll('.carousel-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const carouselType = this.getAttribute('data-carousel');
            const carousel = document.getElementById(`carousel-${carouselType}`);
            const isNext = this.classList.contains('next-btn');
            
            if (carousel) {
                const scrollAmount = 240; // 200px (largeur item) + 24px (gap)
                const currentScroll = carousel.scrollLeft;
                const targetScroll = isNext 
                    ? currentScroll + scrollAmount 
                    : currentScroll - scrollAmount;
                
                carousel.scrollTo({
                    left: targetScroll,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Fonction pour créer et afficher des toasts
    function showToast(message, type = 'info', duration = 3000) {
        const container = document.getElementById('toast-container');
        
        // Icônes selon le type
        const icons = {
            success: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                      </svg>`,
            error: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                   </svg>`,
            info: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>`
        };

        // Créer l'élément toast
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <div class="toast-icon">${icons[type]}</div>
                <div class="toast-message">${message}</div>
            </div>
            <button class="toast-close" onclick="this.parentElement.remove()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <div class="toast-progress"></div>
        `;

        // Ajouter au container
        container.appendChild(toast);

        // Animation d'entrée
        setTimeout(() => {
            toast.classList.add('show');
        }, 100);

        // Suppression automatique
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.remove();
                }
            }, 300);
        }, duration);
    }

    // Gestion de la modal des items
    const modal = document.getElementById('itemModal');
    const closeModalBtn = document.getElementById('closeModal');
    const itemForm = document.getElementById('itemForm');
    const removeFromLibraryBtn = document.getElementById('removeFromLibrary');

    // Ouvrir la modal
    document.querySelectorAll('.item-card').forEach(card => {
        card.addEventListener('click', function() {
            const itemId = this.getAttribute('data-item-id');
            const title = this.getAttribute('data-title');
            const type = this.getAttribute('data-type');
            const poster = this.getAttribute('data-poster');
            const overview = this.getAttribute('data-overview');
            const releaseDate = this.getAttribute('data-release-date');
            const ratingApi = this.getAttribute('data-rating-api');
            const genres = this.getAttribute('data-genres');
            const platforms = this.getAttribute('data-platforms');
            const userStatus = this.getAttribute('data-user-status');
            const userRating = this.getAttribute('data-user-rating');
            const userReview = this.getAttribute('data-user-review');

            // Remplir la modal avec les données
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalPoster').src = poster;
            document.getElementById('modalPoster').alt = title;
            document.getElementById('modalType').textContent = type.charAt(0).toUpperCase() + type.slice(1);
            document.getElementById('modalReleaseDate').textContent = releaseDate;
            document.getElementById('modalRatingApi').textContent = ratingApi;
            document.getElementById('modalGenres').textContent = genres || 'Aucun genre';
            document.getElementById('modalOverview').textContent = overview;
            
            // Afficher les plateformes seulement pour les jeux
            const platformsDiv = document.getElementById('modalPlatforms');
            const platformsList = document.getElementById('modalPlatformsList');
            if (platforms && platforms.trim() !== '') {
                platformsList.textContent = platforms;
                platformsDiv.classList.remove('hidden');
            } else {
                platformsDiv.classList.add('hidden');
            }

            // Remplir le formulaire
            document.getElementById('itemId').value = itemId;
            document.getElementById('itemStatus').value = userStatus;
            document.getElementById('itemRating').value = userRating;
            document.getElementById('ratingValue').textContent = userRating;
            document.getElementById('itemReview').value = userReview;

            // Afficher la modal
            modal.classList.remove('hidden');
            modal.classList.add('modal-enter');
        });
    });

    // Fermer la modal
    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('modal-enter');
    }

    closeModalBtn.addEventListener('click', closeModal);
    
    // Fermer en cliquant sur le backdrop
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Fermer avec la touche Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });

    // Mise à jour de la valeur du slider
    document.getElementById('itemRating').addEventListener('input', function() {
        document.getElementById('ratingValue').textContent = this.value;
    });

    // Soumission du formulaire
    itemForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('/library/update', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Afficher un toast de succès
                showToast('Modifications sauvegardées avec succès !', 'success');
                closeModal();
                // Optionnel: recharger la page pour voir les changements
                // location.reload();
            } else {
                showToast('Erreur lors de la sauvegarde : ' + (data.message || 'Erreur inconnue'), 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showToast('Erreur lors de la sauvegarde. Vérifiez la console pour plus de détails.', 'error');
        });
    });

    // Supprimer de la bibliothèque
    removeFromLibraryBtn.addEventListener('click', function() {
        if (confirm('Êtes-vous sûr de vouloir retirer cet item de votre bibliothèque ?')) {
            const itemId = document.getElementById('itemId').value;
            
            fetch('/library/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ item_id: itemId })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showToast('Item retiré de votre bibliothèque !', 'success');
                    closeModal();
                    location.reload();
                } else {
                    showToast('Erreur lors de la suppression : ' + (data.message || 'Erreur inconnue'), 'error');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showToast('Erreur lors de la suppression. Vérifiez la console pour plus de détails.', 'error');
            });
        }
    });
});