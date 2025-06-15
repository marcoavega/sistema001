// Archivo: assets/js/ajax/products-table.js

document.addEventListener("DOMContentLoaded", function () {
  var productsTableElement = document.getElementById("products-table");
  if (!productsTableElement) return;

  var deleteProductID = null;

  var table = new Tabulator("#products-table", {
    index: "product_id",
    ajaxURL: BASE_URL + "api/products.php?action=get",
    ajaxConfig: "GET",
    layout: "fitColumns",
    responsiveLayout: "collapse",
    placeholder: "Cargando productos...",
    columns: [
      { title: "ID", field: "product_id", width: 70, sorter: "number", hozAlign: "center" },
      { title: "Código", field: "product_code", headerFilter: false },
      { title: "Nombre", field: "product_name" },
      { title: "Ubicación", field: "location" },
      {
        title: "Precio", field: "price", hozAlign: "right", formatter: "money",
        formatterParams: { symbol: "", precision: 2 },
      },
      { title: "Stock", field: "stock", sorter: "number", hozAlign: "center" },
      {
        title: "Registrado", field: "registration_date",
        formatter: function (cell) {
          var date = new Date(cell.getValue());
          if (isNaN(date.getTime())) return "";
          return `${date.getDate().toString().padStart(2, "0")}/${
            (date.getMonth() + 1).toString().padStart(2, "0")
          }/${date.getFullYear()}`;
        },
      },
      {
        title: "Acciones", hozAlign: "center", responsive: false,
        formatter: () => `
          <div class='btn-group'>
            <button class='btn btn-sm btn-info edit-btn me-1'>Editar</button>
            <button class='btn btn-sm btn-danger delete-btn'>Eliminar</button>
          </div>`,
        cellClick: function (e, cell) {
          const rowData = cell.getRow().getData();
          if (e.target.classList.contains("edit-btn")) {
            document.getElementById("edit-product-id").value = rowData.product_id;
            document.getElementById("edit-product-code").value = rowData.product_code;
            document.getElementById("edit-product-name").value = rowData.product_name;
            document.getElementById("edit-location").value = rowData.location;
            document.getElementById("edit-price").value = rowData.price;
            document.getElementById("edit-stock").value = rowData.stock;
            new bootstrap.Modal(document.getElementById("editProductModal")).show();
          }
          if (e.target.classList.contains("delete-btn")) {
            deleteProductID = rowData.product_id;
            new bootstrap.Modal(document.getElementById("deleteProductModal")).show();
          }
        },
      },
    ],
  });

  const searchInput = document.getElementById("table-search");
  if (searchInput) {
    searchInput.addEventListener("input", function () {
      const query = searchInput.value.toLowerCase();
      table.setFilter(function (data) {
        return (
          (data.product_code || "").toLowerCase().includes(query) ||
          (data.product_name || "").toLowerCase().includes(query)
        );
      });
    });
  }

  document.getElementById("saveEditProductBtn")?.addEventListener("click", function () {
    const id = parseInt(document.getElementById("edit-product-id").value, 10);
    const productData = {
      product_code: document.getElementById("edit-product-code").value.trim(),
      product_name: document.getElementById("edit-product-name").value.trim(),
      location: document.getElementById("edit-location").value.trim(),
      price: parseFloat(document.getElementById("edit-price").value) || 0,
      stock: parseInt(document.getElementById("edit-stock").value, 10) || 0,
    };

    fetch(BASE_URL + "api/products.php?action=update", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ product_id: id, productData }),
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          table.updateOrAddData([data.product]);
          bootstrap.Modal.getInstance(document.getElementById("editProductModal")).hide();
        } else {
          alert("Error al actualizar producto: " + data.message);
        }
      })
      .catch((err) => console.error("Error edición:", err));
  });

  document.getElementById("confirmDeleteProductBtn")?.addEventListener("click", function () {
    if (!deleteProductID) return;

    fetch(BASE_URL + "api/products.php?action=delete", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ product_id: deleteProductID }),
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          table.deleteRow(deleteProductID);
          bootstrap.Modal.getInstance(document.getElementById("deleteProductModal")).hide();
          deleteProductID = null;
        } else {
          alert("Error al eliminar producto: " + data.message);
        }
      })
      .catch((err) => console.error("Error eliminación:", err));
  });

  const addProductBtn = document.getElementById("addProductBtn");
  const addProductModal = new bootstrap.Modal(document.getElementById("addProductModal"));
  addProductBtn?.addEventListener("click", function () {
    ["code", "name", "location", "price", "stock"].forEach((field) =>
      (document.getElementById("new-product-" + field).value = "")
    );
    addProductModal.show();
  });

  document.getElementById("saveNewProductBtn")?.addEventListener("click", function () {
    const productData = {
      product_code: document.getElementById("new-product-code").value.trim(),
      product_name: document.getElementById("new-product-name").value.trim(),
      location: document.getElementById("new-location").value.trim(),
      price: parseFloat(document.getElementById("new-price").value) || 0,
      stock: parseInt(document.getElementById("new-stock").value, 10) || 0,
    };

    fetch(BASE_URL + "api/products.php?action=create", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ productData }),
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          table.addData([data.product]);
          addProductModal.hide();
        } else {
          alert("Error al crear producto: " + data.message);
        }
      })
      .catch((err) => console.error("Error creación:", err));
  });

  
  document.getElementById("exportCSVBtn")?.addEventListener("click", function () {
    const datos = table.getData();
    let csvContent = `"REPORTE DE LISTA DE PRODUCTOS"\n"Formato: L001"\n\n`;
    csvContent += ["ID", "Código", "Nombre", "Ubicación", "Precio", "Stock", "Registrado"].join(",") + "\n";

    datos.forEach((row) => {
      let fecha = "";
      if (row.registration_date) {
        const d = new Date(row.registration_date);
        if (!isNaN(d.getTime())) {
          fecha = `${String(d.getDate()).padStart(2, "0")}/${String(d.getMonth() + 1).padStart(2, "0")}/${d.getFullYear()}`;
        }
      }
      csvContent += [
        row.product_id,
        `"${row.product_code}"`,
        `"${row.product_name}"`,
        `"${row.location}"`,
        row.price,
        row.stock,
        `"${fecha}"`,
      ].join(",") + "\n";
    });

    const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = "productos.csv";
    a.click();
    URL.revokeObjectURL(url);
  });

  document.getElementById("exportExcelBtn")?.addEventListener("click", function () {
    const dataToExport = table.getData();
    table.download("xlsx", "productos.xlsx", {
      sheetName: "Reporte Productos",
      documentProcessing: (wb) => {
        const sheet = wb.Sheets["Reporte Productos"];
        sheet["A1"].s = { font: { bold: true } };
        return wb;
      },
      rows: dataToExport,
    });
  });

  document.getElementById("exportJSONBtn")?.addEventListener("click", function () {
    table.download("json", "productos.json");
  });

  document.getElementById("exportPDFBtn")?.addEventListener("click", function () {
    table.download("pdf", "productos.pdf", {
      orientation: "landscape",
      autoTable: {
        styles: { fontSize: 8, cellPadding: 2, halign: "center" },
        margin: { top: 70, left: 10, right: 10 },
        headStyles: { fillColor: [22, 160, 133], textColor: 255, fontStyle: "bold", halign: "center" },
        bodyStyles: { halign: "center" },
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
          doc.setFontSize(16).setFont(undefined, "bold").text("REPORTE DE LISTA DE PRODUCTOS", pageWidth / 2, y, { align: "center" });
          y += 10;
          doc.setFontSize(10).text("Formato: L001", pageWidth / 2, y, { align: "center" });
          y += 10;
          doc.setFontSize(9).text("Generado: " + new Date().toLocaleDateString(), data.settings.margin.left, y);
        },
      },
    });
  });
});