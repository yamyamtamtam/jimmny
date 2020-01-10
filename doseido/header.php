<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<title>ブログ</title>
<meta name="description" content="同棲do!?">
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/common.css" rel="stylesheet" type="text/css" media="screen,tv,print" />
<link href="<?php echo get_template_directory_uri(); ?>/style.css" rel="stylesheet" type="text/css" media="screen,tv,print" />
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/script.js" type="text/javascript"></script>
</head>
<body <?php body_class(); ?>>
<header class="header">
  <h1 class="header-headline"><a href="<?php echo esc_url(home_url( '/' )); ?>">ブログ</a></h1>
  <nav class="g-nav">
    <ul class="g-nav__inner">
      <li><a href="<?php echo esc_url(home_url( '/' )); ?>?word=dousei">同棲</a></li>
      <li><a href="<?php echo esc_url(home_url( '/' )); ?>category/毒親・毒兄弟/">毒親・毒兄弟</a></li>
      <li><a href="<?php echo esc_url(home_url( '/' )); ?>category/自律神経失調症・不安症・発達障害/">自律神経失調症・<br>不安症・発達障害</a></li>
      <li><a href="<?php echo esc_url(home_url( '/' )); ?>?word=other">その他</a></li>
      <li><a href="<?php echo esc_url(home_url( '/' )); ?>about">このブログについて</a></li>
    </ul>
  </nav>
  <div class="js-humbergerButton humberger-button">
    <span class="humberger-button__line"></span>
    <span class="humberger-button__line"></span>
    <span class="humberger-button__line"></span>
    <p class="humberger-button__text">カテゴリ<br>月別一覧</p>
  </div>
  <nav class="humberger-nav">
    <div class="js-humbergerClose humberger-nav__close">×</div>
    <div class="cat-nav-wrap">
      <h3 class="headline-white">カテゴリ一覧</h3>
      <ul class="cat-nav">
      <?php
        $categories = get_categories("type=post&orderby=term_group&order=asc&hide_empty=0");
        foreach($categories as $category):
      ?>
        <?php
          $parent_exist = $category->parent;
          if($parent_exist === 0):
        ?>
        <li class="cat-nav__first"><a href="<?php echo esc_url(home_url( '/' )); ?>category/<?php echo $category->slug; ?>"><?php echo $category->name; ?></a>&nbsp;(<?php echo $category->count; ?>)</li>
        <?php
          else:
          $parent_cat = get_category($parent_exist);
        ?>
          <li class="cat-nav__second"><a href="<?php echo esc_url(home_url( '/' )); ?>category/<?php echo $parent_cat->slug; ?>/<?php echo $category->slug; ?>"><?php echo $category->name; ?></a>&nbsp;(<?php echo $category->count; ?>)</li>
        <?php endif; ?>
      <?php endforeach; ?>
      </ul>
    </div>
    <div class="archive-nav-wrap">
      <h3 class="headline-white">月別アーカイブ</h3>
      <ul class="archive-nav">
        <?php wp_get_archives("type=monthly&show_post_count=true"); ?>
      </ul>
    </div>
  </nav>
</header>
