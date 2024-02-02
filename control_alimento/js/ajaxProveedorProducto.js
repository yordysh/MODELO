$(function () {
  fetchTasks();
  let edit = false;
  //===== Prealoder

  window.onload = function () {
    fadeout();
  };

  function fadeout() {
    document.querySelector(".preloader").style.opacity = "0";
    document.querySelector(".preloader").style.display = "none";
  }
  //----------------------------------------------------------------//

  $("#selectprovedores").select2();
  $("#selectproductosproveedores").select2();
  /*---------------------------- INSERTAR PROVEEDORES-------------- */
  $(document).on("click", "#botonguardarproveedor", (e) => {
    e.preventDefault();
    let selectprovedores = $("#selectprovedores").val();
    let selectproductosproveedores = $("#selectproductosproveedores").val();
    let cantidadMinima = $("#cantidadMinima").val();
    let precioproducto = $("#precioproducto").val();
    let selectmoneda = $("#selectmoneda").val();
    if (!selectprovedores) {
      Swal.fire({
        title: "¡Necesita seleccionar un proveedor!",
        icon: "info",
        confirmButtonText: "Aceptar",
      });
      return;
    } else if (!selectproductosproveedores) {
      Swal.fire({
        title: "¡Necesita seleccionar un producto!",
        icon: "info",
        confirmButtonText: "Aceptar",
      });
      return;
    } else if (!cantidadMinima) {
      Swal.fire({
        title: "¡Necesita insertar una cantidad!",
        icon: "info",
        confirmButtonText: "Aceptar",
      });
      return;
    } else if (!precioproducto) {
      Swal.fire({
        title: "¡Necesita insertar un precio!",
        icon: "info",
        confirmButtonText: "Aceptar",
      });
      return;
    } else if (!selectmoneda) {
      Swal.fire({
        title: "¡Necesita seleccionar tipo de moneda!",
        icon: "info",
        confirmButtonText: "Aceptar",
      });
      return;
    }
    const accion =
      edit === false
        ? "insertarproveedorproducto"
        : "actualizarproveedorproducto";
    $.ajax({
      url: "./c_almacen.php",
      data: {
        accion: accion,
        selectprovedores: selectprovedores,
        selectproductosproveedores: selectproductosproveedores,
        cantidadMinima: cantidadMinima,
        precioproducto: precioproducto,
        selectmoneda: selectmoneda,
        codminimo: $("#taskId").val(),
      },

      type: "POST",
      success: function (response) {
        if (response == "ok") {
          Swal.fire({
            title: "¡Guardado exitoso!",
            text: "Los datos se han guardado correctamente.",
            icon: "success",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              fetchTasks();
              $("#selectprovedores").val("none").trigger("change");
              $("#selectproductosproveedores").val("none").trigger("change");
              $("#cantidadMinima").val("");
              $("#precioproducto").val("");
              $("#selectmoneda").val("none").trigger("change");
              $("#selectproductosproveedores").prop("disabled", false);
              $("#selectprovedores").prop("disabled", false);
            }
          });
        } else {
          Swal.fire({
            title: "Duplicado",
            text: "Los datos del producto son duplicados.",
            icon: "error",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              fetchTasks();
              $("#selectprovedores").val("none").trigger("change");
              $("#selectproductosproveedores").val("none").trigger("change");
              $("#cantidadMinima").val("");
              $("#precioproducto").val("");
              $("#selectmoneda").val("none").trigger("change");
            }
          });
        }
      },
    });
  });
  /*-------------------------------------------------------------- */
  /*-----------------------Cargar datos de proveedores precios ---------------------*/
  function fetchTasks() {
    const accion = "buscarProveedorPrecios";
    const search = "";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion, buscarProveedorPrecios: search },
      success: function (response) {
        if (isJSON(response)) {
          let tasks = JSON.parse(response);
          let template = ``;
          tasks.forEach((task) => {
            let tipomoneda = task.TIPO_MONEDA;
            let moneda;
            if (tipomoneda == "S") {
              moneda = "SOLES";
            } else {
              moneda = "DOLARES";
            }
            template += `<tr taskId="${task.COD_CANTIDAD_MINIMA}">
            <td data-titulo="PRIORIZA" style="text-align:center;"><input  class="form-check-input" type="checkbox" ${
              task.ESTADO === "A" ? "checked" : ""
            } id="checkproveedor"></td>
            <td data-titulo="PROVEEDOR">${task.NOM_PROVEEDOR}</td>
            <td data-titulo="PRODUCTOS">${task.DES_PRODUCTO}</td>
            <td data-titulo="CANTIDAD">${task.CANTIDAD_MINIMA}</td>
            <td data-titulo="PRECIO">${parseFloat(task.PRECIO_PRODUCTO).toFixed(
              2
            )}</td>
            <td data-titulo="MONEDA">${moneda}</td>

            <td  style="text-align:center;"><button class="btn btn-danger task-delete" data-COD_CANTIDAD_MINIMA="${
              task.COD_CANTIDAD_MINIMA
            }"><i class="icon-trash"></i></button></td>
            <td  style="text-align:center;"><button class="btn btn-success task-update" name="editar" id="edit" data-COD_CANTIDAD_MINIMA="${
              task.COD_CANTIDAD_MINIMA
            }"><i class="icon-edit"></i></button></td>

        </tr>`;
          });

          $("#tablacantidadminima").html(template);
        } else {
          $("#tablacantidadminima").empty();
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }
  /*---------------------------------------------------------------------------- */

  /*-----------------------Busqueda de proveedores precios ---------------------*/
  $("#search").keyup(() => {
    if ($("#search").val()) {
      var search = $("#search").val();
      const accion = "buscarProveedorPrecios";
      $.ajax({
        url: "./c_almacen.php",
        type: "POST",
        data: { accion: accion, buscarProveedorPrecios: search },
        success: function (response) {
          if (isJSON(response)) {
            let tasks = JSON.parse(response);

            let template = ``;
            tasks.forEach((task) => {
              let tipomoneda = task.TIPO_MONEDA;
              let moneda;
              if (tipomoneda == "S") {
                moneda = "SOLES";
              } else {
                moneda = "DOLARES";
              }
              template += `<tr taskId="${task.COD_CANTIDAD_MINIMA}">
              <td data-titulo="PRIORIZA" style="text-align:center;"><input  class="form-check-input" type="checkbox" ${
                task.ESTADO === "A" ? "checked" : ""
              } id="checkproveedor"></td>
              <td data-titulo="PROVEEDOR">${task.NOM_PROVEEDOR}</td>
              <td data-titulo="PRODUCTOS">${task.DES_PRODUCTO}</td>
              <td data-titulo="CANTIDAD">${task.CANTIDAD_MINIMA}</td>
              <td data-titulo="PRECIO">${task.PRECIO_PRODUCTO}</td>
              <td data-titulo="MONEDA">${moneda}</td>
  
              <td  style="text-align:center;"><button class="btn btn-danger task-delete" data-COD_CANTIDAD_MINIMA="${
                task.COD_CANTIDAD_MINIMA
              }"><i class="icon-trash"></i></button></td>
              <td  style="text-align:center;"><button class="btn btn-success task-update" name="editar" id="edit" data-COD_CANTIDAD_MINIMA="${
                task.COD_CANTIDAD_MINIMA
              }"><i class="icon-edit"></i></button></td>
  
          </tr>`;
            });

            $("#tablacantidadminima").html(template);
          } else {
            $("#tablacantidadminima").empty();
          }
        },
        error: function (xhr, status, error) {
          console.error("Error al cargar los datos de la tabla:", error);
        },
      });
    } else {
      fetchTasks();
    }
  });
  /*----------------------------------------- ---------------------*/

  //------------------------ Pone el dato de tabla en su respectivo campo ----------------- //

  $(document).on("click", ".task-update", () => {
    var element = $(this)[0].activeElement.parentElement.parentElement;

    var cod_mini = $(element).attr("taskId");
    const accion = "editarproveedorprecios";

    $.ajax({
      url: "./c_almacen.php",
      data: { accion: accion, cod_mini: cod_mini },
      type: "POST",
      success: function (response) {
        if (!response.error) {
          const task = JSON.parse(response);

          $("#selectproductosproveedores").prop("disabled", true);
          $("#selectprovedores").prop("disabled", true);
          $("#selectproductosproveedores").append(
            new Option(task.DES_PRODUCTO, task.COD_PRODUCTO, true, true)
          );
          $("#selectprovedores").append(
            new Option(task.NOM_PROVEEDOR, task.COD_PROVEEDOR, true, true)
          );
          $("#cantidadMinima").val(task.CANTIDAD_MINIMA);
          var precioProducto = parseFloat(
            task.PRECIO_PRODUCTO.replace(",", ".")
          );
          $("#precioproducto").val(precioProducto);
          $("#taskId").val(task.COD_CANTIDAD_MINIMA);
          $("#selectmoneda").val(task.TIPO_MONEDA);
          edit = true;
        }
      },
    });
  });
  //--------------------------------------------------------------------------------------//

  //------------------------ Elimina un dato de mi tabla ----------------- //

  $(document).on("click", ".task-delete", function (e) {
    e.preventDefault();

    var cod_cantidad_min = $(this).attr("data-COD_CANTIDAD_MINIMA");

    const accion = "eliminarcantidadminima";

    Swal.fire({
      title: "¿Está seguro de eliminar este registro?",
      text: "Esta acción no se puede deshacer.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, eliminar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "./c_almacen.php",
          data: { accion: accion, cod_cantidad_min: cod_cantidad_min },
          type: "POST",
          success: function (response) {
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Registro eliminado correctamente.",
              showConfirmButton: false,
              timer: 1500,
            });
            fetchTasks();
          },
          error: function (xhr, status, error) {
            console.error("Error:", error);
          },
        });
      }
    });
  });
  /*--------------------------------------------------------------------- */
  /*-------------------------------Check cambio de estado cantidad minima------------ */
  $("#tablacantidadminima").on("click", "#checkproveedor", function () {
    var value = $(this).val();
    var taskId = $(this).closest("tr").attr("taskId");
    if ($(this).prop("checked")) {
      const accion = "cambiarestadocantidadminima";
      $.ajax({
        url: "./c_almacen.php",
        data: { accion: accion, taskId: taskId },
        type: "POST",
        success: function (response) {
          if (response == "ok") {
            fetchTasks();
          }
        },
      });

      // alert("Checkbox checked for task ID " + taskId + " with value " + value);
      // You can perform additional actions when the checkbox is checked
    } else {
      var id = $(this).closest("tr").attr("taskId");
      const accion = "cambiarestado";
      $.ajax({
        url: "./c_almacen.php",
        data: { accion: accion, id: id },
        type: "POST",
        success: function (response) {
          if (response == "ok") {
            fetchTasks();
          }
        },
      });

      // You can perform additional actions when the checkbox is unchecked
    }
  });
  /*-------------------------------------------------------------------------------- */
});
function isJSON(str) {
  try {
    JSON.parse(str);
    return true;
  } catch (e) {
    return false;
  }
}
