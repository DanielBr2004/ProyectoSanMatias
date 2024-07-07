<!-- Secciones del documento PDF -->
<page backtop="5mm" backbottom="7mm">
  <page_header>
    <span>Reporte General</span>
  </page_header>
  <page_footer>
    <div class="text-end bg-primary">Página [[page_cu]]/[[page_nb]]</div>
  </page_footer>
</page>
<!-- Fin de secciones -->

<h1 class="text-center text-xl">Producto: <?php echo $datosPRO[0]['producto']; ?></h1>
<br>
<h3 class="text-center">Reporte Generado el día <?= $fechaActual ?></h3> 

<table class="table mt-3">
  <colgroup>
    <col style="width: 5%;">    <!-- ID -->
    <col style="width: 15%;">   <!-- NOMBRE DEL PRODUCTO -->
    <col style="width: 15%;">   <!-- NOMBRE DEL USUARIO -->
    <col style="width: 10%;">   <!-- TIPO DE MOVIMIENTO SALIDA|ENTRADA -->
    <col style="width: 15%;">   <!-- STOCK ACTUAL -->
    <col style="width: 20%;">   <!-- CANTIDAD -->
    <col style="width: 20%;">   <!-- FECHA DE REGISTRO -->
  </colgroup>
  <thead>
    <tr class="bg-tercery text-light">
      <th class="text-center">#</th>
      <th class="text-center">Producto</th>
      <th class="text-center">Colaborador</th>
      <th class="text-center">Tipo de Movimiento</th>
      <th class="text-center">Stock Actual</th>
      <th class="text-center">Cantidad</th>
      <th class="text-center">Fecha de Registro</th>
    </tr>
  </thead>
  <tbody>
    <!-- Asíncrono -->
    <?php
        foreach ($datosPRO as $row) {
          echo "
            <tr>
              <td class='text-center'>{$row['idalmacen']}</td>
              <td class='text-center'>{$row['producto']}</td>
              <td class='text-center'>{$row['nomusuario']}</td>
              <td class='text-center'>{$row['tipomovimiento']}</td>
              <td class='text-center'>{$row['stockactual']}</td>
              <td class='text-center'>{$row['cantidad']}</td>
              <td class='text-center'>{$row['created_at']}</td>
            </tr>
          ";
        }

    ?>
    
  </tbody>
</table>