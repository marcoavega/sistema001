document.addEventListener('DOMContentLoaded', function() {
    // Mostrar modal de éxito si existe
    var successModalElement = document.getElementById('successModal');
    if (successModalElement) {
        var successModal = new bootstrap.Modal(successModalElement);
        successModal.show();
    }

    // Mostrar modal de error si existe
    var errorModalElement = document.getElementById('errorModal');
    if (errorModalElement) {
        var errorModal = new bootstrap.Modal(errorModalElement);
        errorModal.show();
    }
});