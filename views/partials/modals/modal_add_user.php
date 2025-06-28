<!-- Modal: Agregar Usuario -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Agregar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body">
                <form id="addUserForm">
                  <div class="mb-3">
                    <label for="new-username" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="new-username" required>
                  </div>
                  <div class="mb-3">
                    <label for="new-email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="new-email" required>
                  </div>
                  <div class="mb-3">
                    <label for="new-password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="new-password" required>
                  </div>
                  <div class="mb-3">
                    <label for="new-level" class="form-label">Nivel</label>
                    <select id="new-level" class="form-select" required>
                      <?php foreach ($levels as $lvl): ?>
                        <option value="<?= $lvl['id_level_user'] ?>">
                          <?= htmlspecialchars($lvl['description_level']) ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveNewUserBtn">Guardar Usuario</button>
              </div>
            </div>
          </div>
        </div>
      