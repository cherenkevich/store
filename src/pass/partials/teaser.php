<?php
$pdf = $teaser->pdf;
$pdf = $data->$pdf;
?><a class="teaser" href="/products/<?= $teaser->id ?>/">
    <div class="teaser__media">
        <div class="teaser__image teaser__image--cover teaser__image--top">
            <img src="/images/<?= $teaser->cover[0] ?>" width="<?= $teaser->cover[1] ?>" height="<?= $teaser->cover[2] ?>" />
        </div>

        <?php foreach ($teaser->images as $image) : ?>

            <div class="teaser__image teaser__image--spread">
                <img src="/images/<?= $image[0] ?>" width="<?= $image[1] ?>" height="<?= $image[2] ?>" />
            </div>

        <?php endforeach; ?>

    </div>
    <div class="teaser__caption">
        <div class="slot">
            <div class="slot__left">
                <div class="slot__primary">
                    <h3>
                        <span><?= $teaser->title ?></span>
                    </h3>
                </div>
                <div class="slot__secondary">Paper version · <?= $teaser->price ?> € <br />PDF-version · <?= $pdf->price ?> €</div>
            </div>
        </div>
    </div>
</a>