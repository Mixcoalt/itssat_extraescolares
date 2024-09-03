$(document).on('click', '#botonModalInfoAlumno', function() {
    var nombre = $(this).data('nombre');
    var control = $(this).data('control');
    var telefono = $(this).data('telefono');
    var correo = $(this).data('correo');
    var horario = $(this).data('horario');
    var alergia = $(this).data('alergia');
    var estatus = $(this).data('status');
    var documento = $(this).data('documento');

    // Asignar los datos al modal
    $('#nombre').text(nombre);
    $('#controlAlumno').text(control);
    $('#telefono').text(telefono);
    $('#correo').text(correo);
    $('#horario').text(horario);
    $('#alergia').text(alergia);
    $('#status').text(estatus);
    $('#documento').text(documento);

    var regular = "Regular";


    // Actualizar el enlace del botón "Permitir" con el número de control
    $('#btnCalificar').attr('href', '../Colaborador/calificarAlumno.php?numControl=' + control +'&tipo=' + regular +'&nombre=' + nombre);
});
