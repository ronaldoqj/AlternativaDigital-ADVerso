//function atualizar() { location.reload(true) } window.setInterval("atualizar()",3000);

$(document).ready(function()
{

    // $('.edit').click(function() {
    //     var file = JSON.parse( $(this).attr('rel') );
    //
    //     $(".img-modal").attr("src", '/'+file.namefilefull);
    //     $('#modalEdit input[name*="id"]').val(file.id);
    //     $('#modalEdit input[name*="name"]').val(file.name);
    //     $('#modalEdit input[name*="cargo"]').val(file.cargo);
    //     $('#modalEdit select[name*="category"] option').removeAttr('selected').filter('[value='+file.category_id+']').attr('selected', true)
    //     $('#modalEdit select[name*="avatar"] option').removeAttr('selected').filter('[value='+file.avatar+']').attr('selected', true)
    //
    //     $('#modalEdit').modal();
    // });

    $('.has-img-linked').change(function(){
        $path = $(this).find(':selected').attr('path-img');
        if ( $path == '' ) {
            $path = '/images/default.png';
        }
        $('.img-jornalista').attr('scr', $path);
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
