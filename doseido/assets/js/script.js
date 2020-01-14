jQuery(function($){
////////////////////
//****  共通  ****//
////////////////////
//TOPへ戻る
  var topBtn = $('.js-page-top');
  topBtn.hide();
  //スクロールが500に達したらボタン表示
  $(window).scroll(function () {
    if ($(this).scrollTop() > 300) {
      topBtn.fadeIn();
    } else {
      topBtn.fadeOut();
    }
  });
  //スルスルっとスクロールでトップへもどる
  topBtn.click(function () {
    $('body,html').animate({
      scrollTop: 0
    }, 500);
    return false;
  });
  $(".js-humbergerButton").click(function(){
    $(".humberger-nav").addClass("humberger-nav--active");
  });
  $(".js-humbergerClose").click(function(){
    $(".humberger-nav").removeClass("humberger-nav--active");
  });
  var prevScroll;
  var currentScroll;
  $(".js-SpNextPrev").addClass("sp-nextprev-wrap--active");
  $(window).scroll(function(){
    prevScroll = $(this).scrollTop();
    console.log(prevScroll);
    console.log(currentScroll);
    if(prevScroll < currentScroll){
      $(".js-SpNextPrev").addClass("sp-nextprev-wrap--active");
    }else{
      $(".js-SpNextPrev").removeClass("sp-nextprev-wrap--active");
    }
    currentScroll = prevScroll;
  });
})
