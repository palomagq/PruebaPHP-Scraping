# Prueba PHP

Desarrollar una aplicación en PHP que reciba una URL de un evento y muestre las entradas disponibles, clasificadas por sector, fila y precio. La aplicación debe ser capaz de trabajar con dos plataformas: VividSeats y SeatGeek.


## Tabla de Contenidos
- [Scrapping](#Scrapping)
- [Selenium](#selenium)

## Scrapping

El proyecto lo empecé haciéndolo con Scrapping puro pero al ver que no funcionaba, ya que el código se añade posteriormente con JavaScript al cargar la página, he utilizado la alternativa de Selenium

## Selenium
¿Qué es Selenium?

Selenium es una herramienta de software de código abierto que se utiliza para automatizar navegadores web. Permite simular la interacción de un usuario con un sitio web, como hacer clic en botones, completar formularios, navegar por páginas y más, sin intervención humana. Es muy popular en el desarrollo de pruebas automatizadas para aplicaciones web, ya que ayuda a verificar que la funcionalidad de un sitio funcione correctamente en diferentes navegadores y dispositivos.

1. Descarga

  Para descargar y configurar ChromeDriver (WebDriver para Google Chrome), sigue estos pasos:

          1. Verifica la versión de tu navegador Chrome
          Antes de descargar ChromeDriver, debes asegurarte de que sea compatible con la versión de Chrome instalada en tu computadora.
          
          Abre Chrome y ve a Configuración > Ayuda > Acerca de Google Chrome.
          Anota el número de la versión (por ejemplo, 117.0.5938.132).
          
          2. Descarga ChromeDriver
          Visita la página oficial de descargas de ChromeDriver: https://sites.google.com/chromium.org/driver/.
          Busca la versión de ChromeDriver que coincida con tu versión de Chrome y haz clic en el enlace.
          Descarga el archivo correspondiente a tu sistema operativo (Windows, macOS, o Linux).
          
          3. Extrae el archivo descargado
          El archivo descargado estará comprimido en formato .zip.
          Extrae el archivo chromedriver.exe (en Windows) o chromedriver (en macOS/Linux) a una carpeta de tu elección.
          
          4. Agrega ChromeDriver a la variable de entorno del sistema (opcional pero recomendado)
          Para facilitar el uso de ChromeDriver, puedes agregar la ruta de la carpeta donde se encuentra el archivo chromedriver a la variable de entorno PATH de tu sistema:
          
          Windows:
          
              - Haz clic derecho en "Este PC" o "Mi PC" y selecciona "Propiedades".
              - Ve a "Configuración avanzada del sistema" > "Variables de entorno".
              - En "Variables del sistema", selecciona la variable PATH y haz clic en "Editar".
              - Agrega la ruta completa de la carpeta que contiene chromedriver.exe y guarda los cambios.

   
2. Inicialización

    Abre el símbolo del sistema (CMD) y navega hasta la carpeta donde se encuentran el archivo JAR de Selenium y el ChromeDriver.
    
    Ejecuta el siguiente comando para iniciar el servidor:
  
    java -jar selenium-server-standalone-<version>.jar
  
    Reemplaza <version> con la versión específica que hayas descargado (por ejemplo, selenium-server-standalone-4.0.0.jar). Esto iniciará el servidor en el puerto predeterminado 4444.
  

 
3. Fallo de ejecución con Selenium

    Al ejecutar ambas páginas pasadas por parámetros se visualiza un error el cual devuelve 0 bytes porque tiene un antiscrapping
