//function atualizar() { location.reload(true) } window.setInterval("atualizar()",3000);

$(document).ready(function()
{
    $('.register-galery').click(function() {
        var selectImagens = $('#selectImagens').val();
        $('input[name="imagens"]').val(selectImagens);
    });

    $('.edit-revista').click(function() {
        var id = $(this).attr('rel');
        var selectImagens = $('#form-edit'+id+' #selectImagens').val();
        $('#form-edit'+id+' input[name="imagens"]').val(selectImagens);
    });

    $('.delete-revista').click(function() {
        var id = $(this).attr('rel');
        if (confirm('Tem certeza que deseja deletar esta galeria'))
        {
          $('#form-revista input[name*="id"]').val(id);
          $('#form-revista input[name*="action"]').val('delete');

          $('#form-revista').submit();
        }
    });
    $('.order-image').click(function() {
        var id = $(this).attr('rel');
        if (confirm('Tem certeza que deseja deletar esta imagem'))
        {
          $('#form-revista input[name*="id"]').val(id);
          $('#form-revista input[name*="action"]').val('order-image');

          $('#form-revista').submit();
        }
    });
    $('.delete-image').click(function() {
        var id = $(this).attr('rel');
        if (confirm('Tem certeza que deseja deletar esta imagem'))
        {
          $('#form-revista input[name*="id"]').val(id);
          $('#form-revista input[name*="action"]').val('delete-image');

          $('#form-revista').submit();
        }
    });

    $('.ordenar-revistas').click(function() {
          var id = $(this).attr('rel');

          $('#form-revista input[name*="id"]').val(id);
          // $('#form-images input[name*="idOrder"]').val(idGaleria);
          $('#form-revista input[name*="action"]').val('order');

          $('#form-revista').submit();
    });

    $('.edit-image').click(function() {
        var id = $(this).attr('rel');
        var link = $(this).parent().parent().find('.inputNomeImagem').val();

        $('#form-revista input[name*="id"]').val(id);
        $('#form-revista input[name*="action"]').val('edit-image');
        $('#form-revista input[name="link"]').val(link);

        $('#form-revista').submit();
    });

    $('.edit').click(function() {
        var ObjGaleria = JSON.parse( $(this).attr('rel') );
        $('#modalEditGalery input[name*="id"]').val(ObjGaleria.id);
        $('#modalEditGalery input[name*="name"]').val(ObjGaleria.title);
        $('#modalEditGalery textarea[name*="description"]').val(ObjGaleria.description);
        //$(".img-modal").attr("src", '/'+ObjGaleria.nameObjGaleriafull);
        //$('#modalEditGalery select[name*="category"] option').removeAttr('selected').filter('[value='+ObjGaleria.category_id+']').attr('selected', true)

        $('#modalEditGalery').modal();
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

    /* Alimenta o input hidden com o valor escolhido no combobox images */
    $("select[name*='images']").on("change", function() {
          var images = $(this).val();
          $(this).parent().parent().parent().find('input[name*="selectImages"]').val(images);
    });


});
