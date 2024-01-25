let currentPreviewIndex = 0;
    let previewImages = [];

    function displayPreviewGallery() {
        const input = document.getElementById('photos');
        const files = input.files;

        if (files.length > 0) {
            currentPreviewIndex = 0;
            previewImages = [];

            for (const file of files) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    previewImages.push(e.target.result);
                    updatePreviewImage();
                };

                reader.readAsDataURL(file);
            }

            document.getElementById('preview-gallery-container').style.display = 'block';
        } else {
            document.getElementById('preview-gallery-container').style.display = 'none';
        }
    }

    function updatePreviewImage() {
        const previewImageElement = document.querySelector('.preview-image');
        previewImageElement.src = previewImages[currentPreviewIndex];
    }

    function scrollPreviewGallery(direction) {
        currentPreviewIndex += direction;

        if (currentPreviewIndex < 0) {
            currentPreviewIndex = previewImages.length - 1;
        } else if (currentPreviewIndex >= previewImages.length) {
            currentPreviewIndex = 0;
        }

        updatePreviewImage();
    }