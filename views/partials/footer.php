<footer class="text-center py-3">
    <!-- Sección de pie de página con alineación centrada y padding en la parte superior e inferior -->
    
    <p class="mb-0">&copy; <?php echo date("Y"); ?> - Sistema. </p>
    <!-- Muestra el año actual dinámicamente con PHP, seguido del nombre del sistema -->
    
</footer>

<!-- Inclusión de bibliotecas JavaScript para funcionalidad del sistema -->

<script src="<?php echo BASE_URL; ?>assets/js/bootstrap-5.3.3-dist/bootstrap.bundle.min.js"></script>
<!-- Carga el bundle de Bootstrap 5.3, incluyendo Popper.js para elementos como tooltips y dropdowns -->

<script src="<?php echo BASE_URL; ?>assets/tabulator/js/tabulator.min.js"></script>
<!-- Incluye Tabulator.js para la gestión y visualización avanzada de tablas en la interfaz -->

<script src="<?php echo BASE_URL; ?>assets/js/theme.js"></script>
<!-- Script para manejar temas visuales, probablemente alternando entre modo oscuro y claro -->

<script src="<?php echo BASE_URL; ?>assets/js/modals.js"></script>
<!-- Script general para controlar la apertura y cierre de los modales en el sistema -->

<script src="<?php echo BASE_URL; ?>assets/js/modal_logout.js"></script>
<!-- Script específico para el modal de cierre de sesión -->

<script src="<?php echo BASE_URL; ?>assets/js/modals_register.js"></script>
<!-- Script para gestionar el registro de usuarios dentro de los modales -->

<script src="<?php echo BASE_URL; ?>assets/js/script.js"></script>
<!-- Archivo JavaScript principal del sistema que puede contener múltiples funciones -->

<!-- Bibliotecas para exportar datos -->

<script src="<?php echo BASE_URL; ?>assets/js/jspdf.umd.min.js"></script>
<!-- jsPDF: Biblioteca para generar archivos PDF desde datos dinámicos -->

<script src="<?php echo BASE_URL; ?>assets/js/jspdf.plugin.autotable.min.js"></script>
<!-- Plugin AutoTable para jsPDF, utilizado para exportar tablas en formato PDF -->

<script src="<?php echo BASE_URL; ?>assets/js/xlsx.full.min.js"></script>
<!-- XLSX.js: Biblioteca para exportar datos a Excel (formato .xlsx) -->

<!-- SweetAlert2 CSS y JS desde CDN -->
<script src="<?php echo BASE_URL; ?>assets/sweetalert/sweetalert2-11.js"></script>

</body>

</html>

