<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title><?php bloginfo('name'); ?></title>
  <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
</head>
<body>

<?php get_template_part('header/header'); ?>

<main>
  <h1>トップページの内容</h1>
  <p>ここにメインコンテンツを書く</p>
</main>

<?php get_template_part('footer/footer'); ?>

</body>
</html>
