<script>
  $(document).ready(function() {
    var tableAdmins = $('#tableAdmins').DataTable({
      "lengthMenu": [[5, 20, 50, -1], [5, 20, 50, "Todos"]],
      "order": [
        [0, "asc"]
      ],
      responsive: "true",
      "sDom": "<'row'<'col-lg-3 col-md-4 col-9'l><'col-lg-5 col-md-3 col-3'B><'col-lg-4 col-md-5 col-12'f>r>t<'row'<'col-md-7 col-12'i><'col-md-5 col-12'p>>",
      buttons: [{
        extend: 'excelHtml5',
        text: '<i class="fas fa-file-excel"></i>',
        titleAttr: 'Exportar a excel',
        className: 'btn btn-sm btn-success bg-primary text-white'
      }],
      language: {
        sProcessing: "Procesando...",
        sLengthMenu: "Mostrar _MENU_ registros",
        sZeroRecords: "No se encontraron resultados",
        sEmptyTable: "Ningún dato disponible en esta tabla",
        sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
        sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
        sInfoPostFix: "",
        sSearch: "Buscar:",
        sUrl: "",
        sInfoThousands: ",",
        sLoadingRecords: "Cargando...",
        oPaginate: {
          sFirst: "Primero",
          sLast: "Último",
          sNext: "Siguiente",
          sPrevious: "Anterior"
        },
        aria: {
          SortAscending: ": Activar para ordenar la columna de manera ascendente",
          SortDescending: ": Activar para ordenar la columna de manera descendente"
        }
      }
    });
  });
</script>

<?php

require_once '../modelos/adminUsuarios.model.php';
$tabla = "usuarios";
$respuesta = Usuarios::listarAdmins($tabla);
$contar = count($respuesta);
if ($contar != 0) {
  if ($respuesta) {
    $json = array();
    echo '
      <table id="tableAdmins" class="table table-sm table-hover" style="width: 100%;">
        <thead class="text-dark" style="background-color:#F7F7F9;">
          <tr style="font-weight:bolder;font-size:small;">
            <th scope="col">Nombre</th>
            <th scope="col">Correo Electrónico</th>
            <th scope="col">Teléfono</th>
            <th scope="col">Tipo Usuario</th>
            <th scope="col" class="text-center">Status</th>
            <th scope="col" class="text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
    ';
    foreach ($respuesta as $key => $value) {
      echo '
      <tr style="font-size:small;">                   <!-- 1 -->
        <td>' . $value['usuario'] . ' ' . $value['app'] . ' ' . $value['apm'] . '</td>              <!-- 2 -->
        <td>' . $value['email'] . '</td>
        <td>' . $value['tel'] . '</td>
        <td>' . $value['tipoUsuario'] . '</td>
        <td class="text-center">
            <div class="custom-control custom-switch">';
      if ($value['status'] != 0) {
        echo '<input type="checkbox" class="custom-control-input switchActivar2" estadoAdmin="0" idUsuario="' . $value['idUsuario'] . '" id="customSwitch' . $value['idUsuario'] . '" checked> <label class="custom-control-label" for="customSwitch' . $value['idUsuario'] . '"></label> ';
      } else {
        echo '<input type="checkbox" class="custom-control-input switchActivar2" estadoAdmin="1" idUsuario="' . $value['idUsuario'] . '" id="customSwitch' . $value['idUsuario'] . '"> <label class="custom-control-label" for="customSwitch' . $value['idUsuario'] . '"></label> ';
      }
      echo ' 
            </div> 
        </td>                                               <!-- 4 -->
        <td class="d-flex justify-content-around">
          <button type="button" class="task-edit-admin btn btn-sm btn-warning" editAd="' . $value['idUsuario'] . '" data-toggle="modal" data-target="#editAdministrador">
            <i class="fa fa-edit"></i>
          </button>
          <button type="button" class="task-delete-admin btn btn-sm btn-danger" deteleAd="' . $value['idUsuario'] . '">
            <i class="fa fa-trash"></i>
          </button>
        </td>
      </tr>
    ';
    }
    echo '
    </tbody>
  </table>';
  }
} else {
  echo '
  <td colspan="4">
    <div class="col-12 alert alert-danger alert-dismissible fade show text-center" role="alert">
      ¡No hay resultados!
    </div>
  </td>';
}
