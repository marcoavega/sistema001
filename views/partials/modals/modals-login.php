<!-- Modal genérico para mostrar mensajes de error, usando Bootstrap -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <!-- 'modal fade' permite que el modal tenga un efecto de desvanecimiento al mostrarse. 
         'id="messageModal"' asigna un identificador único para que pueda ser controlado con JavaScript.
         'tabindex="-1"' impide que el modal obtenga el foco cuando está oculto.
         'aria-labelledby' asocia el modal con su título para mejorar accesibilidad.
         'aria-hidden="true"' indica que el modal está oculto para los lectores de pantalla cuando no está visible. -->

    <div class="modal-dialog modal-dialog-centered">
        <!-- Contenedor principal del modal con la clase 'modal-dialog' para la estructura de Bootstrap.
             'modal-dialog-centered' centra el modal verticalmente en la pantalla. -->

        <div class="modal-content">
            <!-- Contenedor del contenido del modal, incluyendo encabezado, cuerpo y pie de página. -->

            <div class="modal-header bg-danger text-white">
                <!-- Sección de encabezado del modal.
                     'bg-danger' aplica un fondo rojo, indicando que el mensaje es un error.
                     'text-white' mantiene el texto en color blanco para mejor contraste. -->

                <h5 class="modal-title" id="messageModalLabel">Error de validación</h5>
                <!-- Título del modal, vinculado con 'aria-labelledby' para accesibilidad. -->

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <!-- Botón para cerrar el modal.
                     'data-bs-dismiss="modal"' permite que el modal se cierre al hacer clic sin necesidad de JavaScript adicional.
                     'aria-label="Close"' mejora la accesibilidad para lectores de pantalla. -->
            </div>

            <div class="modal-body">
                <!-- Cuerpo del modal donde se muestra el mensaje de error. -->

                <?php
                if (isset($_SESSION['error'])) {
                    echo $_SESSION['error']; // Imprime el mensaje de error almacenado en la sesión.
                    unset($_SESSION['error']); // Elimina el mensaje después de mostrarlo para evitar que se repita en futuras cargas de página.
                }
                ?>
            </div>

            <div class="modal-footer">
                <!-- Sección de pie del modal, donde se colocan los botones de acción. -->

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <!-- Botón para cerrar el modal sin realizar ninguna otra acción.
                     'btn-secondary' aplica un estilo gris para un diseño neutro. -->
            </div>
        </div>
    </div>
</div>
