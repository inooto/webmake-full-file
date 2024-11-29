/*-----飛び出てくる文字-----*/
function EachTextAnimeControl(){
    $('.eachTextAnime').each(function(){
        var elemPos = $(this).offset().top - 50;
        var scroll = $(window).scrollTop();
        var windowHeight = $(window).height();
        if(scroll >= elemPos - windowHeight){
            $(this).addClass("appeartext");
        }else{
            $(this).removeClass("appeartext");
        }
    });
}

$(window).on('load', function(){
    var element = $(".eachTextAnime");
    element.each(function(){
        var text = $(this).text();
        var textbox = "";
        text.split('').forEach(function(t,i){
            if (t !== ""){
                if (i < 10){
                    textbox += '<span style="animation-delay:.' + i + 's;">' + t + '</span>';
                }else{
                    var n = i/10;
                    textbox += '<span style="animation-delay:' + n + 's;">' + t + '</span>';
                }
            }else{
                textbox += t;
            }
        });
        $(this).html(textbox);
    });
    EachTextAnimeControl();
});
/*--改行１--*/
function EachTextAnimeControld1(){
    $('.eachTextAnimed1').each(function(){
        var elemPos = $(this).offset().top - 50;
        var scroll = $(window).scrollTop();
        var windowHeight = $(window).height();
        if(scroll >= elemPos - windowHeight){
            $(this).addClass("appeartext");
        }else{
            $(this).removeClass("appeartext");
        }
    });
}

$(window).on('load', function(){
    var element = $(".eachTextAnimed1");
    element.each(function(){
        var text = $(this).text();
        var textbox = "";
        text.split('').forEach(function(t,i){
            if (t !== ""){
                if (i < 10){
                    textbox += '<span style="animation-delay:' + 1 + '.' + i+4 + 's;">' + t + '</span>';
                }else{
                    var n = i/10;
                    textbox += '<span style="animation-delay:' + n + 's;">' + t + '</span>';
                }
            }else{
                textbox += t;
            }
        });
        $(this).html(textbox);
    });
    EachTextAnimeControld1();
});
/*--改行２--*/
function EachTextAnimeControld2(){
    $('.eachTextAnimed2').each(function(){
        var elemPos = $(this).offset().top - 50;
        var scroll = $(window).scrollTop();
        var windowHeight = $(window).height();
        if(scroll >= elemPos - windowHeight){
            $(this).addClass("appeartext");
        }else{
            $(this).removeClass("appeartext");
        }
    });
}

$(window).on('load', function(){
    var element = $(".eachTextAnimed2");
    element.each(function(){
        var text = $(this).text();
        var textbox = "";
        text.split('').forEach(function(t,i){
            if (t !== ""){
                if (i < 10){
                    textbox += '<span style="animation-delay:' + 2 + '.' + i + 's;">' + t + '</span>';
                }else{
                    var n = 2 + i/10;
                    textbox += '<span style="animation-delay:' + n + 's;">' + t + '</span>';
                }
            }else{
                textbox += t;
            }
        });
        $(this).html(textbox);
    });
    EachTextAnimeControld2();
});
/*--棒から文字--*/
function BgFadeAnime(){
    $('.bgLRextendTrigger').each(function(){
        var elemPos = $(this).offset().top-50;
        var scroll = $(window).scrollTop();
        var windowHeight = $(window).height();
        if(scroll >= elemPos - windowHeight){
            $(this).addClass('bgLRextend');
        }else{
            $(this).removeClass('bgLRextend');
        }
    });

    $('.bgappearTrigger').each(function(){
        var elemPos = $(this).offset().top-50;
        var scroll = $(window).scrollTop();
        var windowHeight = $(window).height();
        if(scroll >= elemPos - windowHeight){
            $(this).addClass('bgappear');
        }else{
            $(this).removeClass('bgappear');
        }
    });
}

$(window).scroll(function(){
    BgFadeAnime();
});
/*-----スライダー-----*/

$('.slider').slick({
    autoplay: true,
    infinite: true,
    speed: 500,
    slidesToShow: 3,
    slidesToScroll: 1,
    prevArrow: '<div class="slick-prev"></div>',
    nextArrow: '<div class="slick-next"></div>',
    centerMode: true,
    variableWidth: true,
    dots: true,
});

/*-----ギャラリー-----*/

$('.gallery').slick({
    infinite: true,
    fade: true,
    arrows: true,
    prevArrow: '<div class="slick-prev"></div>',
    nextArrow: '<div class="slick-next"></div>',
    centerMode: true,
    asNavFor: '.choice-btn',
});

$('.choice-btn').slick({
    infinite: true,
    slidesToShow: 5,
    focusOnSelect: true,
    prevArrow: '<div class="slick-prev"></div>',
    nextArrow: '<div class="slick-next"></div>',
    asNavFor: '.gallery',
});