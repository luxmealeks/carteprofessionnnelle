document.addEventListener("DOMContentLoaded", function() {
    let cropper;
    const input = document.getElementById('new_photo');
    const previewImage = document.getElementById('preview-image');
    const cropContainer = document.getElementById('crop-container');
    const croppedPhotoInput = document.getElementById('cropped_photo');

    if (!input || !previewImage || !croppedPhotoInput) return;

    input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            cropContainer.style.display = 'block';

            previewImage.onload = function() {
                if (cropper) cropper.destroy();

                cropper = new Cropper(previewImage, {
                    aspectRatio: NaN, // 🔓 Pas de ratio fixe
                    viewMode: 1,
                    autoCropArea: 0.8,
                    movable: true,
                    zoomable: true,
                    scalable: true,
                    cropBoxResizable: true,
                    cropBoxMovable: true,
                    cropend() {
                        cropper.getCroppedCanvas().toBlob(blob => {
                            const reader = new FileReader();
                            reader.readAsDataURL(blob);
                            reader.onloadend = () => {
                                croppedPhotoInput.value = reader.result;
                            };
                        }, 'image/jpeg');
                    }
                });
            };
        };
        reader.readAsDataURL(file);
    });
});
