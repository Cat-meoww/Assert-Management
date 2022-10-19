<?php if (!empty($errors)) : ?>
    <?php foreach ($errors as $error) : ?>
        <div class="alert alert-info" role="alert">
            <div class="iq-alert-text"><?= esc($error) ?></div>
        </div>
    <?php endforeach ?>
<?php endif ?>