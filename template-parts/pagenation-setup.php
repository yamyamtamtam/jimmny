  <?php
    $number_in_page = 6;
    $number_in_page_logic = $number_in_page - 1;
    $page_count = $number_in_page_logic;
    $count = 0;
    if($_GET['pagenation']){
      $page_count = $_GET['pagenation'] * $number_in_page - 1;
      $count = $page_count - $number_in_page_logic;
    }
  ?>
