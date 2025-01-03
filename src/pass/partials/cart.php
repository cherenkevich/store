<div class="cart <?= !empty($cart) && count($cart['items']) ? : 'cart--empty' ?>">
    <a class="cart__logo" href="/cart/">Cart<span><?= !empty($cart) && $cart['items'] ? count($cart['items']) : '' ?></span></a>
</div>