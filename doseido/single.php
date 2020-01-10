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
      <section class="nextprev-wrap">
        <div class="nextprev nextprev--prev">
          <?php previous_post_link('前の記事<br>%link'); ?>
        </div>
        <div class="nextprev nextprev--next">
          <?php next_post_link('次の記事<br>%link '); ?>
        </div>
      </section>
      <section class="sp-nextprev-wrap">
        <div class="sp-nextprev sp-nextprev--prev">
          <?php previous_post_link('%link','<'); ?>
        </div>
        <div class="sp-nextprev sp-nextprev--next">
          <?php next_post_link('%link','>'); ?>
        </div>
      </section>
      <?php comments_template(); ?>
    </article>
</main>
<?php
$title = get_the_title(get_the_ID());
$title_split = str_split($title);
$ids = get_posts(array(
  'numberposts' => -1,
  'post_type' => 'post',
  'post_status' => 'publish',
  'fields' => 'ids'
));
$recommends = array();
foreach ($ids as $id) {
  $other_title = get_the_title($id);
  $other_title_split = str_split($other_title);
  $equal_count = array_intersect($title_split,$other_title_split);
  $recommends[$other_title] = count($equal_count);
}
arsort($recommends);
var_dump($recommends);
?>
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
      //var jsonData = JSON.parse( response );
      alert(response);
    }
  });
})
</script>
<?php get_footer();
