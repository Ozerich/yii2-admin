<div class="image-widget">
    <? if ($model): ?>
        <div class="image-widget__current">
            <a href="<?= $model->getUrl() ?>" target="_blank">
                <img src="<?= $model->getUrl() ?>" style="max-width: 300px;">
            </a>
        </div>
        <?= $input_hidden_html ?>
    <? else: ?>
        <div class="image-widget__input">
            <?= $input_html ?>
        </div>
    <? endif; ?>

    <div class="image-widget__remove" style="display: <?= $model ? 'block' : 'none' ?>">
        <br />
        <button class="btn btn-mini btn-danger js-image-remove">Удалить</button>
    </div>
</div>

<script>
  $('.js-image-remove').on('click', function () {
    var $parent = $(this).parents('.image-widget');
    $('.image-widget__current', $parent).hide();
    $('.image-widget__remove', $parent).hide();

    var fileInput = $('input[type=file]', $parent).get(0);

    fileInput.type = '';
    fileInput.type = 'file';

    $('input[type=hidden]', $parent).val('').attr('type', 'file');

    return false;
  });

  $('.image-widget__input input').on('change', function(){
    $(this).parents('.image-widget').find('.image-widget__remove').show();
  });
</script>