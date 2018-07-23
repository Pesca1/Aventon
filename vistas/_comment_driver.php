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
    <p>
      <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample<?= $question["id_pregunta"] ?>" role="button" aria-expanded="false" aria-controls="collapseExample<?= $question["id_pregunta"] ?>">
        Responder
      </a>
    </p>
    <div class="collapse" id="collapseExample<?= $question["id_pregunta"] ?>">
      <div class="card card-body">
        <form action="/php/responder_pregunta.php" method="post">
          <input type="hidden" value="<?= $question["id_pregunta"] ?>" name="question_id">
          <input type="hidden" value="<?= $trip_id ?>" name="trip_id">
          <textarea class="form-control" name="answer" rows="2" cols="20" wrap="hard" style="resize: none" required="required" ></textarea><br>
          <button type="submit" class="btn btn-primary"> Enviar</button>
        </form>
      </div>
    </div>
    <?php 
      } else {
    ?>
    <div class="container">
      <h6 style="margin-left: 6%;"><strong>Respondiste:</strong></h6>
      <h6 style="margin-left: 10%;"> - <?= $question["respuesta"] ?></h6> 
    </div>
    <?php
      }
    ?>
</div>


