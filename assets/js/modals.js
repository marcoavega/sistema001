// ==================================================================
// Archivo: main.js
// Propósito: Código JavaScript que se ejecuta cuando la página se carga.
// Se encarga de mostrar un modal de error utilizando Bootstrap si hay
// un mensaje de error presente en el HTML.
// ==================================================================

document.addEventListener('DOMContentLoaded', function() {
    // ------------------------------------------------------------------
    // Obtiene el elemento del modal de error por su ID "mensajeModal"
    // ------------------------------------------------------------------
    const errorModalElement = document.getElementById('messageModal');
    
    // ------------------------------------------------------------------
    // Si el modal existe, buscar el contenedor del mensaje
    // ------------------------------------------------------------------
    if (errorModalElement) {
        const modalBody = errorModalElement.querySelector('.modal-body');
        const errorMessage = modalBody.textContent.trim();
        
        // ------------------------------------------------------------------
        // Si hay un mensaje de error, se crea y muestra el modal
        // ------------------------------------------------------------------
        if (errorMessage) {
            const errorModal = new bootstrap.Modal(errorModalElement);
            errorModal.show();
            
            // ------------------------------------------------------------------
            // Cuando se cierra el modal, limpiamos el contenido del mensaje
            // ------------------------------------------------------------------
            errorModalElement.addEventListener('hidden.bs.modal', function() {
                modalBody.textContent = '';
            });
        }
    }
});
