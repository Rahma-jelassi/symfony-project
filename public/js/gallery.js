function scrollGallery(direction) {
    const galleryContainer = document.querySelector('.gallery-container');
    const imageWidth = document.querySelector('.image-item').offsetWidth;
    const galleryWrapper = document.querySelector('.gallery-wrapper');
    
    if (direction === 'left') {
        galleryContainer.style.transform = `translateX(${galleryWrapper.scrollLeft - imageWidth}px)`;
    } else {
        galleryContainer.style.transform = `translateX(${galleryWrapper.scrollLeft + imageWidth}px)`;
    }
}
