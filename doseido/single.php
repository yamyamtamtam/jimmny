<?php get_header(); ?>
<main class="content">
    <article class="single-content">
      <?php
        if(have_posts()):
          while (have_posts()):
            the_post();
      ?>
      <h2 class="single-content__headline"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/headline-ribbon.png" alt=""><?php echo the_title(); ?></h2>
      <p class="single-content__date"><?php echo get_the_date( 'Y年n月j日D曜日', $post->ID ); ?></p>
      <ul class="single-content__cat">
      <?php $cats = get_the_category( $post->ID ); ?>
      <?php foreach($cats as $cat): ?>
        <li><a class="cat-<?php echo categoryConvert($cat->name); ?>" href="<?php echo esc_url(home_url( '/' )); ?>category/<?php echo $cat->name; ?>/"><?php echo $cat->name; ?></a></li>
      <?php endforeach; ?>
      </ul>
      <section class="single-content__main">
        <?php the_content(); ?>
      </section>
      <section class="sns-area">
        <h5 class="headline-slash">この記事をSNSで紹介してね</h5>
        <div class="sns-wrap">
          <a class="sns" target="_blank" href="http://line.me/R/msg/text/?<?php echo the_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/line.png" alt=""></a>
          <a class="sns" target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo the_title(); ?>@同棲do!?&url=<?php echo the_permalink(); ?>" rel="nofollow"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/twitter.png" alt=""></a>
          <a class="sns" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo the_permalink(); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/facebook.png" alt=""></a>
          <a class="sns" target="_blank" href="http://b.hatena.ne.jp/entry/<?php echo the_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/hatena.png" alt=""></a>
        </div>
      </section>
      <section class="nextprev-wrap">
        <div class="nextprev nextprev--prev">
          <?php previous_post_link('前の記事<br>%link'); ?>
        </div>
        <div class="nextprev nextprev--next">
          <?php next_post_link('次の記事<br>%link '); ?>
        </div>
      </section>
      <section class="js-SpNextPrev sp-nextprev-wrap">
        <div class="sp-nextprev sp-nextprev--prev">
          <?php previous_post_link('%link','<span>&lt;</span><br>前へ'); ?>
        </div>
        <div class="sp-nextprev sp-nextprev--next">
          <?php next_post_link('%link','<span>&gt;</span><br>次へ'); ?>
        </div>
      </section>
      <section class="recommend-area">
        <h5 class="headline-pinkbar">この記事に似た記事をみる</h5>
        <div class="js-recommend recommend-wrap loader">
        </div>
      </section>
      <?php comments_template(); ?>
      <?php
          endwhile;
        endif;
      ?>
    </article>
</main>
<div class="js-pagelinkButton pagelink-button">
  <span class="pagelink-button__line"></span>
  <span class="pagelink-button__line"></span>
  <span class="pagelink-button__line"></span>
  <p class="pagelink-button__text">目次</p>
</div>
<script>
jQuery(function($){
  $.ajax({
    type: 'POST',
    url: ajaxurl,
    data: {
      'action':'recommendCall',
      'id':<?php echo get_the_ID(); ?>
    },
    success: function( response ){
      $('.js-recommend').removeClass('loader');
      $('.js-recommend').append(response);
    }
  });
})
</script>
<?php get_footer();
