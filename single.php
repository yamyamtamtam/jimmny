<?php get_header(); ?>
<main class="content">
    <article class="single-content">
      <?php
        if(have_posts()):
          while (have_posts()):
            the_post();
      ?>
      <div class="numberplate-headline">
        <div class="numberplate-headline__date"><?php echo get_the_date( 'D曜', $post->ID ); ?>&nbsp;<?php echo get_the_date( 'Y.n.j', $post->ID ); ?></div>
        <div class="numberplate-headline__title">
          <span>あ</span>
          <h2><?php echo the_title(); ?></h2>
        </div>
      </div>
      <ul class="single-content__tag">
      <?php $tags = get_the_tags(); ?>
      <?php
        if(!empty($tags)):
          foreach($tags as $tag):
      ?>
        <li><a class="tag-link tag-<?php echo $tag->slug; ?>" href="<?php echo get_tag_link($tag->term_id); ?>"><?php echo $tag->name; ?></a></li>
      <?php
          endforeach;
        endif;
      ?>
      </ul>
      <section class="single-content__main">
        <?php the_content(); ?>
      </section>
      <section class="sns-area">
        <h5 class="headline-slash">この記事をSNSで紹介してね</h5>
        <div class="sns-wrap">
          <a class="sns" target="_blank" href="http://line.me/R/msg/text/?<?php echo the_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/line.png" alt=""></a>
          <a class="sns" target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo the_title(); ?>＠アカチェリーナ4世のジムニー女子ブログ&url=<?php echo the_permalink(); ?>" rel="nofollow"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/twitter.png" alt=""></a>
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
      <!--
      <section class="js-SpNextPrev sp-nextprev-wrap">
        <div class="sp-nextprev sp-nextprev--prev">
          <?php previous_post_link('%link','<span>&lt;</span><br>前へ'); ?>
        </div>
        <div class="sp-nextprev sp-nextprev--next">
          <?php next_post_link('%link','<span>&gt;</span><br>次へ'); ?>
        </div>
      </section>
    -->
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
