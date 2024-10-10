<?php
// Incluir el archivo donde se encuentra la clase Scraper
require_once 'scraper.php';

class Controller {
    
    // Método para manejar las solicitudes, toma la URL de un evento como parámetro
    public function handleRequest($url) {
        // Crear una instancia de la clase Scraper
        $scraper = new Scraper();

        // Verificar si la URL pertenece a VividSeats
        if (strpos($url, 'vividseats.com') !== false) {
            // Llamar al método scrapeVividSeats si es un evento de VividSeats
            $tickets = $scraper->scrapeVividSeats($url);
        }
        // Verificar si la URL pertenece a SeatGeek
        elseif (strpos($url, 'seatgeek.com') !== false) {
            // Llamar al método scrapeSeatGeek si es un evento de SeatGeek
            $tickets = $scraper->scrapeSeatGeek($url);
        } else {
            // Si la URL no es válida para ninguna de las plataformas, mostrar un mensaje de error
            echo "Plataforma no reconocida.";
            return;
        }

        // Pasar los datos de las entradas a la vista (view.php)
        require_once 'views/view.php';
    }
}
