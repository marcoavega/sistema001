// Archivo: assets/js/ajax/products-table.js

document.addEventListener("DOMContentLoaded", function () {
  // Contenedor de la tabla
  var productsTableElement = document.getElementById("products-table");
  if (!productsTableElement) return; // No cargamos nada si no existe el contenedor

  // Variable temporal para ID de producto a eliminar/editar
  var deleteProductID = null;

  // Inicializa Tabulator
  var table = new Tabulator("#products-table", {
    index: "product_id",
    ajaxURL: BASE_URL + "api/products.php?action=get",
    ajaxConfig: "GET",
    layout: "fitColumns",
    responsiveLayout: "collapse",
    placeholder: "Cargando productos...",
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
        headerFilter: false,
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
          symbol: "", // Si deseas símbolo, ej. "$"
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
          // EDITAR
          if (e.target.classList.contains("edit-btn")) {
            // Rellenar formulario de edición con datos del producto
            var editIdEl = document.getElementById("edit-product-id");
            var editCodeEl = document.getElementById("edit-product-code");
            var editNameEl = document.getElementById("edit-product-name");
            var editLocationEl = document.getElementById("edit-location");
            var editPriceEl = document.getElementById("edit-price");
            var editStockEl = document.getElementById("edit-stock");
            var editCategoryEl = document.getElementById("edit-category");
            var editSupplierEl = document.getElementById("edit-supplier");
            var editUnitEl = document.getElementById("edit-unit");
            var editCurrencyEl = document.getElementById("edit-currency");
            var editSubcategoryEl = document.getElementById("edit-subcategory");
            var editDesiredStockEl = document.getElementById("edit-desired-stock");
            var editStatusEl = document.getElementById("edit-status");
            // Asumimos que rowData tiene las claves exactas: product_id, product_code, product_name, location, price, stock,
            // category_id, supplier_id, unit_id, currency_id, subcategory_id, desired_stock, status, image_url (si aplica).
            if (
              editIdEl &&
              editCodeEl &&
              editNameEl &&
              editLocationEl &&
              editPriceEl &&
              editStockEl &&
              editCategoryEl &&
              editSupplierEl &&
              editUnitEl &&
              editCurrencyEl &&
              editSubcategoryEl &&
              editDesiredStockEl &&
              editStatusEl
            ) {
              editIdEl.value = rowData.product_id;
              editCodeEl.value = rowData.product_code;
              editNameEl.value = rowData.product_name;
              editLocationEl.value = rowData.location;
              editPriceEl.value = rowData.price;
              editStockEl.value = rowData.stock;
              editCategoryEl.value = rowData.category_id;
              editSupplierEl.value = rowData.supplier_id;
              editUnitEl.value = rowData.unit_id;
              editCurrencyEl.value = rowData.currency_id;
              editSubcategoryEl.value = rowData.subcategory_id;
              editDesiredStockEl.value = rowData.desired_stock ?? "";
              editStatusEl.value = rowData.status != null ? rowData.status : "1";
            }
            // Mostrar modal edición si existe
            var editModalEl = document.getElementById("editProductModal");
            if (editModalEl) {
              var editModal = new bootstrap.Modal(editModalEl);
              editModal.show();
            }
          }
          // ELIMINAR
          if (e.target.classList.contains("delete-btn")) {
            deleteProductID = rowData.product_id;
            var deleteModalEl = document.getElementById("deleteProductModal");
            if (deleteModalEl) {
              var deleteModal = new bootstrap.Modal(deleteModalEl);
              deleteModal.show();
            }
          }
        },
      },
    ],
  });

  // BÚSQUEDA / FILTRO
  var searchInput = document.getElementById("table-search");
  if (searchInput) {
    searchInput.addEventListener("input", function () {
      var query = searchInput.value.toLowerCase();
      table.setFilter(function (data) {
        return (
          (data.product_code || "")
            .toString()
            .toLowerCase()
            .includes(query) ||
          (data.product_name || "")
            .toString()
            .toLowerCase()
            .includes(query)
        );
      });
    });
  }

  // GUARDAR EDICIÓN
  var saveEditBtn = document.getElementById("saveEditProductBtn");
  if (saveEditBtn) {
    saveEditBtn.addEventListener("click", function () {
      // Leer valores del formulario de edición
      var idEl = document.getElementById("edit-product-id");
      var codeEl = document.getElementById("edit-product-code");
      var nameEl = document.getElementById("edit-product-name");
      var locationEl = document.getElementById("edit-location");
      var priceEl = document.getElementById("edit-price");
      var stockEl = document.getElementById("edit-stock");
      var categoryEl = document.getElementById("edit-category");
      var supplierEl = document.getElementById("edit-supplier");
      var unitEl = document.getElementById("edit-unit");
      var currencyEl = document.getElementById("edit-currency");
      var subcategoryEl = document.getElementById("edit-subcategory");
      var desiredStockEl = document.getElementById("edit-desired-stock");
      var statusEl = document.getElementById("edit-status");

      if (!(idEl && codeEl && nameEl && locationEl && priceEl && stockEl && categoryEl && supplierEl && unitEl && currencyEl && subcategoryEl && desiredStockEl && statusEl)) {
        console.error("Faltan campos en el formulario de edición");
        return;
      }

      var id = parseInt(idEl.value, 10);
      var code = codeEl.value.trim();
      var name = nameEl.value.trim();
      var location = locationEl.value.trim();
      var price = parseFloat(priceEl.value);
      var stock = parseInt(stockEl.value, 10);
      var categoryId = categoryEl.value ? parseInt(categoryEl.value,10) : null;
      var supplierId = supplierEl.value ? parseInt(supplierEl.value,10) : null;
      var unitId = unitEl.value ? parseInt(unitEl.value,10) : null;
      var currencyId = currencyEl.value ? parseInt(currencyEl.value,10) : null;
      var subcategoryId = subcategoryEl.value ? parseInt(subcategoryEl.value,10) : null;
      var desiredStock = desiredStockEl.value ? parseInt(desiredStockEl.value,10) : null;
      var status = statusEl.value ? parseInt(statusEl.value,10) : 1;

      // Validaciones básicas
      if (!code || !name) {
        alert("Código y nombre son obligatorios.");
        return;
      }
      if (isNaN(price) || isNaN(stock)) {
        alert("Precio y stock deben ser números válidos.");
        return;
      }
      // Validar FK obligatorios
      if (categoryId === null) {
        alert("Selecciona una categoría.");
        return;
      }
      if (supplierId === null) {
        alert("Selecciona un proveedor.");
        return;
      }
      if (unitId === null) {
        alert("Selecciona una unidad.");
        return;
      }
      if (currencyId === null) {
        alert("Selecciona una moneda.");
        return;
      }
      if (subcategoryId === null) {
        alert("Selecciona una subcategoría.");
        return;
      }

      var productData = {
        product_id: id,
        product_code: code,
        product_name: name,
        location: location,
        price: price,
        stock: stock,
        category_id: categoryId,
        supplier_id: supplierId,
        unit_id: unitId,
        currency_id: currencyId,
        subcategory_id: subcategoryId,
        desired_stock: desiredStock,
        status: status
        // Otros opcionales que quieras manejar
      };

      fetch(BASE_URL + "api/products.php?action=update", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          product_id: id,
          productData: productData,
        }),
      })
        .then((res) => {
          if (!res.ok) {
            return res.text().then((text) => {
              console.error("Error al actualizar producto. Status:", res.status, "Body:", text);
              throw new Error("Error al actualizar producto. Revisa consola.");
            });
          }
          return res.json().catch((err) => {
            console.error("No se pudo parsear JSON en actualización:", err);
            throw new Error("Respuesta inválida del servidor.");
          });
        })
        .then((data) => {
          if (!data.success) {
            alert("Error al actualizar producto: " + (data.message || ""));
          } else {
            alert("Producto actualizado correctamente");
            if (data.product) {
              table.updateOrAddData([data.product]).catch((err) => {
                console.error("Error actualizando fila en tabla:", err);
              });
            } else {
              console.warn("No se devolvió data.product al actualizar.");
            }
            // Cerrar modal
            var modalEl = document.getElementById("editProductModal");
            if (modalEl) {
              var modalInst = bootstrap.Modal.getInstance(modalEl);
              if (modalInst) modalInst.hide();
            }
          }
        })
        .catch((err) => {
          console.error("Error en solicitud AJAX edición:", err);
          alert(err.message);
        });
    });
  }

  // CONFIRMAR ELIMINAR
  var confirmDeleteBtn = document.getElementById("confirmDeleteProductBtn");
  if (confirmDeleteBtn) {
    confirmDeleteBtn.addEventListener("click", function () {
      if (!deleteProductID) return;
      fetch(BASE_URL + "api/products.php?action=delete", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ product_id: deleteProductID }),
      })
        .then((res) => {
          if (!res.ok) {
            return res.text().then((text) => {
              console.error("Error al eliminar producto. Status:", res.status, "Body:", text);
              throw new Error("Error al eliminar producto. Revisa consola.");
            });
          }
          return res.json().catch((err) => {
            console.error("No se pudo parsear JSON en eliminación:", err);
            throw new Error("Respuesta inválida del servidor.");
          });
        })
        .then((data) => {
          if (!data.success) {
            alert("Error al eliminar producto: " + (data.message || ""));
          } else {
            alert("Producto eliminado correctamente");
            table
              .deleteRow(deleteProductID)
              .catch((err) => console.error("Error eliminando fila:", err));
            deleteProductID = null;
            var modalEl = document.getElementById("deleteProductModal");
            if (modalEl) {
              var modalInstance = bootstrap.Modal.getInstance(modalEl);
              if (modalInstance) modalInstance.hide();
            }
          }
        })
        .catch((err) => {
          console.error("Error en solicitud AJAX eliminación:", err);
          alert(err.message);
        });
    });
  }

  // AGREGAR NUEVO PRODUCTO
  var addProductBtn = document.getElementById("addProductBtn");
  if (addProductBtn) {
    var addProductModalEl = document.getElementById("addProductModal");
    var addProductModal = addProductModalEl && new bootstrap.Modal(addProductModalEl);

    addProductBtn.addEventListener("click", function () {
      // Limpiar formulario antes de mostrar
      var newCodeEl = document.getElementById("new-product-code");
      var newNameEl = document.getElementById("new-product-name");
      var newLocationEl = document.getElementById("new-location");
      var newPriceEl = document.getElementById("new-price");
      var newStockEl = document.getElementById("new-stock");
      var categoryEl = document.getElementById("new-category");
      var supplierEl = document.getElementById("new-supplier");
      var unitEl = document.getElementById("new-unit");
      var currencyEl = document.getElementById("new-currency");
      var subcategoryEl = document.getElementById("new-subcategory");
      var desiredStockEl = document.getElementById("new-desired-stock");
      var statusEl = document.getElementById("new-status");

      if (newCodeEl) newCodeEl.value = "";
      if (newNameEl) newNameEl.value = "";
      if (newLocationEl) newLocationEl.value = "";
      if (newPriceEl) newPriceEl.value = "";
      if (newStockEl) newStockEl.value = "";
      if (categoryEl) categoryEl.value = "";
      if (supplierEl) supplierEl.value = "";
      if (unitEl) unitEl.value = "";
      if (currencyEl) currencyEl.value = "";
      if (subcategoryEl) subcategoryEl.value = "";
      if (desiredStockEl) desiredStockEl.value = "";
      if (statusEl) statusEl.value = "1";

      if (addProductModal) addProductModal.show();
    });
  }

  var saveNewProductBtn = document.getElementById("saveNewProductBtn");
  if (saveNewProductBtn) {
    saveNewProductBtn.addEventListener("click", function () {
      var newCodeEl = document.getElementById("new-product-code");
      var newNameEl = document.getElementById("new-product-name");
      var newLocationEl = document.getElementById("new-location");
      var newPriceEl = document.getElementById("new-price");
      var newStockEl = document.getElementById("new-stock");
      var categoryEl = document.getElementById("new-category");
      var supplierEl = document.getElementById("new-supplier");
      var unitEl = document.getElementById("new-unit");
      var currencyEl = document.getElementById("new-currency");
      var subcategoryEl = document.getElementById("new-subcategory");
      var desiredStockEl = document.getElementById("new-desired-stock");
      var statusEl = document.getElementById("new-status");

      if (!(newCodeEl && newNameEl && newLocationEl && newPriceEl && newStockEl && categoryEl && supplierEl && unitEl && currencyEl && subcategoryEl && desiredStockEl && statusEl)) {
        console.error("Faltan campos en formulario de creación");
        return;
      }

      var code = newCodeEl.value.trim();
      var name = newNameEl.value.trim();
      var location = newLocationEl.value.trim();
      var price = parseFloat(newPriceEl.value);
      var stock = parseInt(newStockEl.value, 10);
      var categoryId = categoryEl.value ? parseInt(categoryEl.value,10) : null;
      var supplierId = supplierEl.value ? parseInt(supplierEl.value,10) : null;
      var unitId = unitEl.value ? parseInt(unitEl.value,10) : null;
      var currencyId = currencyEl.value ? parseInt(currencyEl.value,10) : null;
      var subcategoryId = subcategoryEl.value ? parseInt(subcategoryEl.value,10) : null;
      var desiredStock = desiredStockEl.value ? parseInt(desiredStockEl.value,10) : null;
      var status = statusEl.value ? parseInt(statusEl.value,10) : 1;

      // Validaciones básicas antes de enviar
      if (!code || !name) {
        alert("Código y nombre son obligatorios.");
        return;
      }
      if (isNaN(price) || isNaN(stock)) {
        alert("Precio y stock deben ser números válidos.");
        return;
      }
      // Validar FK obligatorios
      if (categoryId === null) {
        alert("Selecciona una categoría.");
        return;
      }
      if (supplierId === null) {
        alert("Selecciona un proveedor.");
        return;
      }
      if (unitId === null) {
        alert("Selecciona una unidad.");
        return;
      }
      if (currencyId === null) {
        alert("Selecciona una moneda.");
        return;
      }
      if (subcategoryId === null) {
        alert("Selecciona una subcategoría.");
        return;
      }

      var productData = {
        product_code: code,
        product_name: name,
        location: location,
        price: price,
        stock: stock,
        category_id: categoryId,
        supplier_id: supplierId,
        unit_id: unitId,
        currency_id: currencyId,
        subcategory_id: subcategoryId,
        desired_stock: desiredStock,
        status: status
      };

      fetch(BASE_URL + "api/products.php?action=create", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ productData: productData }),
      })
        .then((res) => {
          if (!res.ok) {
            return res.text().then((text) => {
              console.error("Respuesta no OK al crear producto. Status:", res.status, "Body:", text);
              throw new Error("Error al crear producto. Revisa consola.");
            });
          }
          return res.json().catch((err) => {
            console.error("No se pudo parsear JSON en creación:", err);
            throw new Error("Respuesta inválida del servidor.");
          });
        })
        .then((data) => {
          if (!data.success) {
            alert("Error al crear producto: " + (data.message || ""));
          } else {
            if (data.product) {
              table.addData([data.product]).then(() => {
                // Cerrar modal
                var modalEl = document.getElementById("addProductModal");
                if (modalEl) {
                  var modalInst = bootstrap.Modal.getInstance(modalEl);
                  if (modalInst) modalInst.hide();
                }
              });
            } else {
              console.warn("No se devolvió data.product al crear.");
            }
          }
        })
        .catch((err) => {
          console.error("Error en solicitud AJAX creación:", err);
          alert(err.message);
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
