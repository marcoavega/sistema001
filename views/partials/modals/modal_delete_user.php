<!-- Modal para la confirmación de eliminación de usuario -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <!-- 'modal fade' proporciona un efecto de desvanecimiento al abrirse y cerrarse.
         'id="deleteUserModal"' permite identificar el modal para su manipulación con JavaScript.
         'tabindex="-1"' evita que el modal obtenga foco automáticamente cuando está oculto.
         'aria-labelledby="deleteUserModalLabel"' vincula el modal con su título, mejorando accesibilidad.
         'aria-hidden="true"' indica que el modal está oculto inicialmente para los lectores de pantalla. -->

    <div class="modal-dialog modal-dialog-centered">
        <!-- 'modal-dialog' define la estructura y tamaño del modal.
             'modal-dialog-centered' centra el modal verticalmente en la pantalla. -->

        <div class="modal-content">
            <!-- Contenedor principal del modal que agrupa los elementos del encabezado, cuerpo y pie de página. -->

            <div class="modal-header bg-danger text-white">
                <!-- Encabezado del modal, con fondo rojo ('bg-danger') para alertar sobre una acción crítica.
                     'text-white' mantiene el texto en color blanco para mejorar la legibilidad. -->

                <h5 class="modal-title" id="deleteUserModalLabel">Confirmar Eliminación</h5>
                <!-- Título del modal, vinculado a 'aria-labelledby' para accesibilidad. -->

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                <!-- Botón de cierre del modal.
                     'data-bs-dismiss="modal"' permite cerrar el modal sin necesidad de código adicional en JavaScript.
                     'aria-label="Cerrar"' proporciona accesibilidad a usuarios con lectores de pantalla. -->
            </div>

            <div class="modal-body">
                <!-- Contenido principal del modal donde se muestra el mensaje de confirmación. -->
                ¿Estás seguro que deseas eliminar este usuario?
            </div>

            <div class="modal-footer">
                <!-- Pie de página del modal donde se colocan los botones de acción. -->

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <!-- Botón para cancelar la acción y cerrar el modal sin realizar cambios.
                     'btn-secondary' usa un color gris para indicar una acción neutral. -->

                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Eliminar</button>
                <!-- Botón para confirmar la eliminación del usuario.
                     'id="confirmDeleteBtn"' permite que el botón sea manipulado mediante JavaScript.
                     'btn-danger' usa un color rojo, destacando que la acción es irreversible. -->
            </div>
        </div>
    </div>
</div>
