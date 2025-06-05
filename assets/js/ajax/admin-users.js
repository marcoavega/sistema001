// Este evento se dispara cuando el DOM (Document Object Model) ha sido completamente cargado.
// Espera a que la estructura HTML esté lista antes de ejecutar el código JavaScript.
document.addEventListener("DOMContentLoaded", function () {
  // Busca el elemento HTML con el ID "users-table" y lo almacena en la variable usersTableElement.
  var usersTableElement = document.getElementById("users-table");

  // Si no existe el elemento con ID "users-table" en el documento, termina la ejecución de la función.
  // Esto evita errores si el código se ejecuta en una página que no contiene dicha tabla.
  if (!usersTableElement) return;

  // Declara una variable global para almacenar temporalmente el ID del usuario que se desea eliminar.
  // Esta variable se utilizará más adelante en el proceso de confirmación de eliminación.
  var deleteUserID = null;

  // Inicializa la tabla de usuarios utilizando la biblioteca Tabulator.
  // Tabulator es una librería JavaScript para crear tablas interactivas.
  var table = new Tabulator("#users-table", {
    // Especifica qué campo se utilizará como índice único para cada fila (en este caso, user_id).
    index: "user_id",

    // URL desde donde se obtendrán los datos mediante una solicitud AJAX.
    // BASE_URL es una variable global definida en otro lugar del código.
    ajaxURL: BASE_URL + "api/users.php?action=get",

    // Configura el método HTTP para la solicitud AJAX (GET en este caso).
    ajaxConfig: "GET",

    // Configura el diseño de la tabla para que se ajuste automáticamente a las columnas.
    layout: "fitColumns",

    // Habilita el diseño responsive que colapsará columnas en pantallas pequeñas.
    responsiveLayout: "collapse",

    // Texto a mostrar mientras se cargan los datos de la tabla.
    placeholder: "Cargando usuarios...",

    // Define la estructura de columnas de la tabla.
    columns: [
      // Columna para el ID de usuario.
      {
        title: "ID", // Título que aparecerá en el encabezado de la columna.
        field: "user_id", // Nombre del campo en los datos JSON que corresponde a esta columna.
        width: 70, // Ancho de la columna en píxeles.
        sorter: "number", // Tipo de ordenamiento (numérico en este caso).
      },

      // Columna para el nombre de usuario.
      {
        title: "Usuario",
        field: "username",
      },

      // Columna para el email del usuario.
      {
        title: "Email",
        field: "email",
      },

      // Columna para el nivel de usuario (permisos).
      {
        title: "Nivel",
        field: "description_level",
        hozAlign: "center", // Alineación horizontal centrada.
      },

      // Columna para la fecha de creación.
      {
        title: "Creado",
        field: "created_at",
        // Función formateadora que convierte la fecha del formato ISO a DD/MM/YYYY.
        formatter: function (cell) {
          var value = cell.getValue(); // Obtiene el valor de la celda (fecha en formato ISO).
          var date = new Date(value); // Convierte la cadena de fecha a un objeto Date.

          // Verifica si la fecha es válida.
          if (isNaN(date.getTime())) {
            return ""; // Si no es válida, devuelve una cadena vacía.
          }

          // Extrae día, mes y año de la fecha.
          var day = date.getDate();
          var month = date.getMonth() + 1; // getMonth() devuelve 0-11, se suma 1 para obtener 1-12.
          var year = date.getFullYear();

          // Construye y devuelve la fecha formateada como DD/MM/YYYY.
          // Agrega un cero inicial a días y meses menores a 10.
          return (
            (day < 10 ? "0" + day : day) +
            "/" +
            (month < 10 ? "0" + month : month) +
            "/" +
            year
          );
        },
      },

      // Columna para la fecha de última actualización.
      {
        title: "Actualizado",
        field: "updated_at",
        // Función formateadora idéntica a la anterior para convertir la fecha a formato DD/MM/YYYY.
        formatter: function (cell) {
          var value = cell.getValue();
          var date = new Date(value);
          if (isNaN(date.getTime())) {
            return "";
          }
          var day = date.getDate();
          var month = date.getMonth() + 1;
          var year = date.getFullYear();
          return (
            (day < 10 ? "0" + day : day) +
            "/" +
            (month < 10 ? "0" + month : month) +
            "/" +
            year
          );
        },
      },

      // Columna para botones de acciones (editar y eliminar).
      {
        title: "Acciones",
        responsive: false, // Esta columna no se colapsará en pantallas pequeñas.
        hozAlign: "center", // Alineación horizontal centrada.
        width: 150, // Ancho de la columna en píxeles.

        // Función formateadora que genera HTML para los botones de acción.
        formatter: function () {
          return (
            "<div class='btn-group'>" +
            "<button class='btn btn-sm btn-info edit-btn me-1'>Editar</button>" +
            "<button class='btn btn-sm btn-danger delete-btn'>Eliminar</button>" +
            "</div>"
          );
        },

        // Manejador de eventos para los clics en las celdas de esta columna.
        cellClick: function (e, cell) {
          var rowData = cell.getRow().getData(); // Obtiene los datos de la fila clicada.

          // Verifica si se ha clicado en el botón de editar.
          if (e.target.classList.contains("edit-btn")) {
            // Rellena el formulario del modal de edición con los datos del usuario.
            document.getElementById("edit-user-id").value = rowData.user_id;
            document.getElementById("edit-username").value = rowData.username;
            document.getElementById("edit-email").value = rowData.email;
            document.getElementById("edit-level").value = rowData.level_user;

            // Crea una instancia del modal de Bootstrap y lo muestra.
            var editModal = new bootstrap.Modal(
              document.getElementById("editUserModal")
            );
            editModal.show();
          }

          // Verifica si se ha clicado en el botón de eliminar.
          if (e.target.classList.contains("delete-btn")) {
            // Almacena el ID del usuario a eliminar en la variable global.
            deleteUserID = rowData.user_id;

            // Crea una instancia del modal de confirmación de eliminación y lo muestra.
            var deleteModal = new bootstrap.Modal(
              document.getElementById("deleteUserModal")
            );
            deleteModal.show();
          }
        },
      },
    ],
  });

  // Configura el campo de búsqueda para filtrar la tabla.
  var searchInput = document.getElementById("table-search");
  if (searchInput) {
    // Agrega un evento que se dispara cada vez que el usuario escribe en el campo de búsqueda.
    searchInput.addEventListener("input", function () {
      var query = searchInput.value.toLowerCase(); // Convierte el texto de búsqueda a minúsculas.

      // Establece un filtro en la tabla basado en el texto de búsqueda.
      table.setFilter(function (data) {
        // Devuelve true si el nombre de usuario o el email contienen el texto de búsqueda.
        return (
          data.username.toLowerCase().includes(query) ||
          data.email.toLowerCase().includes(query)
        );
      });
    });
  }

  // Configura el evento de clic para el botón "Guardar cambios" del modal de edición.
  document
    .getElementById("saveChangesBtn")
    .addEventListener("click", function () {
      // Obtiene los valores de los campos del formulario de edición.
      var userID = document.getElementById("edit-user-id").value;
      var username = document.getElementById("edit-username").value;
      var email = document.getElementById("edit-email").value;
      var level = document.getElementById("edit-level").value;

      // Prepara los datos para enviar al servidor.
      var updateData = {
        user_id: parseInt(userID), // Convierte el ID a número entero.
        username: username,
        email: email,
        level_user: parseInt(level), // Convierte el nivel a número entero.
      };

      // Realiza una solicitud FETCH al servidor para actualizar el usuario.
      fetch(BASE_URL + "api/users.php?action=update", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ userData: updateData }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (!data.success) {
            alert("Error al actualizar usuario: " + data.message);
          } else {
            alert("Usuario actualizado correctamente");

            // ✅ Aquí está el cambio importante:
            table
              .updateOrAddData([data.updatedData])
              .then(() => {
                console.log("Registro actualizado en la tabla");
              })
              .catch((err) => {
                console.error("Error actualizando registro:", err);
              });

            var modalEl = document.getElementById("editUserModal");
            var modalInstance = bootstrap.Modal.getInstance(modalEl);
            modalInstance.hide();
          }
        })
        .catch((error) => {
          console.error("Error en la solicitud AJAX:", error);
        });
    });

  // Configura el evento de clic para el botón de confirmación de eliminación.
  document
    .getElementById("confirmDeleteBtn")
    .addEventListener("click", function () {
      // Verifica si hay un ID de usuario a eliminar.
      if (!deleteUserID) return;

      // Realiza una solicitud FETCH al servidor para eliminar el usuario.
      fetch(BASE_URL + "api/users.php?action=delete", {
        method: "POST", // Método HTTP de la solicitud.
        headers: { "Content-Type": "application/json" }, // Tipo de contenido JSON.
        body: JSON.stringify({ user_id: parseInt(deleteUserID) }), // Convierte el ID a JSON.
      })
        .then((response) => response.json()) // Convierte la respuesta a JSON.
        .then((data) => {
          // Verifica si la eliminación fue exitosa.
          if (!data.success) {
            // Si hubo un error, muestra una alerta con el mensaje de error.
            alert("Error al eliminar usuario: " + data.message);
          } else {
            // Si la eliminación fue exitosa, muestra un mensaje de éxito.
            alert("Usuario eliminado correctamente");

            // Elimina la fila correspondiente de la tabla.
            table
              .deleteRow(deleteUserID)
              .then(() => {
                console.log("Registro eliminado");
              })
              .catch((err) => {
                console.error("Error eliminando registro:", err);
              });

            // Restablece la variable global y cierra el modal de confirmación.
            deleteUserID = null;
            var modalEl = document.getElementById("deleteUserModal");
            var modalInstance = bootstrap.Modal.getInstance(modalEl);
            modalInstance.hide();
          }
        })
        .catch((error) => {
          // Captura cualquier error en la solicitud AJAX.
          console.error("Error en la solicitud AJAX:", error);
        });
    });

  // Realiza una solicitud para obtener los datos de la empresa.
  let companyData = {};
  fetch("api/get_company.php")
    .then((response) => response.json())
    .then((data) => {
      companyData = data;
      console.log("Datos de la empresa:", companyData);
    })
    .catch((error) => {
      console.error("Error al obtener los datos de la empresa:", error);
    });

  // Configura el evento de clic para el botón de exportación a CSV.
  document
    .getElementById("exportCSVBtn")
    .addEventListener("click", function () {
      const datos = table.getData();

      // Construimos las líneas manualmente
      let csvContent = "";
      csvContent += `"REPORTE DE LISTA DE USUARIOS"\n`;
      csvContent += `"EMPRESA DEMO S.A. DE C.V."\n`;
      csvContent += `"Formato: L001"\n\n`;

      // Agregar encabezados
      const headers = [
        "ID",
        "Usuario",
        "Email",
        "Nivel",
        "Creado",
        "Actualizado",
      ];
      csvContent += headers.join(",") + "\n";

      // Agregar filas de datos
      datos.forEach((row) => {
        csvContent +=
          [
            row.user_id,
            row.username,
            row.email,
            row.description_level,
            row.created_at,
            row.updated_at,
          ].join(",") + "\n";
      });

      // Crear archivo y forzar descarga
      const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
      const url = URL.createObjectURL(blob);
      const a = document.createElement("a");
      a.href = url;
      a.download = "usuarios.csv";
      a.click();
      URL.revokeObjectURL(url);
    });

  // Configura el evento de clic para el botón de exportación a Excel.
  document
    .getElementById("exportExcelBtn")
    .addEventListener("click", function () {
      // Prepara los datos para la exportación, omitiendo la columna 'img_url'.
      const dataToExport = table.getData().map((row) => {
        const { img_url, ...filteredRow } = row; // Desestructura el objeto para omitir img_url.
        return filteredRow;
      });

      // Descarga los datos como archivo Excel con configuraciones adicionales.
      table.download("xlsx", "usuarios.xlsx", {
        sheetName: "Reporte Usuarios", // Nombre de la hoja en el archivo Excel.
        documentProcessing: function (workbook) {
          // Personaliza el estilo de la primera celda (A1) en el archivo Excel.
          const sheet = workbook.Sheets["Reporte Usuarios"];
          sheet["A1"].s = { font: { bold: true, color: { rgb: "FF0000" } } };
          return workbook;
        },
        rows: dataToExport, // Usa los datos filtrados para la exportación.
      });
    });

  // Configura el evento de clic para el botón de exportación a JSON.
  document
    .getElementById("exportPDFBtn")
    .addEventListener("click", function () {
      console.log("Botón de exportación PDF presionado.");
      try {
        if (!table) {
          console.error("El objeto 'table' no está definido.");
          return;
        }

        table.download("pdf", "usuarios.pdf", {
          orientation: "landscape",
          autoTable: {
            styles: {
              fontSize: 8,
              cellPadding: 2,
              halign: "center",
            },
            margin: { top: 70, left: 10, right: 10 }, // margen superior más grande
            headStyles: {
              fillColor: [22, 160, 133],
              textColor: 255,
              fontStyle: "bold",
              halign: "center",
            },
            bodyStyles: {
              halign: "center",
            },
            theme: "striped",
            columns: [
              { header: "ID", dataKey: "user_id" },
              { header: "Usuario", dataKey: "username" },
              { header: "Email", dataKey: "email" },
              { header: "Nivel", dataKey: "description_level" },
              { header: "Creado", dataKey: "created_at" },
              { header: "Actualizado", dataKey: "updated_at" },
            ],
            didDrawPage: function (data) {
              const doc = data.doc;
              const pageWidth = doc.internal.pageSize.getWidth();

              // Coordenadas Y iniciales
              let y = 25;

              // TÍTULO
              doc.setFontSize(16);
              doc.setFont(undefined, "bold");
              doc.text("REPORTE DE LISTA DE USUARIOS", pageWidth / 2, y, {
                align: "center",
              });

              // ESPACIO
              y += 10;

              // NOMBRE DE EMPRESA
              doc.setFontSize(12);
              doc.setFont(undefined, "normal");
              doc.text("EMPRESA DEMO S.A. DE C.V.", pageWidth / 2, y, {
                align: "center",
              });

              // ESPACIO
              y += 10;

              // FORMATO
              doc.setFontSize(10);
              doc.text("Formato: L001", pageWidth / 2, y, {
                align: "center",
              });

              // FECHA en la esquina inferior izquierda del encabezado
              doc.setFontSize(9);
              doc.text(
                "Generado: " + new Date().toLocaleDateString(),
                data.settings.margin.left,
                y + 10
              );
            },
          },
        });
      } catch (e) {
        console.error("Error en el handler de exportación PDF:", e);
      }
    });

  // Código para el botón de agregar usuario y su modal.
  // Obtiene referencias a los elementos necesarios.
  const addUserBtn = document.getElementById("addUserBtn");
  const addUserModal = new bootstrap.Modal(
    document.getElementById("addUserModal")
  );

  // Configura el evento de clic para mostrar el modal de agregar usuario.
  addUserBtn.addEventListener("click", () => addUserModal.show());

  // Configura el evento de clic para el botón de guardar nuevo usuario.
  document.getElementById("saveNewUserBtn").addEventListener("click", () => {
    const username = document.getElementById("new-username").value.trim();
    const email = document.getElementById("new-email").value.trim();
    const password = document.getElementById("new-password").value;

    const selectElement = document.getElementById("new-level"); // ← Cambiado aquí
    const levelNew = selectElement.value;
    const descriptionLevel =
      selectElement.options[selectElement.selectedIndex].text.trim();

    fetch(BASE_URL + "api/users.php?action=create", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        userData: { username, email, password, level_user: levelNew },
      }),
    })
      .then((res) => res.json())
      .then((data) => {
        if (!data.success) {
          alert("Error al crear usuario: " + data.message);
        } else {
          data.newUser.description_level = descriptionLevel;
          table.addData([data.newUser]).then(() => {
            addUserModal.hide();
          });
        }
      })
      .catch((err) => console.error("Error:", err));
  });

  // Cierre de la función principal que se ejecuta cuando el DOM está cargado.
});
