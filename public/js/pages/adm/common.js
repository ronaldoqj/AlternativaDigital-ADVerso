$(document).ready(function()
{
    $('.has-img-linked').change(function() {
        var $objImg = JSON.parse($(this).find(':selected').attr('rel-img'));
        $objImg.class = '.' + $objImg.class;
        if ($objImg.path == '')
        {
            $objImg.path = '/images/default.png';
        }
        else
        {
            $objImg.path = '/' + $objImg.path;
        }


        $( $objImg.class ).fadeTo( "slow" , 0, function()
        {
            $($objImg.class).attr('src', $objImg.path);
            $( $objImg.class ).fadeTo( "slow" , 1);
        });
    });

    $('.has-video-linked').change(function() {
        var $objImg = JSON.parse($(this).find(':selected').attr('rel-video'));
        $objImg.class = '.' + $objImg.class;
        $objImg.path = $objImg.path;

        var videoString = '';
        if ($objImg.path != '')
        {
            videoString += '<div class="video-container responsive-video">';
            videoString += '    <iframe width="100%" height="200" src="https://www.youtube.com/embed/'+$objImg.path+'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
            videoString += '</div>';
        }
        else
        {
            videoString = '<img src="/images/player-video.png" class="img-ref-combobox tv-adverso-video" alt="Vídeo" />';
        }


        $( $objImg.class ).fadeTo( "slow" , 0, function()
        {
            $($objImg.class).html(videoString);
            $( $objImg.class ).fadeTo( "slow" , 1);
        });
    });

    $('.has-adufrgs-no-ar-linked').change(function() {
        var $objImg = JSON.parse($(this).attr('rel-video'));
        $objImg.class = '.' + $objImg.class;
        $objImg.path = $(this).val();

        var videoString = '';
        if ($objImg.path != '')
        {
            videoString += '<div class="video-container responsive-video">';
            videoString += '    <iframe width="100%" height="200" src="https://www.youtube.com/embed/'+$objImg.path+'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
            videoString += '</div>';
        }
        else
        {
            videoString = '<img src="/images/player-video.png" class="img-ref-combobox tv-adverso-video" alt="Vídeo" />';
        }


        $( $objImg.class ).fadeTo( "slow" , 0, function()
        {
            $($objImg.class).html(videoString);
            $( $objImg.class ).fadeTo( "slow" , 1);
        });
    });

});
