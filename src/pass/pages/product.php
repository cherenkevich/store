<?php
$path = $_SERVER['REQUEST_URI'];
$path = explode("/", $path);

$id = $path[2];

// если такого товара нету или это ПДФка — на главную
if (!isset($data->$id)) {
    header('location: /');
}
// если это ПДФка — редиректим на продукт
if ($data->$id->type == "pdf") {
    header('location: /products/' . $data->$id->parent . '/');
}

// данные продукта
$product = $data->$id;

// данные связанной ПДФки
$pdf = $product->pdf;
$pdf = $data->$pdf;

$title = $product->title;
?>
<!DOCTYPE html>
<html class="html html--product" lang="en">

<head>
    <?php include 'partials/head.php' ?>
</head>

<body>
    <div class="app">

        <div class="app__header">
            <div class="app__column">
                <?php include 'partials/header.php' ?>
            </div>
        </div>

        <div class="app__cart">
            <?php include 'partials/cart.php' ?>
        </div>

        <div class="app__heading">
            <div class="app__column">
                <h1 class="heading">
                    <?= $product->title ?>
                    <div class="pale">Paper & digital</div>
                </h1>
            </div>
        </div>

        <div class="app__carousel">
            <div class="carousel">
                <div class="carousel__wrapper">
                    <div class="carousel__content">

                        <div class="carousel__image">
                            <div><img src="/images/<?= $product->cover[0] ?>" width="<?= $product->cover[1] ?>" height="<?= $product->cover[2] ?>"></div>
                        </div>

                        <?php foreach ($product->images as $image) : ?>

                            <div class="carousel__image">
                                <div><img src="/images/<?= $image[0] ?>" width="<?= $image[1] ?>" height="<?= $image[2] ?>"></div>
                            </div>

                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="app__actions">
            <div class="app__column">
                <div class="actions">
                    <div class="actions__action">
                        <div class="slot">
                            <div class="slot__left">
                                <div class="slot__primary">
                                    <div class="add">
                                        <div class="add__add">
                                            <label data-product="<?= $product->id ?>" class="rarr" for="add">Buy a paper version · <?= $product->price ?> €</label>
                                        </div>
                                        <div class="add__added">Added. <a href="/cart/" class="rarr">Go to cart</a> </div>
                                        <input class="add__state" type="checkbox" id="add" <?= !empty($cart['items']) && array_key_exists($product->id, $cart['items']) ? "checked" : "" ?> />
                                    </div>
                                </div>
                                <div class="slot__secondary"><?= $product->meta ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="actions__action">
                        <div class="slot">
                            <div class="slot__left">
                                <div class="slot__primary">
                                    <div class="add">
                                        <div class="add__add">
                                            <label data-product="<?= $pdf->id ?>" class="rarr" for="add2">Buy a PDF-version · <?= $pdf->price ?> €</label>
                                        </div>
                                        <div class="add__added">Added. <a href="/cart/" class="rarr">Go to cart</a> </div>
                                        <input class="add__state" type="checkbox" id="add2" <?= !empty($cart['items']) && array_key_exists($pdf->id, $cart['items']) ? "checked" : "" ?> />
                                    </div>
                                </div>
                                <div class="slot__secondary">Instant download</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="app__text">
            <div class="app__column">
                <div class="text">
                    <?= $product->description ?>
                </div>
            </div>
        </div>

        <div class="app__text">
            <div class="app__column">
                <div class="text">
                    <p><a class="larr" href="/">Back to all the issues</a></p>
                </div>
            </div>
        </div>

        <div class="app__footer">
            <div class="app__column">
                <?php include 'partials/footer.php' ?>
            </div>
        </div>

    </div>
    <?php include 'partials/foot.php' ?>
</body>

</html>