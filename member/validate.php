<script>
    (function () {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
        const successMessage = document.getElementById("successMessage");
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.display = "none";
            }, 10000);
        }
    })();
</script>