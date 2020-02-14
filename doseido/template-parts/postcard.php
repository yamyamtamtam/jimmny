    <article class="postcard js-postcard">
      <a href="<?php echo get_permalink($items[$i]); ?>">
        <div class="postcard__shade">
          <h2 class="postcard__title"><?php echo get_the_title($items[$i]); ?></h2>
          <p class="postcard__date"><?php echo get_the_date('Y年m月d日', $items[$i]); ?></p>
        </div>
        <div class="postcard__thumb">
          <div class="postcard__curtain"></div>
          <div class="postcard__curtain postcard__curtain--reverse"></div>
          <?php if(get_the_post_thumbnail($items[$i])): ?>
          <img src="<?php echo get_the_post_thumbnail_url( $items[$i], 'medium' ); ?>" alt="">
          <?php else: ?>
          <div class="postcard__thumb--dummy postcard__thumb--<?php echo idToCategoryConvert($items[$i]); ?>"></div>
          <?php endif; ?>
        </div>
        <p class="postcard__content">
          <?php
            if(has_excerpt()){
              echo get_the_excerpt($items[$i]);
            }else{
              echo mb_substr(strip_tags(get_post_field('post_content',$items[$i])), 0, 50 ) . '<span class="text-grey-small">...続きをよむ</span>';
            }
          ?>
        </p>
      </a>
      <ul class="postcard__cat">
      <?php
        $post_cats = get_the_category($items[$i]);
        foreach($post_cats as $post_cat):
      ?>
        <li><a class="cat-<?php echo categoryConvert($post_cat->name); ?>" href="<?php echo get_category_link($post_cat->term_id); ?>"><?php echo $post_cat->name; ?></a></li>
      <?php endforeach; ?>
      </ul>
    </article>
