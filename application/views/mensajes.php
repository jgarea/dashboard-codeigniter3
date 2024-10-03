<section id="main-content">
  <section class="wrapper">

    <div class="row">

      <button class="btn btn-success btn-md" data-toggle="modal" data-target="#myModal" id="btnmensaje"> Enviar Mensaje
      </button>

    </div>

    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <table id="alumnos" class="display">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Apellidos</th>
              <th>Fecha</th>
              <th>Leer</th>
            </tr>
          </thead>
          <tbody>
            <?php
foreach ($mensajes as $m) {

    //print_r($m);
    $nombreyapellidos = $this->Site_model->getNombre($m->id_from);
    // $apellidos=$this->Site_model->getNombre("apellidos",$m->id_from);
    $nombre = $nombreyapellidos[0]->nombre;
    $apellidos = $nombreyapellidos[0]->apellidos;

    if ($m->is_read == 1) {
        $class = "isreadclass";
    } else {
        $class = "noreadclass";
    }

    ?>
            <tr>
              <td>
                <?=$nombre?>
              </td>
              <td>
                <?=$apellidos?>
              </td>
              <td>
                <?=date('d-m H:i', strtotime($m->created_at))?>
              </td>
              <td id="vermensaje-<?=$m->id?>" class="<?=$class?>"
                onclick="vermensaje(<?=$m->id?>,'<?=$nombre?>',this.id)">Ver</td>
            </tr>
            <?php
}

?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
      style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Enviar mensaje</h4>
          </div>
          <div class="modal-body">
            <form action="" method="post">
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Destinatario</label>
                <div class="col-sm-10">
                  <select name="id_to" class="form-control">
                    <option value="0">Selecciona un usuario</option>
                    <?php
                      foreach ($usuarios as $c) {
                          echo "<option id='user-" . $c->id . "' value='" . $c->token_mensaje . "'>" . $c->nombre . " " . $c->apellidos . "</option>";
                      }
                    ?>
                  </select><br>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Mensaje</label><br>
                <div class="col-sm-10">
                  <textarea name="mensaje" cols="6" class="form-control"></textarea><br>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label"></label><br>
                <div class="col-sm-10">
                  <input type="submit" value="Enviar" class="form-control">
                </div>
              </div>
            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 25px;">Cerrar</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="modalmensaje" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
      aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Mensaje de</h4>
          </div>
          <div class="modal-body">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 25px;">Cerrar</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
          </div>
        </div>
      </div>
    </div>

  </section>
</section>




<script type="text/javascript">
  function vermensaje(id, nombre, idver) {
    console.log(nombre);
    $.post("http://localhost/udemyold/Dashboard/getMensaje", { idmensaje: id }).done(function (data) {

      if (data) {
        $("#" + idver).removeClass("noreadclass");
        $("#" + idver).addClass("isreadclass");
        $("#modalmensaje .modal-title").append(nombre);
        $("#modalmensaje .modal-body").html(data);
        $("#modalmensaje").modal("show");

      }
    });
  }


  //let table = new DataTable('#alumnos');
  $(document).ready(function () {
    $('#alumnos').DataTable();
  });
</script>