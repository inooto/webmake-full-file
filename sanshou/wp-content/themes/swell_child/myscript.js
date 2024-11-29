/*-----左固定-----*/
$(window).on('load resize', function(){
    var windowWidth = window.innerWidth;
    var elements = $('#lr_sc_fixed-area');
    if (windowWidth >= 768){
        Stickyfill.add(elements);
    }else{
        Stickyfill.remove(elements);
    }
});

/*-----記事スライダー-----*/
$('.slider').slick({
    autoplay: true,
    infinite: true,
    speed: 700,
    slidesToShow: 4,
    slidesToScroll: 1,
    prevArrow: '<div class="slick-prev"></div>',
    nextArrow: '<div class="slick-next"></div>',
    asNavFor: '.a-n-f',
});

$('.a-n-f').slick({
    infinite: true,
    slidesToShow: 1,
    arrows: false,
    fade: true,
});