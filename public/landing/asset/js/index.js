document.addEventListener('DOMContentLoaded', function() {
    const textareas = document.querySelectorAll('.autoresizeTextarea'); // Ambil semua textarea dengan class ini

    // Fungsi untuk menyesuaikan tinggi textarea
    function autoResize(textarea) {
        textarea.style.height = 'auto';  // Reset tinggi dulu
        textarea.style.height = textarea.scrollHeight + 'px';  // Set tinggi sesuai konten
    }

    // Iterasi setiap textarea dan tambahkan event listener
    textareas.forEach(function(textarea) {
        textarea.addEventListener('input', function() {
            autoResize(textarea); // Panggil fungsi autoResize untuk textarea yang sedang diinput
        });

        // Panggil autoResize jika ada konten awal
        autoResize(textarea);
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const textareas = document.querySelectorAll('.deskripsi'); // Ambil semua textarea dengan class ini

    // Fungsi untuk menyesuaikan tinggi textarea
    function autoResize(textarea) {
        textarea.style.height = 'auto';  // Reset tinggi dulu
        textarea.style.height = textarea.scrollHeight + 'px';  // Set tinggi sesuai konten
    }

    // Iterasi setiap textarea dan tambahkan event listener
    textareas.forEach(function(textarea) {
        textarea.addEventListener('input', function() {
            autoResize(textarea); // Panggil fungsi autoResize untuk textarea yang sedang diinput
        });

        // Panggil autoResize jika ada konten awal
        autoResize(textarea);
    });
});

function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function () {
        const output = document.getElementById('avatarPreview');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}