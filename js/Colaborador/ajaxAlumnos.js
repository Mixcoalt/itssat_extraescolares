$(document).ready(function() {
    var currentPage = 1;
    var numeroControl=null;
    var carrera=null;
    var grupo=null;

    // Función para cargar el catálogo con paginación
    function loadCatalogo(page, pageSize, numeroControl, carrera, grupo) {
        $("#catalogo").append('<div id="loader" class="loader"></div>'); // Agrega el loader al div catalogo
        $.ajax({
            url: '../../Usuarios/Colaborador/php/obtenerCatalogo.php',
            method: 'GET',
            data: {
                page: page,
                pageSize: pageSize,
                numeroControl: numeroControl,
                carrera: carrera,
                grupo: grupo
            },
            success: function(data) {
                console.log("Datos recibidos");
                $('#catalogo').html(data);
                $("#loader").remove(); // Elimina el loader al recibir la respuesta
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud AJAX:", status, error);
                $("#loader").remove(); // Asegúrate de eliminar el loader en caso de error también
            }
        });
    }

    // Cargar la primera página con 10 elementos por página al inicio
    loadCatalogo(1, 10, null, null, null);

    // Implementar la lógica de paginación (por ejemplo, botones de siguiente y anterior)
    // Ejemplo:
    $('#nextPage').on('click', function() {
        currentPage++;
        loadCatalogo(currentPage, 10, numeroControl,carrera,grupo);
        $(this).data('page', currentPage);
    });

    $('#prevPage').on('click', function() {
        if (currentPage > 1) {
            currentPage--;
            loadCatalogo(currentPage, 10, numeroControl,carrera,grupo);
            $(this).data('page', currentPage);
        }
    });

    // Implementar la lógica para el botón de búsqueda
    $('#Ingresar').on('click', function() {
        currentPage=1;
        numeroControl = $('#numControl').val();
        carrera = $('#carrera').val();
        grupo = $('#grupos').val();

        // Llamar a la función para cargar el catálogo con los nuevos parámetros de búsqueda
        loadCatalogo(currentPage, 10, numeroControl, carrera, grupo);
    });

    $('#limpiar').on('click', function() {
        currentPage=1;
        numeroControl = null;
        carrera = null;
        grupo = null;
        $('#numControl').val('');
        $('#carrera').val('0');
        $('#grupos').val('0');

        // Llamar a la función para cargar el catálogo con los nuevos parámetros de búsqueda
        loadCatalogo(currentPage, 10, numeroControl, carrera, grupo);
    });
});
