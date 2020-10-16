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

//ビジュアルエディタからいらないタグを削除（h1とか）
function custom_tinyMCEeditor_settings($initArray) {
    $initArray['block_formats'] = "中見出し(h3)=h3; 小見出し(h4)=h4; 段落=p;";
    return $initArray;
}
add_filter( 'tiny_mce_before_init', 'custom_tinyMCEeditor_settings' );

//ビジュアルエディタにボタンを追加
add_filter( 'mce_external_plugins', 'add_original_tinymce_button_plugin' );
function add_original_tinymce_button_plugin( $plugin_array ) {
  $plugin_array[ 'original_tinymce_button_plugin' ] = get_template_directory_uri() . '/admin/editor-button.js';
  return $plugin_array;
}

add_filter( 'mce_buttons_2', 'add_original_tinymce_button' );
function add_original_tinymce_button( $buttons ) {
  $buttons = array('lineLeft','lineRight','markerYellow','markerPink','insertSortcode');
  return $buttons;
}
add_editor_style( 'admin/editor-style.css' );

///////////////////////
//***  表示の制御 ***//
///////////////////////
//抜粋の制御
function twpp_change_excerpt_length( $length ) {
  return 50;
}
add_filter( 'excerpt_length', 'twpp_change_excerpt_length', 999 );
function twpp_change_excerpt_more( $more ) {
  return '<span class="text-grey-small">...続きをよむ</span>';
}
add_filter( 'excerpt_more', 'twpp_change_excerpt_more' );

//車の入力欄の挿入処理
function list_insert($atts) {
  $id = $atts[0];
  if(SCF::get('list_insert')){
    $lists = SCF::get('list_insert');
    $html = '';
    $number = 1;
    foreach ($lists as $list) {
      $html = $html . '<dl class="insertlist js-insertlist' . $number . '">';
      if($list['image']){
        $html = $html . '<dt class="insertlist__number"><span>' . $number . '</span></dt>';
        $html = $html . '<dd class="insertlist__caption">ここを押すと画像拡大できるよ！ ↓</dd>';
        $html = $html . '<dd class="insertlist__text">' . $list['text'] . '</dd>';
        $html = $html . '<dd class="js-insertlistThumbTop"></dd>';
        $html = $html . '<dd class="js-insertlistThumb insertlist__image"><div class="insertlist__imageBg"></div><img src="' . wp_get_attachment_url($list['image']) . '" alt=""></dd>';
      }else{
        $html = $html . '<dt class="insertlist__number"><span>' . $number . '</span></dt>';
        $html = $html . '<dd class="insertlist__textonly">' . $list['text'] . '</dd>';
      }
      $html = $html . '</dl>';
      $number ++;
    }
  }
  return $html;
}
add_shortcode('listInsert', 'list_insert');

///////////////////////
//***  処理の制御 ***//
///////////////////////
//titleタグの出力
add_theme_support( 'title-tag' );

/*ランダムに傾きのstyle属性を出力*/
function randomRotate(){
  $style = 'style="transform:rotateZ(' . rand(1, 10) . 'deg)"';
  echo $style;
}
//連想配列をシャッフル
function shuffleAssoc($list) {
    if (!is_array($list)) return $list;
    $keys = array_keys($list);
    shuffle($keys);
    $random = array();
    foreach ($keys as $key) {
        $random[$key] = $list[$key];
    }
    return $random;
}

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
  $post_tags_objects = get_the_tags($post_id);
  $post_tags = array();
  foreach($post_tags_objects as $post_tags_obj){
    array_push($post_tags,$post_tags_obj->term_id);
  }
  $title = str_replace('【', '', $title);
  $title = str_replace('】', '', $title);
  $title_split = array_slice(preg_split("//u", $title), 1, -1);
  $ids = get_posts(array(
    'numberposts' => -1,
    'post_type' => 'post',
    'post_status' => 'publish',
    'fields' => 'ids'
  ));
  $recommends = array();
  foreach ($ids as $id) {
    /*今の投稿と全投稿のうちのn個目の投稿のタイトルの文字数の一致の数を取る*/
    $other_title = get_the_title($id);
    $other_title_split = array_slice(preg_split("//u", $other_title), 1, -1);
    $equal_count_post = array_intersect($title_split,$other_title_split);
    /*今の投稿と全投稿のうちのn個目の投稿のカテゴリ数の一致の数を取る*/
    $other_tags_objects = get_the_tags($id);
    $other_tags = array();
    foreach($other_tags_objects as $other_tags_obj){
      array_push($other_tags,$other_tags_obj->term_id);
    }
    $equal_count_tag = array_intersect($post_tags,$other_tags);
    $recommends[$id] = count($equal_count_post) + ( count($equal_count_tag) * 10 );
    $recommends[$id] = count($equal_count_post);
  }
  arsort($recommends);
  $i = 0;
  //$recommends[投稿id] = 投稿タイトルの一致文字数 + (カテゴリidの一致数 * 2)
  //一致数スコア1位(0)はこの投稿自身なので除外。一致数2位(1)～4位(3)までをhtml要素にして返す
  foreach($recommends as $key => $value ){
    if($i === 1 && $value === 0){
      $html = '<p class="no-recommend">似た記事はありませんでした。</p>';
      break;
    }
    if($i > 0 && $value !== 0){
      $html = $html . '<a class="recommend" href="' . get_permalink($key) . '">';
      $html = $html . '<div class="recommend__thumb">';
      if(get_the_post_thumbnail($key)){
        $html = $html . '<img src="' . get_the_post_thumbnail_url($key, 'medium') . '" alt="">';
      }else{
        $html = $html . '<div class="recommend__thumb--dummy"><img src="' .  get_template_directory_uri() . '/assets/images/jimny-dummy.jpg" alt=""></div>';
      }
      $html = $html . '</div>';
      $html = $html . '<p class="recommend__title">' . get_the_title($key) . '</p>';
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
