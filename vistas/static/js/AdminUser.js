$(document).ready(function () {
 
  ListarAdmins();
 

  
  function ListarAdmins() {
    $.ajax({
      url: "controladores/printViewUsersAdmin.ajax.php",
      type: "GET",
      success: function (response) {
        $("#tablePrintAdmins").html(response);
       
      },

      error: function (data) {
        template += "<p>error :p</p>";
        $("#tablePrintAdmins").html(template);
      },
    });
  }

$("#tablePrintAdmins").on("click", ".switchActivar2", function () {
    var idUsuario = $(this).attr("idUsuario");
    var estadoAdmin = $(this).attr("estadoAdmin");
    var datos = new FormData();
    datos.append("activarId", idUsuario);
    datos.append("activarAdmins", estadoAdmin);

    $.ajax({
      url: "controladores/AdUsuarios.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {},
    });
  });

  $("#newaddadmin").submit((e) => {
    e.preventDefault();
    var con = $("#pass").val().length;
    var strongRegex = new RegExp(
      "^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).*$",
      "g"
    );
    if (con == 0) {
      $("#msj").html("");
      $("#msj").removeClass("incorrect");
    } else {
      if (false == strongRegex.test($("#pass").val())) {
        $("#msj").html("Contraseña inválida. Debe contener una longitud de 8 caracteres con letras mayúsculas, minúsculas y números");
        $("#msj").addClass("incorrect");
        $("#msj").removeClass("correct");
      } else {
        const postData = {
          nombre: $("#nombre").val(),
          app: $("#app").val(),
          apm: $("#apm").val(),
          pass: $("#pass").val(),
          email: $("#email").val(),
          tel: $("#tel").val(),
          tipou: $("#tipou").val(),
          status: $("#status").val(),
        };
        $.post("controladores/AdUsuarios.ajax.php", postData, (response) => {
          if ((response != "ok")) {
            $("#newaddadmin").trigger("reset");
            $("#msj").removeClass("incorrect");
             $("#newAdmin").modal("hide");
            ListarAdmins();
            notificacionAgregado();
          } else {
            notificacionError();
          }
        });
      }
    }
  });




  $(document).on("click", "#exit", function (e) {
    $("#newaddadmin").trigger("reset");
  });

  $(document).on("click", ".task-delete-admin", function (e) {
    const id = $(this).attr("deteleAd");
    swal({
      title: "¿Está seguro de eliminar el registro?",
      text: "¡Si no lo está puede cancelar la acción!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Sí, eliminar registro",
    }).then(function (result) {
      if (result.value) {
        $.post("controladores/AdUsuarios.ajax.php", { id }, (response) => {
          if (response == "ok") {
            notificacionEliminar();
            ListarAdmins();
          } else {
            notificacionErrorEliminar();
          }
        });
      }
    });
  });

  $(document).on("click", ".task-edit-admin", function (e) {
    const idback = $(this).attr("editAd");
    $.post("controladores/AdUsuarios.ajax.php", { idback }, (response) => {
       $("#msj2").html("");
      const task = JSON.parse(response);
      $("#input1").val(task.idUsuario);
      $("#enombre").val(task.nombre);
      $("#eapp").val(task.app);
      $("#eapm").val(task.apm);
      $("#defi").val(task.pass);
      $("#eemail").val(task.email);
      $("#etel").val(task.tel);
      $("#etipou").val(task.tipoU);
    });
  });

  $("#editaddadmin").submit((e) => {
    e.preventDefault();
    console.log("Entro");
    var con = $("#epass").val().length;
    console.log(con);
    var strongRegex = new RegExp(
      "^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).*$",
      "g"
    );
    if (con == 0) {
      $("#msj2").html("");
      $("#msj2").removeClass("incorrect");
     // console.log("Entro IF");
      const postData = {
          idu: $("#input1").val(),
          enombre: $("#enombre").val(),
          eapp: $("#eapp").val(),
          eapm: $("#eapm").val(),
          defi: $("#defi").val(),
          epass: $("#epass").val(),
          eemail: $("#eemail").val(),
          etel: $("#etel").val(),
          etipou: $("#etipou").val()
        };
       // console.log(postData);
        const url = "controladores/AdUsuarios.ajax.php";
        $.post(url, postData, (response) => {
          if (response != "ok") {
            ListarAdmins();
            $("#editaddadmin").trigger("reset");
            $("#msj2").html("");
             $("#editAdministrador").modal("hide");
            notificacionActualizado();
          } else {
            notificacionErrorActualizado();
          }
        });
    } else {
      //console.log("Entro ELSE");
      if (false == strongRegex.test($("#epass").val())) {
        $("#msj2").html("Contraseña inválida.");
        $("#msj2").addClass("incorrect");
        $("#msj2").removeClass("correct");
      } else {
        const postData = {
          idu: $("#input1").val(),
          enombre: $("#enombre").val(),
          eapp: $("#eapp").val(),
          eapm: $("#eapm").val(),
          defi: $("#defi").val(),
          epass: $("#epass").val(),
          eemail: $("#eemail").val(),
          etel: $("#etel").val(),
          etipou: $("#etipou").val()
        };
        console.log(postData);
        const url = "controladores/AdUsuarios.ajax.php";
        $.post(url, postData, (response) => {
          if (response != "ok") {
            ListarAdmins();
            $("#editAdministrador").modal("hide");
            $("#editaddadmin").trigger("reset");
            notificacionActualizado();
          } else {
            notificacionErrorActualizado();
          }
        });
      }
    }
  });

  function notificacionAgregado() {
    swal({
      title: "El administrador ha sido agregado",
      text: "",
      type: "success",
      showCancelButton: false,
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Confirmar",
    });
  }

  function notificacionError() {
    swal({
      title: "El administrador no ha sido agregado",
      text: "",
      type: "error",
      showCancelButton: false,
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Confirmar",
    });
  }

  function notificacionEliminar() {
    swal({
      title: "El administrador ha sido eliminado",
      text: "",
      type: "success",
      showCancelButton: false,
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Confirmar",
    });
  }

  function notificacionErrorEliminar() {
    swal({
      title: "El administrador no ha sido eliminado",
      text: "",
      type: "error",
      showCancelButton: false,
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Confirmar",
    });
  }

  function notificacionActualizado() {
    swal({
      title: "El administrador ha sido actualizado",
      text: "",
      type: "success",
      showCancelButton: false,
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Confirmar",
    });
  }

  function notificacionErrorActualizado() {
    swal({
      title: "El administrador no ha sido actualizado",
      text: "",
      type: "error",
      showCancelButton: false,
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Confirmar",
    });
  }



});
