<script>
  $(document).ready(function() {
    var tableAdmins = $('#tableAdmins').DataTable({
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
      <table id="tableAdmins" class="table table-striped">
        <thead style="background: linear-gradient(to right, #243B55,#141E30);">
          <tr style="font-weight:bolder;font-size:small;">
            <th scope="col" class="text-white">Nombre</th>
            <th scope="col" class="text-white">Apellido Paterno</th>
            <th scope="col" class="text-white">Apellido Materno</th>
            <th scope="col" class="text-white">Correo Electrónico</th>
            <th scope="col" class="text-white">Teléfono</th>
            <th scope="col" class="text-white">Tipo Usuario</th>
            <th scope="col" class="text-white">Status</th>
            <th scope="col" style="width: 100px" class="text-white">Acciones</th>
          </tr>
        </thead>
        <tbody>
    ';
    foreach ($respuesta as $key => $value) {
      echo '
      <tr style="font-size:small;">                   <!-- 1 -->
        <td>' . $value['usuario'] . '</td>              <!-- 2 -->
        <td>' . $value['app'] . '</td>
        <td>' . $value['apm'] . '</td>
        <td>' . $value['email'] . '</td>
        <td>' . $value['tel'] . '</td>
        <td>' . $value['tipoUsuario'] . '</td>
        <td>
            <div class="custom-control custom-switch">';
            if ($value['status'] != 0) {
                echo '<input type="checkbox" class="custom-control-input switchActivar2" estadoAdmin="0" idUsuario="' . $value['idUsuario'] . '" id="customSwitch' . $value['idUsuario'] . '" checked> <label class="custom-control-label" for="customSwitch' . $value['idUsuario'] . '"></label> ';
            } else {
                echo '<input type="checkbox" class="custom-control-input switchActivar2" estadoAdmin="1" idUsuario="' . $value['idUsuario'] . '" id="customSwitch' . $value['idUsuario'] . '"> <label class="custom-control-label" for="customSwitch' . $value['idUsuario'] . '"></label> ';
            }
        echo ' 
            </div> 
        </td>                                               <!-- 4 -->
        <td align="center">
          <button type="button" class="task-edit-admin btn btn-xs" editAd="' . $value['idUsuario'] . '" data-toggle="modal" data-target="#editAdministrador"  style="background:#6fb430; color: white">
            <i class="fa fa-edit"></i>
          </button>
          <button type="button" class="task-delete-admin btn btn-xs" deteleAd="' . $value['idUsuario'] . '"  style="background: #b91926;color: white">
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