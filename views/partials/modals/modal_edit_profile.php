<!-- Modal de edición de perfil -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <!-- 'modal fade' proporciona un efecto de desvanecimiento al abrirse y cerrarse.
         'id="editProfileModal"' permite identificar el modal para controlarlo con JavaScript.
         'tabindex="-1"' impide que el modal obtenga el foco cuando está oculto.
         'aria-labelledby="editProfileModalLabel"' vincula el modal con su título para mejorar accesibilidad.
         'aria-hidden="true"' indica que el modal está oculto inicialmente para lectores de pantalla. -->

    <div class="modal-dialog">
        <!-- Contenedor principal del modal que define su estructura y tamaño. -->

        <div class="modal-content">
            <!-- Contenedor donde se agrupan los elementos del modal: encabezado, cuerpo y pie de página. -->

            <div class="modal-header">
                <!-- Sección del encabezado del modal, donde se muestra el título y el botón de cierre. -->
                <h5 class="modal-title" id="editProfileModalLabel">Editar Perfil</h5>
                <!-- Título del modal, asociado con 'aria-labelledby' para accesibilidad. -->

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                <!-- Botón de cierre para cerrar el modal sin necesidad de código adicional en JavaScript.
                     'data-bs-dismiss="modal"' indica que Bootstrap se encargará de la acción.
                     'aria-label="Cerrar"' mejora la accesibilidad para lectores de pantalla. -->
            </div>

            <div class="modal-body">
                <!-- Contenedor principal del formulario dentro del modal. -->
                <form id="editProfileForm" enctype="multipart/form-data">
                    <!-- Formulario con 'id="editProfileForm"' para identificarlo en el manejo con JavaScript.
                         'enctype="multipart/form-data"' permite el envío de archivos como la imagen de perfil. -->

                    <div class="mb-3">
                        <label for="edit-username" class="form-label">Usuario</label>
                        <!-- Etiqueta del campo de texto para el nombre de usuario. -->
                        <input type="text" class="form-control" id="edit-username" name="username" value="<?php echo $username; ?>">
                        <!-- Campo de texto donde se mostrará el nombre de usuario actual para su edición. -->
                    </div>

                    <div class="mb-3">
                        <label for="edit-email" class="form-label">Email</label>
                        <!-- Etiqueta del campo de email. -->
                        <input type="email" class="form-control" id="edit-email" name="email" value="<?php echo $email; ?>">
                        <!-- Campo para ingresar o modificar el correo electrónico del usuario. -->
                    </div>

                    <div class="mb-3">
                        <label for="edit-password" class="form-label">Contraseña</label>
                        <!-- Etiqueta para el campo de contraseña. -->
                        <input type="password" class="form-control" id="edit-password" name="password" placeholder="Dejar en blanco para no cambiar">
                        <!-- Campo de contraseña. Si el usuario no ingresa una nueva, la contraseña actual se mantiene. -->
                    </div>

                    <div class="mb-3">
                        <label for="edit-password-confirm" class="form-label">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="edit-password-confirm" name="password_confirm" placeholder="Repite la contraseña">
                    </div>


                    <div class="mb-3">
                        <label for="edit-user_image" class="form-label">Imagen de Perfil</label>
                        <!-- Etiqueta para el campo de selección de imagen. -->
                        <input type="file" class="form-control" id="edit-user_image" name="user_image" accept="image/*">
                        <!-- Campo para que el usuario seleccione una nueva imagen de perfil.
                             'accept="image/*"' restringe la selección a imágenes. -->
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <!-- Sección inferior del modal donde se incluyen los botones de acción. -->

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <!-- Botón de cancelar que cierra el modal sin guardar cambios.
                     'btn-secondary' le da un color gris neutro. -->

                <button type="button" class="btn btn-primary" id="saveProfileChanges">Guardar Cambios</button>
                <!-- Botón para guardar los cambios del usuario.
                     'id="saveProfileChanges"' facilita su control mediante JavaScript. -->
            </div>
        </div>
    </div>
</div>