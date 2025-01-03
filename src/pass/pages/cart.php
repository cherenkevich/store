<?php
if (empty($cart['items'])) {
    header('location: /');
}
$title = 'Cart';
?>
<!DOCTYPE html>
<html class="html html--cart" lang="en">

<head>
    <?php include 'partials/head.php' ?>
    <script src="https://js.stripe.com/v3/"></script>
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
                    Cart
                    <div class="pale"><?= count($cart['items']) ?> <?= count($cart['items']) == 1 ? 'item' : 'items' ?></div></h1>
            </div>
        </div>

        <div class="app__list">
            <div class="app__column">
                <div class="list list--cart">

                    <?php foreach ($cart['items'] as $key => $row): ?>

                        <div class="list__row list__row--item">
                            <div class="slot" data-price="<?= $row->price ?>" data-type="<?= $row->type ?>">
                                <div class="slot__left">
                                    <div class="slot__primary">
                                        <h3><a href="/products/<?= $row->type == "paper" ? $row->id : $row->parent ?>/"><?= $row->title ?></a></h3>
                                    </div>
                                    <div class="slot__secondary"><?= $row->type == "pdf" ? "PDF-version" : "Paper version" ?></div>
                                    <div class="slot__tertiary"><span>Removed.</span>
                                        <label data-restore="<?= $key ?>" for="<?= $key ?>">Put it back?</label>
                                    </div>
                                </div>
                                <div class="slot__right">
                                    <div class="slot__primary">
                                        <div class="price"><?= $row->price ?> €</div>
                                    </div>
                                </div>
                                <div class="slot__hanging">
                                    <div class="slot__remove">
                                        <label data-cart-remove="<?= $key ?>" for="<?= $key ?>">&times;</label>
                                        <input class="slot__status" type="checkbox" id="<?= $key ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>

                    <?php if ($cart['shipping']): ?>

                        <div class="list__row list__row--shipping">
                            <div class="slot" data-price="<?= $cart['shipping'] ?>">
                                <div class="slot__left">
                                    <div class="slot__primary">Shipping</div>
                                    <div class="slot__secondary">Europe only</div>
                                </div>
                                <div class="slot__right">
                                    <div class="slot__primary">
                                        <div class="price"><?= $cart['shipping'] ?> €</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endif; ?>

                    <div class="list__row list__row--total">
                        <div class="slot">
                            <div class="slot__left">
                                <div class="slot__primary">Total</div>
                            </div>
                            <div class="slot__right">
                                <div class="slot__primary">
                                    <div class="price"><?= $cart['total'] ?> €</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list__row list__row--footer">
                        <form action="/checkout/" method="POST">
                            <button class="rarr" type="submit" id="checkout-button">Checkout</button>
                        </form>
                    </div>
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