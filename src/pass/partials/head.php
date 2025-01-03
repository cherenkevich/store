<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=no, viewport-fit=cover"/>
<meta http-equiv="x-ua-compatible" content="ie=edge"/>
<title><?= $title ? $title : "Magazine" ?></title>
<meta name="description" content="Hi! I’m Aleksey — a designer and photographer from Prague. I’m publishing my own magazine. Below you can buy paper and digital copies"/>
<meta property="og:url" content="https://magazine.cherenkevich.com<?= $_SERVER['REQUEST_URI'] ?>"/>
<meta property="og:title" content="<?= $title ? $title : "Magazine" ?>"/>
<meta property="og:description" content="Hi! I’m Aleksey — a designer and photographer from Prague. I’m publishing my own magazine. Below you can buy paper and digital copies"/>
<meta property="og:image" content="https://magazine.cherenkevich.com/assets/images/og.png"/>
<meta property="og:image:width" content="1200"/>
<meta property="og:image:height" content="630"/>
<meta property="og:site_name" content="Magazine"/>
<meta property="og:type" content="article"/>
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:site" content="@cherenkevich"/>
<meta name="twitter:creator" content="@cherenkevich"/>
<meta name="twitter:title" content="<?= $title ? $title : "Magazine" ?>"/>
<meta name="twitter:description" content="Hi! I’m Aleksey — a designer and photographer from Prague. I’m publishing my own magazine. Below you can buy paper and digital copies"/>
<meta name="twitter:image" content="https://magazine.cherenkevich.com/assets/images/og.png"/>
<meta name="twitter:url" content="https://magazine.cherenkevich.com<?= $_SERVER['REQUEST_URI'] ?>"/>
<meta name="apple-mobile-web-app-title" content="Magazine"/>
<link rel="icon" href="/assets/images/favicon.png?<?= filemtime('./assets/images/favicon.png') ?>" sizes="any"/>
<link rel="icon" href="/assets/images/favicon.svg?<?= filemtime('./assets/images/favicon.svg') ?>" type="image/svg+xml"/>
<link rel="apple-touch-icon" href="/assets/images/apple-touch-icon.png?<?= filemtime('./assets/images/apple-touch-icon.png') ?>"/>
<link href="/assets/styles/styles.css?<?= filemtime('./assets/styles/styles.css') ?>" rel="stylesheet" />
<link rel="manifest" href="/manifest.json"/>