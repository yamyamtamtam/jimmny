<?php
///////////////////////
//******  共通 ******//
///////////////////////
//***  jQuery制御 ***//
function loadGoogleCdn() {
  if ( !is_admin() ){
    //jQueryを登録解除
    wp_deregister_script( 'jquery' );
    //Google CDNのjQueryを出力
    wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', array(), NULL, false );
  }
}
add_action( 'init', 'loadGoogleCdn' );


///////////////////////
//****  管理画面 ****//
///////////////////////
//サムネイル有効化
add_theme_support( 'post-thumbnails' );

function add_button_quicktag() {
	?>
	<script type="text/javascript">
	QTags.addButton('code_balloon', 'ふきだし', '[code_balloon position="left" name="名前" text="本文" img="アイコン画像URL"]');
	</script>
	<?php
}
add_action('admin_print_footer_scripts', 'add_button_quicktag');
function code_balloon_func($atts) {
	extract( shortcode_atts( array(
		'position' => '',
		'img' => '',
		'name' => '',
		'text' => '',
	), $atts ) );

	$code_balloon = <<<EOT
	<div class="balloon__contener">
    <div class="balloon__$position">
      <figure>
        <img src="$img" />
        <figcaption>$name</figcaption>
      </figure>
      <div class="balloon__text">
        $text
      </div>
    </div>
	</div>
EOT;
	return $code_balloon;

}

add_shortcode('code_balloon', 'code_balloon_func');

///////////////////////
//***  表示の制御 ***//
///////////////////////
//抜粋の制御
function twpp_change_excerpt_length( $length ) {
  return 150;
}
add_filter( 'excerpt_length', 'twpp_change_excerpt_length', 999 );
function twpp_change_excerpt_more( $more ) {
  return '...[続きをよむ]';
}
add_filter( 'excerpt_more', 'twpp_change_excerpt_more' );

///////////////////////
//***  処理の制御 ***//
///////////////////////
//titleタグの出力
add_theme_support( 'title-tag' );
//ajaxurlを出力
function add_my_ajaxurl(){
  echo '
  <script>
      var ajaxurl = "' . admin_url( 'admin-ajax.php') . '";
  </script>
  ';
}
add_action( 'wp_head', 'add_my_ajaxurl', 1 );
//レコメンドを呼び出すajaxを追加
//post_idをもらい、整形したhtmlを返す
function recommendCall(){
  $post_id = $_POST['id'];
  $html = '';
  $title = get_the_title($post_id);
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
    $recommends[$id] = count($equal_count);
  }
  arsort($recommends);
  $i = 0;
  //$recommends[投稿id] = 一致数
  //一致数スコア1位(0)はこの投稿自身なので除外。一致数2位(1)～4位(3)までをhtml要素にして返す
  foreach($recommends as $key => $value ){
    if($i === 0 && $value === 0){
      $html = '<p class="no-recommend">似た記事はありませんでした。</p>';
      break;
    }
    if($i > 0){
      $html = $html . '<a class="recommend" href="' . get_permalink($key) . '">';
      $html = $html . '<div class="recommend__thumb">';
      if(get_the_post_thumbnail($key)){
        $html = $html . '<img src="' . get_the_post_thumbnail_url($key, 'medium') . '" alt="">';
      }else{
        $html = $html . '<div class="recommend__thumb--dummy"></div>';
      }
      $html = $html . '</div>';
      $html = $html . '<h5 class="recommend__title">' . get_the_title($key) . '</h5>';
      $html = $html . '<div class="recommend__date">' . get_the_date('Y.m.d',$key) . '</div>';
      $html = $html . '</a>';
    }
    if($i >= 3){
      break;
    }
    $i++;
  }
  echo $html;
  die();
}
add_action( 'wp_ajax_recommendCall', 'recommendCall' );
add_action( 'wp_ajax_nopriv_recommendCall', 'recommendCall' );

?>
