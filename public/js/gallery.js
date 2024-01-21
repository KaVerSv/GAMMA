function initializeGallery(galleryId, photos) {
  const galleryContainer = document.querySelector(`#gallery-container-${galleryId}`);

  if (!galleryContainer || !photos || photos.length === 0) {
      // Ukryj galerię, jeśli brak kontenera lub brak zdjęć
      if (galleryContainer) {
          galleryContainer.style.display = 'none';
      }
      return;
  }

  const imageElement = galleryContainer.querySelector('.image');
  const totalPhotos = photos.length;
  let currentIndex = 0;

  function scrollGallery(direction) {
      currentIndex += direction;

      if (currentIndex < 0) {
          currentIndex = totalPhotos - 1;
      } else if (currentIndex >= totalPhotos) {
          currentIndex = 0;
      }

      const currentImagePath = photos[currentIndex];
      imageElement.src = currentImagePath;
  }

  // Initial setup
  imageElement.src = photos[currentIndex];

  // Attach event listeners
  galleryContainer.querySelector('.scroll-button-left')
      .addEventListener('click', () => scrollGallery(-1));

  galleryContainer.querySelector('.scroll-button-right')
      .addEventListener('click', () => scrollGallery(1));

  // Pokaż galerię
  galleryContainer.style.display = 'block';
}