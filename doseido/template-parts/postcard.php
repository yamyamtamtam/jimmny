    <article class="postcard js-postcard">
      <a href="<?php echo get_permalink($items[$i]); ?>">
        <div class="postcard__shade">
          <h2 class="postcard__title"><?php echo get_the_title($items[$i]); ?></h2>
          <p class="postcard__date"><?php echo get_the_date('Y年m月d日', $items[$i]); ?></p>
        </div>
        <div class="postcard__thumb <?php if(get_the_post_thumbnail($items[$i])): ?>postcard__thumb--exist<?php endif; ?>">
          <div class="postcard__curtain"></div>
          <div class="postcard__curtain postcard__curtain--reverse"></div>
          <?php if(get_the_post_thumbnail($items[$i])): ?>
          <img src="<?php echo get_the_post_thumbnail_url( $items[$i], 'medium' ); ?>" alt="">
          <?php else: ?>
            <?php
              $window_num = rand(2,5);
              $decoration_num = rand(1,6);
              switch ($window_num) {
                case 1:
                  $window_bg = 'normal';
                  break;
                case 2:
                  $window_bg = 'arabesque01';
                  break;
                case 3:
                  $window_bg = 'arabesque02';
                  break;
                case 4:
                  $window_bg = 'damask01';
                  break;
                case 5:
                  $window_bg = 'damask02';
                  break;
              }
              switch ($decoration_num) {
                case 1:
                  $decoration_obj = 'leaf';
                  break;
                case 2:
                  $decoration_obj = 'flower';
                  break;
                case 3:
                  $decoration_obj = 'bird01';
                  break;
                case 4:
                  $decoration_obj = 'bird02';
                  break;
                case 5:
                  $decoration_obj = 'bird03';
                  break;
                case 6:
                  $decoration_obj = 'teruteru';
                  break;
                }
            ?>
          <div class="postcard__thumb--dummy postcard__thumb--<?php echo $window_bg; ?> postcard__thumb--<?php echo idToCategoryConvert($items[$i]); ?>">
            <div class="postcard__decoration postcard__decoration--<?php echo $decoration_obj; ?>"></div>
          </div>
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
