<!-- Modal de Confirmación de Cierre de Sesión -->
<div class="modal fade" id="logoutConfirmModal" tabindex="-1" aria-labelledby="logoutConfirmModalLabel" aria-hidden="true">
    <!-- 'modal fade' permite que el modal tenga un efecto de desvanecimiento al mostrarse.
         'id="logoutConfirmModal"' es el identificador único para ser manipulable mediante JavaScript.
         'tabindex="-1"' evita que el modal reciba el foco automáticamente al abrirse.
         'aria-labelledby="logoutConfirmModalLabel"' vincula el modal con su título para mejorar accesibilidad.
         'aria-hidden="true"' indica que el modal está oculto inicialmente para lectores de pantalla. -->

    <div class="modal-dialog modal-dialog-centered">
        <!-- 'modal-dialog' es el contenedor principal del modal que define su estructura.
             'modal-dialog-centered' centra el modal verticalmente en la pantalla. -->

        <div class="modal-content">
            <!-- 'modal-content' agrupa todos los elementos dentro del modal: encabezado, cuerpo y pie de página. -->

            <div class="modal-header bg-warning text-dark">
                <!-- 'modal-header' contiene el título y botón de cierre.
                     'bg-warning' establece un fondo amarillo para indicar advertencia.
                     'text-dark' mantiene el texto en color oscuro para buen contraste. -->

                <h5 class="modal-title" id="logoutConfirmModalLabel">Confirmar Cierre de Sesión</h5>
                <!-- Título del modal vinculado con 'aria-labelledby' para accesibilidad. -->

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                <!-- Botón de cierre. 
                     'data-bs-dismiss="modal"' permite cerrar el modal sin necesidad de código adicional en JavaScript.
                     'aria-label="Cerrar"' mejora la accesibilidad para usuarios con lectores de pantalla. -->
            </div>

            <div class="modal-body">
                <!-- Sección del modal donde se muestra el mensaje al usuario. -->
                ¿Realmente deseas cerrar sesión?
            </div>

            <div class="modal-footer">
                <!-- 'modal-footer' es el área donde se colocan los botones de acción. -->

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <!-- Botón para cancelar la acción y cerrar el modal.
                     'btn-secondary' usa un color gris neutro para indicar que no se está ejecutando un cambio. -->

                <button type="button" class="btn btn-danger" id="confirmLogout">Cerrar Sesión</button>
                <!-- Botón de acción principal que activa el cierre de sesión.
                     'id="confirmLogout"' permite que sea manejado desde JavaScript para ejecutar la función correspondiente.
                     'btn-danger' usa un color rojo para indicar una acción importante. -->
            </div>
        </div>
    </div>
</div>
