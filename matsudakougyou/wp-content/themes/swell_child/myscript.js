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