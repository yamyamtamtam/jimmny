jQuery(function($){
////////////////////
//****  共通  ****//
////////////////////
//TOPへ戻る
  var topBtn = $('.js-page-top');
  topBtn.hide();
  //スルスルっとスクロールでトップへもどる
  topBtn.click(function () {
    $('body,html').animate({
      scrollTop: 0
    }, 500);
    return false;
  });
  $(document).on("click", ".pagelink a",function(){
   var speed = 400;
   var href= $(this).attr("href");
   var target = $(href == "#" || href == "" ? 'html' : href);
   var position = target.offset().top - 40;
   $('body,html').animate({scrollTop:position}, speed, 'swing');
   return false;
  });
  ////////////////////////////////
  /*クリックでなにかする系の動作*/
  ///////////////////////////////
  $('.js-humbergerButton').click(function(){
    $('.humberger-nav').addClass('humberger-nav--active');
  });
  $('.js-humbergerClose').click(function(){
    $('.humberger-nav').removeClass('humberger-nav--active');
  });
  $('.js-archive-area').hide();
  $('.js-archive').click(function(){
    var id = $(this).attr('id');
    var selecter = '.js-archive-area--' + id;
    $(selecter).slideToggle();
    if($(this).hasClass('js-archive--active')){
      $(this).html('+').removeClass('js-archive--active');
    }else{
      $(this).html('-').addClass('js-archive--active');
    }
  });
  $('.js-pagelinkButton').click(function(){
    $('.js-pagelinkArea').addClass('pagelink--active');
  })
  $(document).on("click", ".js-pagelinkArea a",function(){
    $('.js-pagelinkArea').removeClass('pagelink--active');
  })
  $(document).on("click", ".js-pagelinkClose",function(){
    $('.js-pagelinkArea').removeClass('pagelink--active');
  })
  ////////////////////////////////
  /*スクロールでなにかする系の動作*/
  ///////////////////////////////
  var prevScroll;
  var currentScroll;
  var commonScrollPosition;
  var commonScrollPositionTop;
  var lineContent;
  var lineContentPosition;
  var postcardContent;
  var postcardContentPosition;
  var postcardItems = [];
  //読み込み時に記事リストを動かす
  apeearPostcard();
  //SP版の次へ前へボタン
  $(".js-SpNextPrev").addClass('sp-nextprev-wrap--active');
  //目次ボタン表示/非表示
  $(window).scroll(function(){
    //TOPへ戻るボタン
    if ($(this).scrollTop() > 300) {
      topBtn.fadeIn();
    } else {
      topBtn.fadeOut();
    }
    //SP版の次へ前へボタン
    prevScroll = $(this).scrollTop();
    if(prevScroll < currentScroll){
      $('.js-SpNextPrev').addClass('sp-nextprev-wrap--active');
    }else{
      $('.js-SpNextPrev').removeClass('sp-nextprev-wrap--active');
    }
    currentScroll = prevScroll;
    //LINE風
    commonScrollPosition = $(document).scrollTop() + window.innerHeight - 120;
    if($('.js-line')){
      lineContent = $('.js-line');
      for( var i=0; i<lineContent.length; i++) {
        lineContentPosition = lineContent[i].offsetTop;
        if(commonScrollPosition > lineContentPosition){
          lineContent[i].classList.add('line--active');
        }
      }
    }
    commonScrollPositionTop = $(document).scrollTop();
    //目次ボタン表示/非表示
    if($('.pagelink').length){
      var pagelinkPosition = $('.pagelink').offset().top + $('.pagelink').outerHeight();
      if(pagelinkPosition < commonScrollPositionTop){
        $('.js-pagelinkButton').addClass('pagelink-button--active');
      }else{
        $('.js-pagelinkButton').removeClass('pagelink-button--active');
      }
    }
    //記事リストを動かす
    apeearPostcard();
  });
  //記事リストを出す関数
  function apeearPostcard(){
    commonScrollPositionBottom = $(document).scrollTop() + window.innerHeight;
    if($('.js-postcard')){
      postcardContent = $('.js-postcard');
      postcardItems = [];
      for( var i=0; i<postcardContent.length; i++) {
        postcardContentPosition = postcardContent[i].offsetTop;
        if(commonScrollPositionBottom >= postcardContentPosition){
          if(!postcardContent[i].classList.contains('postcard--active')){
            postcardItems.push(i);
          }
        }
      }
      var n = 0;
      var start = setInterval(function(){
        if(typeof postcardItems[n] === "undefined"){
          clearInterval(start);
        }else{
          postcardContent[postcardItems[n]].classList.add('postcard--active');
          n++;
        }
      },400);
    }
  }
  ////////////////////////////////
  /////***テキスト操作系***///////
  ///////////////////////////////
  var h3elements = $('.single-content__main h3');
  var h4elements = $('.single-content__main h4');
  var h3offsetTop;
  var h3offsetTopNext;
  var h4offsetTop;
  var h3Id;
  var h4Id;
  /*h3,h4に目次用のidを付与する*/
  /*h3,h4のテキストを抜き出して目次用のDOMを作る*/
  var pagelinkDom = document.createElement('div');
  var pagelinkDomFixed = document.createElement('div');
  $(pagelinkDom).addClass('pagelink');
  $(pagelinkDomFixed).addClass('pagelink pagelink--fixed js-pagelinkArea');
  $('<p></p>').attr({class:'pagelink__headline'}).text('目次').appendTo(pagelinkDom);
  $('<p></p>').attr({class:'pagelink__headline'}).text('目次').appendTo(pagelinkDomFixed);
  if(h3elements){
    for( var i=0; i<h3elements.length; i++) {
      h3offsetTop = h3elements[i].offsetTop;
      //目次機能のためにh3にidをつけ、h3属性の目次を作る
      h3Id = 'h3-' + i;
      h3elements[i].setAttribute('id',h3Id);
      $('<a></a>').attr({class:'pagelink__first',href:'#' + h3Id}).text(h3elements[i].textContent).appendTo(pagelinkDom);
      $('<a></a>').attr({class:'pagelink__first',href:'#' + h3Id}).text(h3elements[i].textContent).appendTo(pagelinkDomFixed);
      for( var n=0; n<h4elements.length; n++) {
        h4offsetTop = h4elements[n].offsetTop;
        //h4属性の目次を作る
        if(h3elements[i+1]){
          h3offsetTopNext = h3elements[i+1].offsetTop
          if(h4offsetTop > h3offsetTop && h4offsetTop < h3offsetTopNext){
            h4Id = 'h4-' + n;
            h4elements[n].setAttribute('id',h4Id);
            $('<a></a>').attr({class:'pagelink__second',href:'#' + h4Id}).text(h4elements[n].textContent).appendTo(pagelinkDom);
            $('<a></a>').attr({class:'pagelink__second',href:'#' + h4Id}).text(h4elements[n].textContent).appendTo(pagelinkDomFixed);
          }
        }else{
          if(h4offsetTop > h3offsetTop){
            h4Id = 'h4-' + n;
            h4elements[n].setAttribute('id',h4Id);
            $('<a></a>').attr({class:'pagelink__second',href:'#' + h4Id}).text(h4elements[n].textContent).appendTo(pagelinkDom);
            $('<a></a>').attr({class:'pagelink__second',href:'#' + h4Id}).text(h4elements[n].textContent).appendTo(pagelinkDomFixed);
          }
        }
      }
    }
    if(h3elements.length > 1){
      $(h3elements[0]).before(pagelinkDom);
      $('<div></div>').addClass('pagelink__close js-pagelinkClose').text('×').appendTo(pagelinkDomFixed);
      $('.footer').before(pagelinkDomFixed);
    }
    //h4にh3のテキストを追記する
    for( var i=0; i<h3elements.length; i++) {
      h3offsetTop = h3elements[i].offsetTop;
      for( var n=0; n<h4elements.length; n++) {
        h4offsetTop = h4elements[n].offsetTop;
        //h4にh3のテキストを追記する
        if(h4offsetTop > h3offsetTop){
          $('.single-content__main h4:eq(' + n + ') .h3-clone-headline').remove();
          $('.single-content__main h4:eq(' + n + ')').prepend('<span class="h3-clone-headline">↓ ' + h3elements[i].textContent + '</span>');
        }
      }
    }
  }
})
