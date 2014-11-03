$(function() {
    var xPos = 300;
    var yPos = 200;
    var step = 1;
    var delay = 30;
    var height = 0;
    var Hoffset = 0;
    var Woffset = 0;
    var yon = 0;
    var xon = 0;
    var pause = true;
    var interval;

    $("#img1").css("visibility", "visible");
    interval = setInterval(function() {
        width = $(window).width();
        height = $(window).height();
        Hoffset = $("#img1").height();
        Woffset = $("#img1").width();
        $("#img1").css("left", xPos + $(window).scrollLeft());
        $("#img1").css("top", yPos + $(window).scrollTop());


        if (yon)
        {
            yPos = yPos + step;
        }
        else
        {
            yPos = yPos - step;
        }
        if (yPos < 0)
        {
            yon = 1;
            yPos = 0;
        }
        if (yPos >= (height - Hoffset))
        {
            yon = 0;
            yPos = (height - Hoffset);
        }
        if (xon)
        {
            xPos = xPos + step;
        }
        else
        {
            xPos = xPos - step;
        }
        if (xPos < 0)
        {
            xon = 1;
            xPos = 0;
        }
        if (xPos >= (width - Woffset))
        {
            xon = 0;
            xPos = (width - Woffset);
        }


    }, delay);

    $("#img1").hover(function() {
        clearTimeout(interval);
    }, function() {
        interval = setInterval(function() {
            width = $(window).width();
            height = $(window).height();
            Hoffset = $("#img1").height();
            Woffset = $("#img1").width();

            $("#img1").css("left", xPos + $(window).scrollLeft());
            $("#img1").css("top", yPos + $(window).scrollTop());


            if (yon)
            {
                yPos = yPos + step;
            }
            else
            {
                yPos = yPos - step;
            }
            if (yPos < 0)
            {
                yon = 1;
                yPos = 0;
            }
            if (yPos >= (height - Hoffset))
            {
                yon = 0;
                yPos = (height - Hoffset);
            }
            if (xon)
            {
                xPos = xPos + step;
            }
            else
            {
                xPos = xPos - step;
            }
            if (xPos < 0)
            {
                xon = 1;
                xPos = 0;
            }
            if (xPos >= (width - Woffset))
            {
                xon = 0;
                xPos = (width - Woffset);
            }


        }, delay);
    });

});