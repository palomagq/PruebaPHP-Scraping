<?php
// Incluir el archivo del controlador para poder utilizarlo
require_once 'controller.php';

// Verificar si se ha enviado una URL como parámetro GET
if (isset($_GET['url'])) {
    // Crear una instancia del controlador
    $controller = new Controller();

    // Llamar al método handleRequest del controlador, pasándole la URL proporcionada
    $controller->handleRequest($_GET['url']);
} else {
    // Si no se ha proporcionado ninguna URL, mostrar el formulario de búsqueda de eventos
    require_once 'views/view.php';
}
