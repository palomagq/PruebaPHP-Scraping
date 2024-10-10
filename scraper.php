<?php

require_once 'lib/simple_html_dom.php'; // Importar la biblioteca simple_html_dom


class Scraper {

    // Método para hacer scraping de un evento de VividSeats
   public function scrapeVividSeats($url) {
        // Usamos cURL para obtener el contenido HTML de la URL
        $html = $this->curlGetContents($url);

        // Verificamos si se obtuvo el contenido correctamente
        if (!$html) {
            echo "No se pudo obtener el contenido de la página.";
            return [];
        }

        // Creamos el objeto DOM con el contenido obtenido
        $dom = str_get_html($html);

        // Inicializamos un array para almacenar la información de las entradas
        $tickets = [];

        // Iteramos sobre cada entrada disponible usando el selector CSS de los elementos de entradas
        foreach ($dom->find('.ticket-listing') as $ticket) {
            // Obtenemos el sector, la fila y el precio utilizando selectores CSS
            $sector = $ticket->find('.ticket-section', 0)->plaintext;
            $fila = $ticket->find('.ticket-row', 0)->plaintext;
            $precio = $ticket->find('.ticket-price', 0)->plaintext;

            // Almacenamos la información de cada entrada en el array
            $tickets[] = [
                'sector' => $sector,
                'fila' => $fila,
                'precio' => $precio,
            ];
        }

        // Retornamos el array con las entradas obtenidas
        return $tickets;
    }
    /*function obtenerEntradasVividSeats($url) {
        $html = file_get_contents($url);
        $dom = HtmlDomParser::str_get_html($html);
    
        if (!$dom) {
            return "No se pudo cargar la página de VividSeats.";
        }
    
        $entradas = [];
    
        // Ajusta los selectores según la estructura actual de la página VividSeats
        foreach ($dom->find('.ticket-row') as $ticketRow) {
            // Cambia estas clases por las correctas
            $sector = $ticketRow->find('.ticket-section', 0)->plaintext ?? 'No disponible';
            $fila = $ticketRow->find('.ticket-row', 0)->plaintext ?? 'No disponible';
            $precio = $ticketRow->find('.ticket-price', 0)->plaintext ?? 'No disponible';
    
            $entradas[] = [
                'sector' => trim($sector),
                'fila' => trim($fila),
                'precio' => trim($precio)
            ];
        }
    
        return $entradas;
    }*/
    
    // Método para hacer scraping de un evento de SeatGeek (similar al de VividSeats)
    public function scrapeSeatGeek($url) {
        $html = $this->curlGetContents($url);

        if (!$html) {
            echo "No se pudo obtener el contenido de la página.";
            return [];
        }

        $dom = str_get_html($html);
        $tickets = [];

        foreach ($dom->find('.event-listing') as $ticket) {
            $sector = $ticket->find('.event-section', 0)->plaintext;
            $fila = $ticket->find('.event-row', 0)->plaintext;
            $precio = $ticket->find('.event-price', 0)->plaintext;

            $tickets[] = [
                'sector' => $sector,
                'fila' => $fila,
                'precio' => $precio,
            ];
        }

        return $tickets;
    }
    /*function obtenerEntradasSeatGeek($url) {
    $html = file_get_contents($url);
    $dom = HtmlDomParser::str_get_html($html);

    if (!$dom) {
        return "No se pudo cargar la página de SeatGeek.";
    }

    $entradas = [];

    // Ajusta los selectores según la estructura actual de la página SeatGeek
    foreach ($dom->find('.TicketCard') as $ticketCard) {
        // Cambia estas clases por las correctas
        $sector = $ticketCard->find('.TicketCard-section', 0)->plaintext ?? 'No disponible';
        $fila = $ticketCard->find('.TicketCard-row', 0)->plaintext ?? 'No disponible';
        $precio = $ticketCard->find('.TicketCard-price', 0)->plaintext ?? 'No disponible';

        $entradas[] = [
            'sector' => trim($sector),
            'fila' => trim($fila),
            'precio' => trim($precio)
        ];
    }

    if (empty($entradas)) {
        return "No hay entradas disponibles en SeatGeek para este evento.";
    }

    return $entradas;
}*/


    // Función auxiliar que realiza la solicitud cURL y obtiene el contenido de la página
    private function curlGetContents($url) {
        $ch = curl_init();
        
        // Configuración básica de cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Establecer un User-Agent para simular un navegador real
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3');

        // Configurar timeout (opcional)
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        // Deshabilitar la verificación de certificados SSL (en algunos casos es necesario)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Ejecutar la solicitud y obtener la respuesta
        $html = curl_exec($ch);
        
        // Manejar posibles errores
        if(curl_errno($ch)) {
            echo 'Error de cURL: ' . curl_error($ch);
            return false;
        }

        // Cerrar el recurso cURL
        curl_close($ch);

        return $html;
    }
}
