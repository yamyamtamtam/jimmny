<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta name="description" content="<?php bloginfo('description'); ?>">
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
  <section class="header-top">
    <h1 class="header-logo"><a href="<?php echo esc_url(home_url( '/' )); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="<?php bloginfo('name'); ?>"></a></h1>
    <div class="header-grill"><div></div><div></div><div></div><div></div><div></div><div></div></div>
    <div class="header-light header-light--left"></div>
    <div class="header-light header-light--right"></div>
    <img class="header-aka" src="<?php echo get_template_directory_uri(); ?>/assets/images/image-aka.png" alt="">
  </section>
  <div class="header-deco">
    <div class="header-deco__light header-deco__light--left"></div>
    <div class="header-deco__light header-deco__light--right"></div>
  </div>
  <?php if(!is_single()): ?>
  <nav class="tag-area">
    <?php
      $tag_list = get_tags();
      $tag_list = shuffleAssoc($tag_list);
      foreach($tag_list as $tag):
    ?>
    <a class="tag-link tag-<?php echo $tag->slug; ?>" href="<?php echo get_tag_link($tag->term_id); ?>"><?php echo $tag->name; ?></a>
    <?php endforeach; ?>
  </nav>
<?php endif; ?>
  <div class="js-humbergerButton humberger-button">
    <p class="humberger-button__text">タグ一覧</p>
    <div class="humberger-button__open">▼</div>
  </div>
  <section class="humberger-nav">
    <div class="js-humbergerClose humberger-nav__close">×</div>
    <form class="searchform" method="get" action="<?php echo esc_url(home_url( '/' )); ?>">
      <input class="searchform__text" type="text" name="s" placeholder="キーワードを入力してね" />
      <button class="searchform__button" type="submit"></button>
    </form>
    <div class="humberger-nav__column">
      <div class="cat-nav-wrap">
        <h3 class="headline-white">タグ一覧</h3>
        <nav class="cat-nav">
          <?php
            $tag_list = get_tags();
            foreach($tag_list as $tag):
          ?>
          <a class="tag-link tag-<?php echo $tag->slug; ?>" href="<?php echo get_tag_link($tag->term_id); ?>"><?php echo $tag->name; ?></a>
          <?php endforeach; ?>
        </nav>
      </div>
    </div>
  </section>
</header>
