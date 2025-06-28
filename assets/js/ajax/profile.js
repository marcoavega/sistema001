document.addEventListener("DOMContentLoaded", function () {
  // Botón para abrir el modal de edición
  const editProfileBtn = document.getElementById("edit-profile-btn");
  const saveProfileChangesBtn = document.getElementById("saveProfileChanges");

  editProfileBtn.addEventListener("click", function () {
    const modal = new bootstrap.Modal(
      document.getElementById("editProfileModal")
    );
    modal.show();
  });

  // Botón para guardar cambios
  saveProfileChangesBtn.addEventListener("click", function () {
    const form = document.getElementById("editProfileForm");
    const formData = new FormData(form);

    const password = document.getElementById("edit-password").value;
    const confirmPassword = document.getElementById(
      "edit-password-confirm"
    ).value;

    // Validar que las contraseñas coincidan (solo si se ingresó una nueva contraseña)
    if (password !== "" && password !== confirmPassword) {
      alert("Las contraseñas no coinciden");
      return; // Detiene el envío del formulario
    }

    formData.append("username", document.getElementById("edit-username").value);
    formData.append("email", document.getElementById("edit-email").value);
    formData.append("password", password);

    fetch(BASE_URL + "api/profile.php?action=update", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (!response.ok) throw new Error("Error HTTP: " + response.status);
        return response.json();
      })
      .then((data) => {
        if (!data.success) {
          alert("Error al actualizar perfil: " + data.message);
        } else {
          alert("Perfil actualizado correctamente");
          location.reload();
        }
      })
      .catch((error) => {
        console.error("Error en la solicitud AJAX:", error);
      });
  });
  
});
