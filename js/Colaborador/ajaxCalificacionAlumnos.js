$(document).ready(function() {
    var currentPage = 1;
    var numeroControl = null;
    var carrera = null;
    var grupo = null;

    $(document).on('click', '.btn-info-alumno', function() {
        var numControl = $(this).data('numcontrol');
        var columnaCalificar = $(this).data('columnacalificar');
        var calificacion = $(this).closest('tr').find('input[name="calificacion"], input[name="calificacion"], input[name="calificacion"]').val();

        console.log("Datos para enviar:", numControl, columnaCalificar, calificacion);

        $.ajax({
            url: '../../Usuarios/Colaborador/php/insertarCalificacionAlumno.php',
            method: 'GET',  // Cambiado a GET
            data: {
                numControl: numControl,
                columnaCalificar: columnaCalificar,
                calificacion: calificacion
            },
            success: function(response) {
                console.log("Respuesta del servidor:", response);
                alert(response);
                loadCalificaciones(currentPage, 10, numeroControl, carrera, grupo);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                alert("Error al actualizar la calificación");
            }
        });
    });

    function loadCalificaciones(page, pageSize, numeroControl, carrera, grupo) {
        $("#calificaciones").append('<div id="loader" class="loader"></div>'); // Agrega el loader al div catalogo
        $.ajax({
            url: '../../Usuarios/Colaborador/php/obtenerCalificacionesAlumno.php',
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
                $('#calificaciones').html(data);
                $("#loader").remove(); // Elimina el loader al recibir la respuesta
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                $("#loader").remove(); // Elimina el loader en caso de error
            }
        });
    }

    // Llamada inicial a la función
    loadCalificaciones(currentPage, 10, numeroControl, carrera, grupo);

    $('#nextPage').on('click', function() {
        console.log("NEXT");
        currentPage++;
        loadCalificaciones(currentPage, 10, numeroControl,carrera,grupo);
        $(this).data('page', currentPage);
    });

    $('#prevPage').on('click', function() {
        console.log("PREV");
        if (currentPage > 1) {
            currentPage--;
            loadCalificaciones(currentPage, 10, numeroControl,carrera,grupo);
            $(this).data('page', currentPage);
        }
    });

    // Puedes añadir más lógica para llamadas posteriores a loadCalificaciones
        // Implementar la lógica para el botón de búsqueda
        $('#Ingresar').on('click', function() {
            currentPage=1;
            numeroControl = $('#numControl').val();
            carrera = $('#carrera').val();
            grupo = $('#grupos').val();
    
            // Llamar a la función para cargar el catálogo con los nuevos parámetros de búsqueda
            loadCalificaciones(currentPage, 10, numeroControl, carrera, grupo);
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
            loadCalificaciones(currentPage, 10, numeroControl, carrera, grupo);
        });
});
