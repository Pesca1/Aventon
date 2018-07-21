<div class="vehicle">
  <div class="vehicle-info">
  <h3>Transacción como <span class="badge badge-success">Pasajero</span></h3>
  <div class="container">
    <h5>El dia <?= date("d/m/Y H:i", strtotime($transaction["fecha_hora"])) ?></h5>
    <h5>Se le ha descontado $<?= floatval($transaction["monto"]) ?> por el viaje como pasajero de <?= $trip["origen"] ?> a <?= $trip["destino"] ?> </h5> 
  </div>
  </div>
</div>