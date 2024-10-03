<section id="main-content">
<section class="wrapper">

<div class="row">
<?php
foreach ($tareas as $t) {
   

?>
<div class="col-md-4 tarea">
    <div class="row">
        <strong><?= $t->nombre ?></strong>
    </div>
    <div class="row">
        <?= $t->descripcion ?>
    </div>
    <div class="row">
        <?= date('d-m-Y',strtotime($t->fecha_final)) ?>
    </div>
    <?php
    if($t->archivo!=""){
    ?>
    <div class="row">
        <a href="<?= base_url().'uploads/'.$t->archivo ?>" download>Descargar</a>
    </div>

    <?php
    }else{
        echo "Sin archivo";
    }
    ?>
    


    
</div>


<?php
}
?>

</div>


</section>
</section>