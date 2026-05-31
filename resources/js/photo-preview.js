document.addEventListener('DOMContentLoaded', () => {

    const fotoProfilInput = document.getElementById('fotoProfilInput');

    if (!fotoProfilInput) return;

    fotoProfilInput.addEventListener('change', function (e) {

        const file = e.target.files[0];

        if (!file) return;

        const reader = new FileReader();

        reader.onload = function (event) {

            let previewFoto = document.getElementById('previewFoto');

            if (!previewFoto) {

                const previewDefault = document.getElementById('previewDefault');

                previewDefault.outerHTML = `
                    <img
                        id="previewFoto"
                        src="${event.target.result}"
                        class="w-28 h-28 rounded-full object-cover"
                    >
                `;

            } else {

                previewFoto.src = event.target.result;

            }

        }

        reader.readAsDataURL(file);

    });

});