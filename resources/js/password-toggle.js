document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.toggle-password').forEach(button => {

        button.addEventListener('click', () => {

            const targetId = button.dataset.target;
            const input = document.getElementById(targetId);

            if (!input) return;

            const icon = button.querySelector('.eye-icon');

            const eye = icon.dataset.eye;
            const eyeOff = icon.dataset.eyeOff;

            if (input.type === 'password') {
                input.type = 'text';
                icon.src = eyeOff;
            } else {
                input.type = 'password';
                icon.src = eye;
            }
        });

    });

});