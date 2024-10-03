
<section id="main-content">
          <section class="wrapper">

<?php
//print_r($alumnos);
?>

<table id="alumnos" class="display">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Nombre usuario</th>
            <th>Curso</th>
            <th>Editar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($alumnos as $a) {
        ?>
            <tr id="rowalumno<?= $a->id ?>">
                <td><?= $a->nombre ?></td>
                <td><?= $a->apellidos ?></td>
                <td><?= $a->username ?></td>
                <td><?= $a->curso ?></td>
                <td><i class="eliminar fa fa-trash-o " style="cursor:pointer" id="alumno-<?= $a->id ?>"></i></td>
            </tr>
        <?php
        
        }
        ?>
    </tbody>
</table>
</section>
</section>

<script type="text/javascript">
    $(".eliminar").click(function(){
        var idalumno=this.id;
        var id=idalumno.split("-");
        var id=id[1];
        
        $.post("<?= base_url() ?>Dashboard/eliminarAlumno",{ idalumno: id}).done(function(data){
            $("#rowalumno"+id).fadeOut();
            console.log(id);
        });

    });
   
</script>

<script type="text/javascript">
//let table = new DataTable('#alumnos');
$(document).ready( function () {
    $('#alumnos').DataTable();
} );
</script>