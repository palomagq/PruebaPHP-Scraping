<?php

require_once 'lib/simple_html_dom.php'; // Importar la biblioteca simple_html_dom
require 'vendor/autoload.php'; // Autoload de Composer
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Exception\WebDriverCurlException;
use Facebook\WebDriver\Chrome\ChromeOptions;

class Scraper {

    private $driver;

    public function __construct() {
        //ini_set('default_socket_timeout', 60);
        set_time_limit(60); // Aumenta el tiempo de ejecución máximo del script a 60 segundos

        // URL del servidor Selenium
            $serverUrl = 'http://localhost:4444/';

            // Configurar las opciones de Chrome
            $options = new ChromeOptions();
            $options->addArguments(['--headless', '--disable-gpu', '--no-sandbox']);

            // Especificar la ubicación del binario de Google Chrome (cambia esta ruta si es necesario)
            $options->setBinary('C:/Program Files/Google/Chrome/Application/chrome.exe');

            // Crear las capacidades del navegador
            $capabilities = DesiredCapabilities::chrome();
            $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

  
        // Inicializa el WebDriver
        try {
            $this->driver = RemoteWebDriver::create($serverUrl, $capabilities,60000);

        } catch (Exception $e) {
            echo "Error al conectar con el WebDriver: " . $e->getMessage();
            exit(1); // Salir del script si no se puede conectar
        }
    }

    public function scrapeVividSeats($url) {
        // Navegar a la URL
        $this->driver->get($url);

        // Esperar que la página cargue completamente (puedes ajustar el tiempo según sea necesario)
        sleep(5); // Espera de 5 segundos (mejorar esto con WebDriverWait es posible)

        // Ahora puedes buscar los elementos que necesitas
        $tickets = [];

        // Encontrar elementos usando selectores CSS o XPath
        $elements = $this->driver->findElements(WebDriverBy::cssSelector('a.styles_listingsContainer__FIaQR'));
        var_dump($elements);
        foreach ($elements as $element) {
            // Extraer la categoría, fila y precio
            $category = $element->findElement(WebDriverBy::cssSelector('div[data-testid^="CATEGORY"]'))->getText();
            $row = $element->findElement(WebDriverBy::cssSelector('span[data-testid="row"]'))->getText();
            $price = $element->findElement(WebDriverBy::cssSelector('span[data-testid="listing-price"]'))->getText();

            $tickets[] = [
                'category' => trim($category),
                'row' => trim($row),
                'price' => trim($price),
            ];
        }

        return $tickets; // Retornar los tickets encontrados
    }

    public function __destruct() {
        // Cerrar el navegador
        $this->driver->quit();
    }

    // Método para hacer scraping de un evento de SeatGeek (similar al de VividSeats)
    public function scrapeSeatGeek($url) {
        // Navegar a la URL
        $this->driver->get($url);
    
        // Esperar que la página cargue completamente
        sleep(5); // Puedes mejorar esto con WebDriverWait
    
        $tickets = [];
    
        // Encontrar elementos <li> dentro de <ol>
        $elements = $this->driver->findElements(WebDriverBy::cssSelector('ol > li'));
    
        foreach ($elements as $element) {
            try {
                // Obtener el atributo aria-label del div con el data-testid="listing-item"
                $ariaLabel = $element->findElement(WebDriverBy::cssSelector('div[data-testid="listing-item"]'))->getAttribute('aria-label');
                
                // Dividir la cadena aria-label en partes usando comas
                $parts = explode(',', $ariaLabel);
                
                if (count($parts) >= 3) {
                    $category = trim($parts[0]); // Ej., "Floor A 4"
                    $row = trim($parts[1]);      // Ej., "Row 26"
                    $price = trim(str_replace(['at $', ' each'], '', $parts[3])); // Ej., "$4,111"
    
                    $tickets[] = [
                        'category' => $category,
                        'row' => $row,
                        'price' => $price,
                    ];
                }
            } catch (NoSuchElementException $e) {
                // Si no se encuentra el elemento o falla, continuar con el siguiente
                continue;
            }
        }
    
        return $tickets; // Retornar los tickets encontrados
    }
    
    // Función auxiliar que realiza la solicitud cURL y obtiene el contenido de la página
    private function curlGetContents($url) {
        $ch = curl_init();
    
        // Configuración básica de cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Establecer un User-Agent para simular un navegador real
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.82 Safari/537.36');
        
        // Habilitar el uso de cookies
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt'); // Guarda cookies
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt'); // Envía cookies
        
        // Permitir redirecciones
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
        // Configurar timeout (opcional)
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
        // Deshabilitar la verificación de certificados SSL (en algunos casos es necesario)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
        // Ejecutar la solicitud y obtener la respuesta
        $html = curl_exec($ch);
    
        // Manejar posibles errores
        if (curl_errno($ch)) {
            echo 'Error de cURL: ' . curl_error($ch);
            return false;
        }
    
        // Cerrar el recurso cURL
        curl_close($ch);
    
        // Pausa aleatoria (1 a 5 segundos) para simular comportamiento humano
        sleep(rand(1, 5));
    
        return $html;
    }
    
}
