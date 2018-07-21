<div class="vehicle">
  <div class="vehicle-info">
  <h3>Transacción como <span class="badge badge-success">Conductor</span></h3>
  <div class="container">
    <h5>El dia <?= date("d/m/Y H:i", strtotime($transaction["fecha_hora"])) ?></h5>
    <h5>Se le ha depositado $<?= floatval($transaction["monto"]) ?> por el viaje como conductor de <?= $trip["origen"] ?> a <?= $trip["destino"] ?> </h5> 
  </div>
  </div>
</div>