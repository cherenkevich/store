<?php
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// require '3rdparty/PHPMailer/src/Exception.php';
// require '3rdparty/PHPMailer/src/PHPMailer.php';
// require '3rdparty/PHPMailer/src/SMTP.php';

// смотрим, что в гете в ids приехало. если ничего — на главную
if (!isset($_GET['ids']) || !$_GET['ids']) {
    header('location: /');
}

$ids = (array)json_decode($_GET['ids']);
$purchases = get_cart(array_keys($ids));

if (empty($purchases['items'])) {
    header('location: /');
}

$title = 'Successful payment';
?>
<!DOCTYPE html>
<html class="html html--success" lang="en">

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
                    Successful payment
                    <?php if ($purchases['shipping']) : ?>
                        <div class="pale">The paper <?= count($purchases['paper']) > 1 ? 'magazines' : 'magazine' ?> will be shipped within 1–2 working days. You will receive a tracking number via email</div>
                    <?php endif; ?>
                </h1>
            </div>
        </div>

        <div class="app__list">
            <div class="app__column">
                <div class="list">

                    <?php foreach ($purchases['items'] as $key => $row): ?>

                        <div class="list__row">
                            <div class="slot">
                                <div class="slot__left">
                                    <div class="slot__primary">
                                        <h3>
                                            <a href="/products/<?= $row->type == 'paper' ? $row->id : $row->parent ?>/"><?= $row->title ?></a>
                                        </h3>
                                    </div>
                                    <div class="slot__secondary"><?= $row->type == "pdf" ? "PDF-version" : "Paper version" ?></div>

                                    <?php if ($row->type == 'pdf' && $row->download == $ids[$key]) : ?>
                                        <div class="slot__tertiary">
                                            <a class="rarr" href="<?= $row->download ?>" download>Download</a>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>

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