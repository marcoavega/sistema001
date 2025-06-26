<!DOCTYPE html>
<html lang="es" data-bs-theme="light"> 
<!-- Define la estructura HTML, especificando el idioma "es" (español) 
     y el tema "light" para la compatibilidad con Bootstrap 5 -->

<head>
    <meta charset="UTF8">
    <!-- Define el conjunto de caracteres UTF-8 para soportar acentos y caracteres especiales correctamente -->

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Configura el viewport para hacer que la página sea responsive en dispositivos móviles -->

    <title><?php echo APP_NAME; ?></title>
    <!-- Usa la constante APP_NAME para establecer dinámicamente el título de la página -->

    <!-- Estilos de Bootstrap -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/bootstrap-5.3.3-dist/bootstrap.min.css">
    <!-- Enlace a la hoja de estilos de Bootstrap para aplicar sus clases y estructura -->

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <!-- Carga los íconos de Bootstrap (por ejemplo, para botones y elementos gráficos) -->

    <!--<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/tabulator/css/tabulator_site_dark.min.css">
     Incluye los estilos de Tabulator, que se usan para la gestión y presentación de tablas dinámicas -->

   <!-- Solo uno: el que cambia dinámicamente -->
    <link id="tabulator-theme" rel="stylesheet" href="<?php echo BASE_URL; ?>assets/tabulator/css/tabulator.min.css">


    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    <!-- Enlace a la hoja de estilos personalizada de la aplicación (style.css) -->

    <script>
        var BASE_URL = "<?php echo BASE_URL; ?>"; 
        // Define la variable BASE_URL en JavaScript para que pueda ser usada en scripts dinámicos en el frontend
    </script>
</head>

<body>

