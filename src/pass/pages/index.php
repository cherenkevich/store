<?php
$title = 'Magazine';
?><!DOCTYPE html>
<html class="html html--index" lang="en">

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
                <h1 class="heading">Hi! I’m Aleksey&hairsp;—&hairsp;a&nbsp;<a href="https://cherenkevich.com" target="_blank">designer</a>, <a href="https://instagram.com/cherenkevich" target="_blank">photographer</a> and <a href="https://roundnsquare.club/che" target="_blank">vinyl collector</a> from Prague. I’m publish&shy;ing my own magazine. Below you can buy paper and&nbsp;digital copies</h1>
            </div>
        </div>

        <div class="app__feed">
            <div class="feed">

                <?php foreach ($data as $key => $row) : ?>
                    <?php if ($row->type == "paper") : ?>

                        <div class="feed__item">
                            <?php
                            $teaser = $row;
                            include 'partials/teaser.php';
                            ?>
                        </div>

                    <?php endif; ?>
                <?php endforeach; ?>

            </div>
        </div>

        <div class="app__text">
            <div class="app__column">
                <div class="text">
                    <p>Also I’m open to new projects in&nbsp;design of&nbsp;apps, websites and books. <a href="https://cherenkevich.com" target="_blank" class="rarr">Check out my portfolio</a></p>
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