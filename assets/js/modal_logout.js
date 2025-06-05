document.addEventListener('DOMContentLoaded', function() {
    // Al hacer clic en el botón "Cerrar Sesión"
    var logoutButton = document.getElementById('logoutButton');
    if (logoutButton) {
        logoutButton.addEventListener('click', function(e) {
            e.preventDefault();
            var logoutModal = new bootstrap.Modal(document.getElementById('logoutConfirmModal'));
            logoutModal.show();
        });
    }

    // Al confirmar en el modal, redirige a logout
    var confirmLogout = document.getElementById('confirmLogout');
    if (confirmLogout) {
        confirmLogout.addEventListener('click', function() {
            window.location.href = BASE_URL + "auth/logout";
        });
    }
});