//function atualizar() { location.reload(true) } window.setInterval("atualizar()",3000);

$(document).ready(function()
{

    $('.edit').click(function() {
        var register = JSON.parse( $(this).attr('rel') );
        // $(".img-modal").attr("src", 'http://i1.ytimg.com/vi/'+register.id_video+'/hqdefault.jpg');
        $(".iframe").html(register.link);

        $('#modalEdit input[name*="id"]').val(register.id);
        $('#modalEdit input[name*="title"]').val(register.title);
        $('#modalEdit textarea[name*="description"]').val(register.description);
        $('#modalEdit input[name*="idVideo"]').val(register.id_video);

        if (register.id_video != '')
        {
            videoString  = '<div class="video-container responsive-video">';
            videoString += '    <iframe width="100%" height="200" src="https://www.youtube.com/embed/'+register.id_video+'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
            videoString += '</div>';
            $('.adufrgs-no-ar-video-modal').html(videoString);
        }

        $('#modalEdit').modal();
    });

    $('.imagesList').click(function() {
      var id = $(this).attr('rel');
      $("#imageThumb").attr("src", 'http://i1.ytimg.com/vi/'+id+'/hqdefault.jpg');
      $('#modalImage').modal();
    });

    $('.order').click(function() {
        var id = $(this).attr('rel');
        $('#form-order input[name*="id"]').val(id);
        $('#form-order').submit();
    });

    $('.delete').click(function()
    {
        if (confirm('Tem certeza que deseja deletar este registro'))
        {
            var id = $(this).attr('rel');
            $('#form-delete input[name*="id"]').val(id);
            $('#form-delete').submit();
        }
    });

});
