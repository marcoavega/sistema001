/// Archivo: assets/js/ajax/products-table.js

document.addEventListener("DOMContentLoaded", function () {
  // 🟡 Función reutilizable para cerrar modal y mover foco
  function cerrarModalYReenfocar(modalId, focusTargetId) {
    const modalEl = document.getElementById(modalId);
    if (!modalEl) return;
    if (document.activeElement instanceof HTMLElement) {
      document.activeElement.blur();
    }
    const modalInst = bootstrap.Modal.getInstance(modalEl);
    if (modalInst) {
      modalInst.hide();
    }
    if (focusTargetId) {
      setTimeout(() => {
        document.getElementById(focusTargetId)?.focus();
      }, 300);
    }
  }

  // Blur en botones data-bs-dismiss para evitar warnings de aria-hidden
  document.querySelectorAll('[data-bs-dismiss="modal"]').forEach(btn => {
    btn.addEventListener('click', () => btn.blur());
  });
  ["addProductModal", "editProductModal", "deleteProductModal"].forEach(modalId => {
    const modalEl = document.getElementById(modalId);
    if (modalEl) {
      modalEl.addEventListener('hide.bs.modal', function () {
        const active = document.activeElement;
        if (active && modalEl.contains(active)) {
          active.blur();
        }
      });
    }
  });

  // Contenedor de la tabla
  var productsTableElement = document.getElementById("products-table");
  if (!productsTableElement) return; // No inicializamos si no existe

  // Variable temporal para ID de producto a eliminar/editar
  var deleteProductID = null;

  // Inicializa Tabulator con paginación remota
  console.log("Inicializando Tabulator con paginación remota...");
  var table = new Tabulator("#products-table", {
    layout: "fitColumns",
    responsiveLayout: "collapse",
    placeholder: "Cargando productos...",
    pagination: "remote",            // activa paginación remota
    paginationSize: 20,              // filas por página inicial
    paginationSizeSelector: [10, 20, 50, 100], // selector opcional
    ajaxURL: BASE_URL + "api/products.php?action=list", // endpoint paginado
    ajaxConfig: "GET",
    ajaxParams: {},                  // si quieres filtros iniciales, déjalo {}
    ajaxResponse: function (url, params, response) {
      return response.data;
    },
    paginationDataReceived: {
      "last_page": "last_page",      // clave de la respuesta JSON con total de páginas
      "data": "data"                 // clave de la respuesta JSON con el array de filas
    },
    ajaxRequesting: function (url, params) {
      console.log("Tabulator request:", url, params);
    },
    columns: [
      {
        title: "ID",
        field: "product_id",
        width: 70,
        sorter: "number",
        hozAlign: "center",
      },
      {
        title: "Código",
        field: "product_code",
      },
      {
        title: "Nombre",
        field: "product_name",
      },
      {
        title: "Ubicación",
        field: "location",
      },
      {
        title: "Precio",
        field: "price",
        hozAlign: "right",
        formatter: "money",
        formatterParams: {
          symbol: "",
          precision: 2,
        },
      },
      {
        title: "Stock",
        field: "stock",
        sorter: "number",
        hozAlign: "center",
      },
      {
        title: "Registrado",
        field: "registration_date",
        formatter: function (cell) {
          var value = cell.getValue();
          var date = new Date(value);
          if (isNaN(date.getTime())) return "";
          var day = date.getDate(), month = date.getMonth() + 1, year = date.getFullYear();
          return (day < 10 ? "0" + day : day) + "/" + (month < 10 ? "0" + month : month) + "/" + year;
        },
      },
      {
        title: "Imagen",
        field: "image_url",
        formatter: function (cell) {
          var row = cell.getData();
          if (!row.image_url) return "";
          var version = row.image_version || Date.now();
          var src = BASE_URL + row.image_url + "?v=" + version;
          return "<img src='" + src + "' style='max-height:50px; max-width:50px;' alt='Imagen' loading='lazy' />";
        },
        hozAlign: "center",
        width: 80,
      },
      {
        title: "Acciones",
        hozAlign: "center",
        responsive: false,
        formatter: function () {
          return (
            "<div class='btn-group'>" +
            "<button class='btn btn-sm btn-info edit-btn me-1'>Editar</button>" +
            "<button class='btn btn-sm btn-danger delete-btn'>Eliminar</button>" +
            "</div>"
          );
        },
        cellClick: function (e, cell) {
          var rowData = cell.getRow().getData();
          if (e.target.classList.contains("edit-btn")) {
            // Rellenar formulario de edición con rowData
            var editIdEl = document.getElementById("edit-product-id");
            if (editIdEl) editIdEl.value = rowData.product_id;
            var editCodeEl = document.getElementById("edit-product-code");
            if (editCodeEl) editCodeEl.value = rowData.product_code || "";
            var editNameEl = document.getElementById("edit-product-name");
            if (editNameEl) editNameEl.value = rowData.product_name || "";
            var editLocationEl = document.getElementById("edit-location");
            if (editLocationEl) editLocationEl.value = rowData.location || "";
            var editPriceEl = document.getElementById("edit-price");
            if (editPriceEl) editPriceEl.value = rowData.price ?? "";
            var editStockEl = document.getElementById("edit-stock");
            if (editStockEl) editStockEl.value = rowData.stock ?? "";
            var editCategoryEl = document.getElementById("edit-category");
            if (editCategoryEl) editCategoryEl.value = rowData.category_id ?? "";
            var editSupplierEl = document.getElementById("edit-supplier");
            if (editSupplierEl) editSupplierEl.value = rowData.supplier_id ?? "";
            var editUnitEl = document.getElementById("edit-unit");
            if (editUnitEl) editUnitEl.value = rowData.unit_id ?? "";
            var editCurrencyEl = document.getElementById("edit-currency");
            if (editCurrencyEl) editCurrencyEl.value = rowData.currency_id ?? "";
            var editSubcategoryEl = document.getElementById("edit-subcategory");
            if (editSubcategoryEl) editSubcategoryEl.value = rowData.subcategory_id ?? "";
            var editDesiredStockEl = document.getElementById("edit-desired-stock");
            if (editDesiredStockEl) editDesiredStockEl.value = rowData.desired_stock ?? "";
            var editStatusEl = document.getElementById("edit-status");
            if (editStatusEl) editStatusEl.value = rowData.status != null ? rowData.status : "1";
            // Mostrar modal edición
            var editModalEl = document.getElementById("editProductModal");
            if (editModalEl) new bootstrap.Modal(editModalEl).show();
          }
          if (e.target.classList.contains("delete-btn")) {
            deleteProductID = rowData.product_id;
            var deleteModalEl = document.getElementById("deleteProductModal");
            if (deleteModalEl) new bootstrap.Modal(deleteModalEl).show();
          }
        },
      },
    ],
  });

  // BÚSQUEDA local en la página actual (si deseas búsqueda remota, cambia la lógica)
  var searchInput = document.getElementById("table-search");
  if (searchInput) {
    searchInput.addEventListener("input", function () {
      var q = searchInput.value.toLowerCase();
      table.setFilter(function (data) {
        return (
          (data.product_code || "").toString().toLowerCase().includes(q) ||
          (data.product_name || "").toString().toLowerCase().includes(q)
        );
      });
    });
  }

  // CRUD: crear nuevo producto
  var saveNewProductBtn = document.getElementById("saveNewProductBtn");
  if (saveNewProductBtn) {
    saveNewProductBtn.addEventListener("click", function () {
      var formData = new FormData();
      // Recoge valores de inputs del modal "addProductModal"
      var newCodeEl = document.getElementById("new-product-code");
      if (newCodeEl) formData.append("product_code", newCodeEl.value.trim());
      var newNameEl = document.getElementById("new-product-name");
      if (newNameEl) formData.append("product_name", newNameEl.value.trim());
      var newLocationEl = document.getElementById("new-location");
      if (newLocationEl) formData.append("location", newLocationEl.value.trim());
      var newPriceEl = document.getElementById("new-price");
      if (newPriceEl) formData.append("price", newPriceEl.value);
      var newStockEl = document.getElementById("new-stock");
      if (newStockEl) formData.append("stock", newStockEl.value);
      var categoryEl = document.getElementById("new-category");
      if (categoryEl) formData.append("category_id", categoryEl.value);
      var supplierEl = document.getElementById("new-supplier");
      if (supplierEl) formData.append("supplier_id", supplierEl.value);
      var unitEl = document.getElementById("new-unit");
      if (unitEl) formData.append("unit_id", unitEl.value);
      var currencyEl = document.getElementById("new-currency");
      if (currencyEl) formData.append("currency_id", currencyEl.value);
      var subcategoryEl = document.getElementById("new-subcategory");
      if (subcategoryEl) formData.append("subcategory_id", subcategoryEl.value);
      var desiredStockEl = document.getElementById("new-desired-stock");
      if (desiredStockEl) formData.append("desired_stock", desiredStockEl.value);
      var statusEl = document.getElementById("new-status");
      if (statusEl) formData.append("status", statusEl.value);
      var imageEl = document.getElementById("new-image");
      if (imageEl && imageEl.files && imageEl.files.length > 0) {
        formData.append("image_file", imageEl.files[0]);
      }

      // Validaciones básicas antes de enviar (Código y nombre obligatorios, etc.)
      if (!formData.get("product_code") || !formData.get("product_name")) {
        Swal.fire({ icon: 'warning', title: 'Código y nombre obligatorios', toast: true, position: 'top-end', timer: 3000, showConfirmButton: false });
        return;
      }
      // Puedes añadir más validaciones aquí...

      fetch(BASE_URL + "api/products.php?action=create", {
        method: "POST",
        body: formData
      })
        .then(res => {
          if (!res.ok) {
            return res.text().then(text => {
              console.error("Error al crear producto. Status:", res.status, "Body:", text);
              throw new Error("Error al crear producto");
            });
          }
          return res.json();
        })
        .then(data => {
          if (data.success) {
            Swal.fire({
              icon: "success",
              title: "Producto registrado con éxito",
              toast: true,
              position: "top-end",
              timer: 2000,
              showConfirmButton: false
            });
            cerrarModalYReenfocar("addProductModal", "addProductBtn");

            // ✅ Recargar datos desde el servidor
            table.replaceData();
          } else {
            Swal.fire({ icon: 'error', title: 'Error al crear producto', text: data.message || '' });
          }
        })
        .catch(err => {
          console.error(err);
          Swal.fire({ icon: 'error', title: 'Error en creación' });
        });
    });
  }

  // CRUD: editar producto
  var saveEditProductBtn = document.getElementById("saveEditProductBtn");
  if (saveEditProductBtn) {
    saveEditProductBtn.addEventListener("click", function () {
      var formData = new FormData();
      // Recoge valores de inputs del modal "editProductModal"
      var idEl = document.getElementById("edit-product-id");
      if (idEl) formData.append("product_id", idEl.value);
      var codeEl = document.getElementById("edit-product-code");
      if (codeEl) formData.append("product_code", codeEl.value.trim());
      var nameEl = document.getElementById("edit-product-name");
      if (nameEl) formData.append("product_name", nameEl.value.trim());
      var locationEl = document.getElementById("edit-location");
      if (locationEl) formData.append("location", locationEl.value.trim());
      var priceEl = document.getElementById("edit-price");
      if (priceEl) formData.append("price", priceEl.value);
      var stockEl = document.getElementById("edit-stock");
      if (stockEl) formData.append("stock", stockEl.value);
      var categoryEl2 = document.getElementById("edit-category");
      if (categoryEl2) formData.append("category_id", categoryEl2.value);
      var supplierEl2 = document.getElementById("edit-supplier");
      if (supplierEl2) formData.append("supplier_id", supplierEl2.value);
      var unitEl2 = document.getElementById("edit-unit");
      if (unitEl2) formData.append("unit_id", unitEl2.value);
      var currencyEl2 = document.getElementById("edit-currency");
      if (currencyEl2) formData.append("currency_id", currencyEl2.value);
      var subcategoryEl2 = document.getElementById("edit-subcategory");
      if (subcategoryEl2) formData.append("subcategory_id", subcategoryEl2.value);
      var desiredStockEl2 = document.getElementById("edit-desired-stock");
      if (desiredStockEl2) formData.append("desired_stock", desiredStockEl2.value);
      var statusEl2 = document.getElementById("edit-status");
      if (statusEl2) formData.append("status", statusEl2.value);
      var imageEl2 = document.getElementById("edit-image");
      if (imageEl2 && imageEl2.files && imageEl2.files.length > 0) {
        formData.append("image_file", imageEl2.files[0]);
      }

      // Validaciones básicas antes de enviar
      if (!formData.get("product_id") || !formData.get("product_code") || !formData.get("product_name")) {
        Swal.fire({ icon: 'warning', title: 'Código y nombre obligatorios', toast: true, position: 'top-end', timer: 3000, showConfirmButton: false });
        return;
      }

      fetch(BASE_URL + "api/products.php?action=update", {
        method: "POST",
        body: formData
      })
        .then(res => {
          if (!res.ok) {
            return res.text().then(text => {
              console.error("Error al actualizar producto. Status:", res.status, "Body:", text);
              throw new Error("Error al actualizar producto");
            });
          }
          return res.json();
        })
        .then(data => {
          if (data.success) {
            Swal.fire({
              icon: "success",
              title: "Producto actualizado con éxito",
              toast: true,
              position: "top-end",
              timer: 2000,
              showConfirmButton: false
            });
            cerrarModalYReenfocar("editProductModal", "table-search");
            // Recarga la página actual para reflejar cambios
           table.replaceData(); // ✅ Recarga datos desde el servidor
          } else {
            Swal.fire({ icon: 'error', title: 'Error al actualizar', text: data.message || '' });
          }
        })
        .catch(err => {
          console.error(err);
          Swal.fire({ icon: 'error', title: 'Error en edición' });
        });
    });
  }

  // CRUD: eliminar producto
  var confirmDeleteBtn = document.getElementById("confirmDeleteProductBtn");
  if (confirmDeleteBtn) {
    confirmDeleteBtn.addEventListener("click", function () {
      if (!deleteProductID) return;
      fetch(BASE_URL + "api/products.php?action=delete", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ product_id: deleteProductID }),
      })
        .then(res => {
          if (!res.ok) {
            return res.text().then(text => {
              console.error("Error al eliminar producto. Status:", res.status, "Body:", text);
              throw new Error("Error al eliminar producto");
            });
          }
          return res.json();
        })
        .then(data => {
          if (data.success) {
            Swal.fire({
              icon: "success",
              title: "Producto eliminado con éxito",
              toast: true,
              position: "top-end",
              timer: 2000,
              showConfirmButton: false
            });
            // Recarga la página actual para reflejar la eliminación
            table.replaceData();
            deleteProductID = null;
            cerrarModalYReenfocar("deleteProductModal", "table-search");
          } else {
            Swal.fire({ icon: 'error', title: 'Error al eliminar', text: data.message || '' });
          }
        })
        .catch(err => {
          console.error(err);
          Swal.fire({ icon: 'error', title: 'Error en eliminación' });
        });
    });
  }

  // EXPORTAR CSV
  var exportCSVBtn = document.getElementById("exportCSVBtn");
  if (exportCSVBtn) {
    exportCSVBtn.addEventListener("click", function () {
      var datos = table.getData();
      let csvContent = "";
      csvContent += `"REPORTE DE LISTA DE PRODUCTOS"\n`;
      csvContent += `"Formato: L001"\n\n`;
      // Encabezados
      const headers = [
        "ID",
        "Código",
        "Nombre",
        "Ubicación",
        "Precio",
        "Stock",
        "Registrado",
      ];
      csvContent += headers.join(",") + "\n";
      datos.forEach((row) => {
        let fecha = "";
        if (row.registration_date) {
          const d = new Date(row.registration_date);
          if (!isNaN(d.getTime())) {
            const day = String(d.getDate()).padStart(2, "0");
            const month = String(d.getMonth() + 1).padStart(2, "0");
            const year = d.getFullYear();
            fecha = `${day}/${month}/${year}`;
          }
        }
        csvContent +=
          [
            row.product_id,
            `"${row.product_code}"`,
            `"${row.product_name}"`,
            `"${row.location}"`,
            row.price,
            row.stock,
            `"${fecha}"`,
          ].join(",") + "\n";
      });
      const blob = new Blob([csvContent], {
        type: "text/csv;charset=utf-8;",
      });
      const url = URL.createObjectURL(blob);
      const a = document.createElement("a");
      a.href = url;
      a.download = "productos.csv";
      a.click();
      URL.revokeObjectURL(url);
    });
  }

  // EXPORTAR EXCEL
  var exportExcelBtn = document.getElementById("exportExcelBtn");
  if (exportExcelBtn) {
    exportExcelBtn.addEventListener("click", function () {
      const dataToExport = table.getData().map((row) => {
        const { /*image_url,*/ ...filtered } = row;
        return filtered;
      });
      table.download("xlsx", "productos.xlsx", {
        sheetName: "Reporte Productos",
        documentProcessing: function (workbook) {
          const sheet = workbook.Sheets["Reporte Productos"];
          sheet["A1"].s = { font: { bold: true } };
          return workbook;
        },
        rows: dataToExport,
      });
    });
  }

  // EXPORTAR JSON
  var exportJSONBtn = document.getElementById("exportJSONBtn");
  if (exportJSONBtn) {
    exportJSONBtn.addEventListener("click", function () {
      table.download("json", "productos.json");
    });
  }

  // EXPORTAR PDF
  var exportPDFBtn = document.getElementById("exportPDFBtn");
  if (exportPDFBtn) {
    exportPDFBtn.addEventListener("click", function () {
      console.log("Botón de exportación PDF presionado.");
      try {
        if (!table) {
          console.error("El objeto 'table' no está definido.");
          return;
        }
        table.download("pdf", "productos.pdf", {
          orientation: "landscape",
          autoTable: {
            styles: {
              fontSize: 8,
              cellPadding: 2,
              halign: "center",
            },
            margin: { top: 70, left: 10, right: 10 },
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
              { header: "ID", dataKey: "product_id" },
              { header: "Código", dataKey: "product_code" },
              { header: "Nombre", dataKey: "product_name" },
              { header: "Ubicación", dataKey: "location" },
              { header: "Precio", dataKey: "price" },
              { header: "Stock", dataKey: "stock" },
              { header: "Registrado", dataKey: "registration_date" },
            ],
            didDrawPage: function (data) {
              const doc = data.doc;
              const pageWidth = doc.internal.pageSize.getWidth();
              let y = 25;
              // TÍTULO CENTRADO
              doc.setFontSize(16);
              doc.setFont(undefined, "bold");
              doc.text("REPORTE DE LISTA DE PRODUCTOS", pageWidth / 2, y, { align: "center" });
              y += 10;
              // FORMATO
              doc.setFontSize(10);
              doc.setFont(undefined, "normal");
              doc.text("Formato: L001", pageWidth / 2, y, { align: "center" });
              // Fecha generación
              y += 10;
              doc.setFontSize(9);
              doc.text("Generado: " + new Date().toLocaleDateString(), data.settings.margin.left, y);
            },
          },
        });
      } catch (e) {
        console.error("Error en el handler de exportación PDF:", e);
      }
    });
  }
});
