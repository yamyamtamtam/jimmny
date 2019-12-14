<?php get_header(); ?>
<main class="content">
    <article class="single-content">
      <h2 class="single-content__headline"><?php echo the_title(); ?></h2>
      <p class="single-content__date"><?php echo get_the_date( 'Y年n月j日D曜日', $post->ID ); ?></p>
      <ul class="single-content__cat">
      <?php $cats = get_the_category( $post->ID ); ?>
      <?php foreach($cats as $cat): ?>
        <li><a href="<?php echo esc_url(home_url( '/' )); ?>category/<?php echo $cat->name; ?>/"><?php echo $cat->name; ?></a></li>
      <?php endforeach; ?>
      </ul>
      <section class="single-content__main">
        <?php
          if(have_posts()){
            while (have_posts()){
              the_post();
              the_content();
            }
          } else {
          	echo '<p>コンテンツがありません。</p>';
          }
        ?>
      </section>
      <section class="single-content__nextprev">
        <?php previous_post_link(); ?>
        <?php next_post_link(); ?>
      </section>
      <?php comments_template(); ?>
    </article>
</main>
<?php get_footer();
