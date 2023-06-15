$(function () {
  $("#task-result").hide();
  fetchTasks();
  let edit = false;

  $("#search").keyup(() => {
    if ($("#search").val()) {
      let search = $("#search").val();

      $.ajax({
        url: "./buscar-tarea.php",
        data: { search },
        type: "POST",
        success: function (response) {
          if (!response.error) {
            let tasks = JSON.parse(response);
            let template = ``;
            tasks.forEach((task) => {
              template += `<li class="task-item">${task.nombreArea}</li>`;
            });
            $("#task-result").show();
            $("#container").html(template);
          }
        },
      });
    }
  });

  //------------- Añdiendo con ajax zonaArea----------------//
  $("#formularioZona").submit((e) => {
    e.preventDefault();
    const postData = {
      nombreArea: $("#nombreArea").val(),
      // id: $("#taskId").val(),
    };

    // const url = edit === false ? "./insertar-zona.php" : "./editar-zona.php";

    $.ajax({
      url: "./insertar-zona.php",
      data: postData,
      type: "POST",
      success: function (response) {
        if (!response.error) {
          fetchTasks();
          $("#formularioZona").trigger("reset");
        }
      },
    });
  });
  //----------------- Muestra respuesta y añade a mi tabla lo añadido --------------- //
  function fetchTasks() {
    $.ajax({
      url: "./listar-zona.php",
      type: "GET",
      success: function (response) {
        const tasks = JSON.parse(response);
        let template = ``;
        tasks.forEach((task) => {
          const fechaActual = new Date(task.fecha).toISOString().slice(0, 10);
          const partesFecha = fechaActual.split("-");
          const fechaFormateada = `${partesFecha[2]}-${partesFecha[1]}-${partesFecha[0]}`;
          template += `
                    <tr taskId="${task.id}">
                        <td>${task.id}</td>
                        <td>${task.codigo}</td>
                        <td>${task.nombreArea}</td>
                        <td>${fechaFormateada}</td>
                        <td>${task.version}</td>
                        <td>
                          <button class="btn btn-warning task-item">Modificar</button>
                        </td>
                        <td>
                          <button class="btn btn-danger task-delete">Eliminar</button>
                        </td>
                        
                    </tr>
                    `;
        });
        $("#tbZona").html(template);
      },
    });
  }

  //------------------------ Elimina un dato de mi tabla ----------------- //

  $(document).on("click", ".task-delete", () => {
    if (confirm("¿Seguro que quieres eliminar esa tarea?")) {
      const element = $(this)[0].activeElement.parentElement.parentElement;
      const id = $(element).attr("taskId");
      $.post("./eliminar-zona.php", { id }, () => {
        fetchTasks();
      });
    }
  });
});

//------------------------------- Edita los datos de la tabla --------------- //
$(document).on("click", ".task-item", () => {
  const elementos = $(this)[0].activeElement;
  console.log(elementos);
  // Resto del código que utiliza 'element'

  // const element = $(this)[0].activeElement.parentElement.parentElement;
  // const id = $(elementos).attr("taskId");
  // let url = "./editar-zona.php";
  // $.ajax({
  //   url,
  //   data: { id },
  //   type: "POST",
  //   success: function (response) {
  //     if (!response.error) {
  //       const task = JSON.parse(response);
  //       $("#nombreArea").val(task.nombreArea);

  //       $("#taskId").val(task.id);
  //       edit = true;
  //     }
  //   },
  // });
});
