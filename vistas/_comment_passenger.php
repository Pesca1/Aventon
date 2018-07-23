<div class="question">
  <div class="row">
      <div class="col-md-12">
        <img src='/img/profile_users/<?= $user["foto_perfil"]?>' class='profile_picture'/>
          <strong style="color:red;"><?= $user["nombre"]." ".$user["apellido"] ?></strong>
            preguntó:<hr>
      </div>
    </div>
    <h6 style="margin-left: 4%;"> - <?= $question["texto"]?></h6> 
    <?php if($question["respuesta"] == ""){ ?>
    <strong>Sin responder aún</strong>
    <?php 
      } else {
    ?>
    <div class="container">
      <h6 style="margin-left: 6%;"><strong><?= $passenger["nombre"]." ".$passenger["apellido"] ?></strong> respondio</h6>
      <h6 style="margin-left: 10%;"> - <?= $question["respuesta"] ?></h6> 
    </div>
     
    <?php
      }
    ?>
</div>