// Archivo: assets/js/ajax/products-table.js

document.addEventListener("DOMContentLoaded", function () {
  // Elemento donde irá la tabla de productos
  var productsTableElement = document.getElementById("products-table");
  if (!productsTableElement) return;

  // Variable temporal para ID de producto a eliminar
  var deleteProductID = null;

  // Inicializa Tabulator en #products-table
  var table = new Tabulator("#products-table", {
    index: "product_id", // campo único
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
          symbol: "", // Si quieres símbolo, ej. "$"
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
          // EDIT
          if (e.target.classList.contains("edit-btn")) {
            // Rellenar formulario de edición con datos del producto
            document.getElementById("edit-product-id").value =
              rowData.product_id;
            document.getElementById("edit-product-code").value =
              rowData.product_code;
            document.getElementById("edit-product-name").value =
              rowData.product_name;
            document.getElementById("edit-location").value =
              rowData.location;
            document.getElementById("edit-price").value = rowData.price;
            document.getElementById("edit-stock").value = rowData.stock;
            // Si manejas categorías, proveedores, etc., asigna también:
            // document.getElementById("edit-category").value = rowData.category_id;
            // ...
            // Mostrar modal edición
            var editModal = new bootstrap.Modal(
              document.getElementById("editProductModal")
            );
            editModal.show();
          }
          // DELETE
          if (e.target.classList.contains("delete-btn")) {
            deleteProductID = rowData.product_id;
            var deleteModal = new bootstrap.Modal(
              document.getElementById("deleteProductModal")
            );
            deleteModal.show();
          }
        },
      },
    ],
  });

  // Búsqueda / filtro
  var searchInput = document.getElementById("table-search");
  if (searchInput) {
    searchInput.addEventListener("input", function () {
      var query = searchInput.value.toLowerCase();
      table.setFilter(function (data) {
        // Filtra por código o nombre
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
  document
    .getElementById("saveEditProductBtn")
    .addEventListener("click", function () {
      // Leer valores del formulario de edición
      var id = parseInt(
        document.getElementById("edit-product-id").value,
        10
      );
      var code = document.getElementById("edit-product-code").value.trim();
      var name = document
        .getElementById("edit-product-name")
        .value.trim();
      var location = document.getElementById("edit-location").value.trim();
      var price = parseFloat(document.getElementById("edit-price").value);
      var stock = parseInt(document.getElementById("edit-stock").value, 10);

      // Construir objeto de datos a actualizar
      var productData = {
        product_code: code,
        product_name: name,
        location: location,
        price: isNaN(price) ? null : price,
        stock: isNaN(stock) ? null : stock,
        // Si incluyes categoría, proveedor, etc., agrégalos:
        // category_id: parseInt(document.getElementById("edit-category").value,10),
        // ...
      };

      fetch(BASE_URL + "api/products.php?action=update", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          product_id: id,
          productData: productData,
        }),
      })
        .then((res) => res.json())
        .then((data) => {
          if (!data.success) {
            alert("Error al actualizar producto: " + data.message);
          } else {
            alert("Producto actualizado correctamente");
            // Actualizar en la tabla: data.product contiene el producto actualizado
            table
              .updateOrAddData([data.product])
              .then(() => {
                console.log("Producto actualizado en la tabla");
              })
              .catch((err) => {
                console.error("Error actualizando producto:", err);
              });
            // Cerrar modal
            var modalEl = document.getElementById("editProductModal");
            var modalInstance = bootstrap.Modal.getInstance(modalEl);
            modalInstance.hide();
          }
        })
        .catch((err) => {
          console.error("Error en solicitud AJAX edición:", err);
        });
    });

  // CONFIRMAR ELIMINAR
  document
    .getElementById("confirmDeleteProductBtn")
    .addEventListener("click", function () {
      if (!deleteProductID) return;
      fetch(BASE_URL + "api/products.php?action=delete", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ product_id: deleteProductID }),
      })
        .then((res) => res.json())
        .then((data) => {
          if (!data.success) {
            alert("Error al eliminar producto: " + data.message);
          } else {
            alert("Producto eliminado correctamente");
            table
              .deleteRow(deleteProductID)
              .then(() => {
                console.log("Producto eliminado de la tabla");
              })
              .catch((err) => {
                console.error("Error eliminando fila:", err);
              });
            deleteProductID = null;
            var modalEl = document.getElementById("deleteProductModal");
            var modalInstance = bootstrap.Modal.getInstance(modalEl);
            modalInstance.hide();
          }
        })
        .catch((err) => {
          console.error("Error en solicitud AJAX eliminación:", err);
        });
    });

  // AGREGAR NUEVO PRODUCTO
  const addProductBtn = document.getElementById("addProductBtn");
  const addProductModal = new bootstrap.Modal(
    document.getElementById("addProductModal")
  );
  if (addProductBtn) {
    addProductBtn.addEventListener("click", function () {
      // Limpiar formulario antes de mostrar
      document.getElementById("new-product-code").value = "";
      document.getElementById("new-product-name").value = "";
      document.getElementById("new-location").value = "";
      document.getElementById("new-price").value = "";
      document.getElementById("new-stock").value = "";
      // Si tienes selects de categoría, proveedor, etc., reinícialos:
      // document.getElementById("new-category").value = "";
      addProductModal.show();
    });
  }

  document
    .getElementById("saveNewProductBtn")
    .addEventListener("click", function () {
      // Leer valores formulario nuevo producto
      var code = document.getElementById("new-product-code").value.trim();
      var name = document.getElementById("new-product-name").value.trim();
      var location = document.getElementById("new-location").value.trim();
      var price = parseFloat(document.getElementById("new-price").value);
      var stock = parseInt(document.getElementById("new-stock").value, 10);

      // Construir datos
      var productData = {
        product_code: code,
        product_name: name,
        location: location,
        price: isNaN(price) ? null : price,
        stock: isNaN(stock) ? null : stock,
        // category_id: parseInt(document.getElementById("new-category").value,10),
        // ...
      };

      fetch(BASE_URL + "api/products.php?action=create", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ productData: productData }),
      })
        .then((res) => res.json())
        .then((data) => {
          if (!data.success) {
            alert("Error al crear producto: " + data.message);
          } else {
            // data.product contiene el nuevo producto con product_id, etc.
            table.addData([data.product]).then(() => {
              addProductModal.hide();
            });
          }
        })
        .catch((err) => {
          console.error("Error en solicitud AJAX creación:", err);
        });
    });

  // EXPORTAR CSV
  document
    .getElementById("exportCSVBtn")
    .addEventListener("click", function () {
      var datos = table.getData();
      // Construir CSV manualmente con encabezados y títulos
      let csvContent = "";
      csvContent += `"REPORTE DE LISTA DE PRODUCTOS"\n`;
      csvContent += `"Formato: L001"\n\n`; // o cualquier formato que necesites

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
        // Formatear fecha
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

  // EXPORTAR EXCEL
  document
    .getElementById("exportExcelBtn")
    .addEventListener("click", function () {
      // Prepara datos sin campos no deseados (ej. image_url si la tuvieras)
      const dataToExport = table.getData().map((row) => {
        const { /*image_url,*/ ...filtered } = row;
        return filtered;
      });

      table.download("xlsx", "productos.xlsx", {
        sheetName: "Reporte Productos",
        documentProcessing: function (workbook) {
          // Ejemplo: negrita en A1
          const sheet = workbook.Sheets["Reporte Productos"];
          sheet["A1"].s = { font: { bold: true } };
          return workbook;
        },
        rows: dataToExport,
      });
    });

  // EXPORTAR JSON
  document
    .getElementById("exportJSONBtn")
    .addEventListener("click", function () {
      table.download("json", "productos.json");
    });

  // EXPORTAR PDF
  document
    .getElementById("exportPDFBtn")
    .addEventListener("click", function () {
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
              doc.text(
                "REPORTE DE LISTA DE PRODUCTOS",
                pageWidth / 2,
                y,
                { align: "center" }
              );
              y += 10;
              // FORMATO
              doc.setFontSize(10);
              doc.setFont(undefined, "normal");
              doc.text(
                "Formato: L001",
                pageWidth / 2,
                y,
                { align: "center" }
              );
              // Fecha generación
              y += 10;
              doc.setFontSize(9);
              doc.text(
                "Generado: " + new Date().toLocaleDateString(),
                data.settings.margin.left,
                y
              );
            },
          },
        });
      } catch (e) {
        console.error("Error en el handler de exportación PDF:", e);
      }
    });
});
