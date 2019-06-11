<?php
/**
 * @var int $zoom
 * @var float[] $center
 */
?>
<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"
        integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA=="
        crossorigin=""></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"
      integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
      crossorigin="" />

<div class="map_widget">
  <div id="map" style="height: 500px; width: 100%;"></div>
    <?= \yii\helpers\Html::activeHiddenInput($model, $attribute); ?>
</div>

<? $value = $model->{$attribute};
$value = empty($value) ? null : explode(',', $value); ?>

<script>
  (function ($) {
    const INPUT_ID = "<?=\yii\helpers\BaseHtml::getInputId($model, $attribute)?>";

    $(document).ready(function () {
      var mapOptions = {
        center: [<?=str_replace(',', '.', $center[0])?>, <?=str_replace(',', '.', $center[1])?>],
        zoom: <?=$zoom?>
      };

      var map = new L.map('map', mapOptions);
      map.addLayer(new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'));

      var marker = null;

        <? if($value): ?>
      marker = L.marker([<?=$value[0]?>, <?=$value[1]?>], { draggable: true });
      marker.addTo(map);
        <? endif; ?>

      map.on('click', function (e) {
        var click_lat = e.latlng.lat;
        var click_lng = e.latlng.lng;

        if (marker) {
          map.removeLayer(marker);
        }

        marker = L.marker([click_lat, click_lng]).addTo(map);

        $('#' + INPUT_ID).val(click_lat + ',' + click_lng);
      });
    });
  })(jQuery);
</script>

