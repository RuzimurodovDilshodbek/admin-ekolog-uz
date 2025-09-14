const inpFile = document.getElementById('fileInput');
const previewImage = document.getElementById('previewImage');
if(previewImage) previewImage.style.display = 'none';

function previewFile() {
    const preview = document.getElementById('previewImage');
    const file = document.getElementById('fileInput').files[0];
    const reader = new FileReader();

    reader.addEventListener(
        "load",
        () => {
            // convert image file to base64 string
            preview.src = reader.result;
        },
        false,
    );

    if (file) {
        reader.readAsDataURL(file);
        previewImage.style.display = 'block';
        previewImage.style.width = '200px';
        previewImage.style.padding = '15px';
    }
}
if(inpFile) {
    inpFile.addEventListener("change", function() {
        previewFile()
    })
}
