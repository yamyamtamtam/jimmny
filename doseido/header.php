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
  <div class="header-deco">
    <div class="header-deco__center"></div>
  </div>
  <section class="header-top">
    <h1 class="header-logo"><a href="<?php echo esc_url(home_url( '/' )); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-swing.png" alt="<?php bloginfo('name'); ?>"></a></h1>
    <p class="header-description"><?php bloginfo('description'); ?></p>
  </section>
  <nav class="g-nav">
    <ul class="g-nav__inner">
      <li class="g-nav__item g-nav__item--dousei"><a href="<?php echo esc_url(home_url( '/' )); ?>?word=dousei"><div class="g-nav__icon g-nav__icon--dousei"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/dousei.png" alt=""></div><span>同棲</span></a></li>
      <li class="g-nav__item g-nav__item--dokuoya"><a href="<?php echo esc_url(home_url( '/' )); ?>category/毒親・毒兄弟/"><div class="g-nav__icon g-nav__icon--dokuoya"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/doku.png" alt=""></div><span class="pc">毒親・毒兄弟</span><span class="sp">毒家族</span></a></li>
      <li class="g-nav__item g-nav__item--shougai"><a href="<?php echo esc_url(home_url( '/' )); ?>category/自律神経失調症・不安症・発達障害/"><div class="g-nav__icon g-nav__icon--shougai"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/syougai.png" alt=""></div><span class="pc">自律神経失調症・<br>不安症・発達障害</span><span class="sp">メンタル</span></a></li>
      <li class="g-nav__item g-nav__item--jimny"><a href="<?php echo esc_url(home_url( '/' )); ?>category/ｊａ１１ジムニー/"><div class="g-nav__icon g-nav__icon--jimny"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/jimny.png" alt=""></div><span>ジムニー</span></a></li>
      <li class="g-nav__item g-nav__item--zatsugaku"><a href="<?php echo esc_url(home_url( '/' )); ?>category/誰かの役に立つかも？な雑学/"><div class="g-nav__icon g-nav__icon--zatsugaku"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/mame.png" alt=""></div><span>豆知識</span></a></li>
      <li class="g-nav__item g-nav__item--about"><a href="<?php echo esc_url(home_url( '/' )); ?>about"><div class="g-nav__icon g-nav__icon--about"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/aboutus.png" alt=""></div><span class="pc">このブログについて</span><span class="sp">ABOUT</span></a></li>
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
    <form class="searchform" method="get" action="<?php echo esc_url(home_url( '/' )); ?>">
      <input class="searchform__text" type="text" name="s" placeholder="キーワードを入力してね" />
      <button class="searchform__button" type="submit"></button>
    </form>
    <div class="humberger-nav__column">
      <div class="cat-nav-wrap">
        <h3 class="headline-white">カテゴリ一覧</h3>
        <ul class="cat-nav">
        <?php
          $categories = get_categories("type=post&parent=0&order=asc&hide_empty=0");
          foreach($categories as $category):
        ?>
          <li class="cat-nav__first"><a href="<?php echo esc_url(home_url( '/' )); ?>category/<?php echo $category->slug; ?>"><?php echo $category->name; ?></a>&nbsp;(<?php echo $category->count; ?>)</li>
        <?php
          $children = get_term_children($category->term_id,'category');
          if(count($children) > 0):
            foreach($children as $child):
              $current_child = get_category($child);
        ?>
          <li class="cat-nav__second"><a href="<?php echo esc_url(home_url( '/' )); ?>category/<?php echo $category->slug; ?>/<?php echo $current_child->slug; ?>"><?php echo $current_child->name; ?></a>&nbsp;(<?php echo $current_child->count; ?>)</li>
        <?php
            endforeach;
          endif;
        ?>
        <?php endforeach; ?>
        </ul>
      </div>
      <div class="archive-nav-wrap">
        <h3 class="headline-white">月別アーカイブ</h3>
        <ul class="archive-nav">
          <?php
            $archives_year = strip_tags(wp_get_archives('type=yearly&show_post_count=0&format=custom&echo=0'));
            $archives_year = str_replace(array("&nbsp;","\r\n","\n"), ',', $archives_year);
            $archives_year_array = explode(',',$archives_year);
            array_pop($archives_year_array);
            $archives_month = strip_tags(wp_get_archives('type=monthly&show_post_count=0&format=custom&echo=0'));
            $archives_month = str_replace(array("&nbsp;","\r\n","\n"), ',', $archives_month);
            $archives_month_array = explode(',',$archives_month);
            foreach($archives_year_array as $archives_year_current){
              echo '<li><a href="' . esc_url(home_url( '/' )) . $archives_year_current . '">' . $archives_year_current . '年</a></li>';
              foreach($archives_month_array as $archives_month_current){
                if(strpos($archives_month_current,$archives_year_current) !== false){
                  $archives_month_link = str_replace(array("年","月"), '/', $archives_month_current);
                  echo '<li><a href="' . esc_url(home_url( '/' )) . $archives_month_link . '">' . $archives_month_current . '</a></li>';
                }
              }
            }
          ?>
        </ul>
      </div>
    </div>
  </nav>
</header>
