//function atualizar() { location.reload(true) } window.setInterval("atualizar()",3000);

$(document).ready(function()
{

    $('.edit-galery').click(function() {
        var id = $(this).attr('rel');
        $('#form-galery input[name*="id"]').val(id);
        $('#form-galery input[name*="action"]').val('order');

        $('#form-galery').submit();
    });

    $('.delete-galery').click(function() {
        var id = $(this).attr('rel');
        if (confirm('Tem certeza que deseja deletar esta galeria'))
        {
          $('#form-galery input[name*="id"]').val(id);
          $('#form-galery input[name*="action"]').val('delete');

          $('#form-galery').submit();
        }
    });

    $('.order-image').click(function() {
        var id = $(this).attr('rel');
        var idGaleria = $(this).attr('rel2');
          $('#form-images input[name*="id"]').val(id);
          $('#form-images input[name*="idGaleria"]').val(idGaleria);
          $('#form-images input[name*="action"]').val('order-image');

          $('#form-images').submit();
    });

    $('.edit-image').click(function() {
        var id = $(this).attr('rel');
        var name = $(this).parent().parent().find('.inputNomeImagem').val();
          $('#form-images input[name*="id"]').val(id);
          $('#form-images input[name*="idGaleria"]').val('');
          $('#form-images input[name*="action"]').val('edit-image');
          $('#form-images input[name*="name"]').val(name);

          $('#form-images').submit();
    });

    $('.delete-image').click(function() {
        var id = $(this).attr('rel');
        var idHasImagem = $(this).attr('rel2');
        if (confirm('Tem certeza que deseja deletar esta imagem'))
        {
            $('#form-images input[name*="id"]').val(id);
            $('#form-images input[name*="idGaleria"]').val('');
            $('#form-images input[name*="idhasImagem"]').val(idHasImagem);
            $('#form-images input[name*="action"]').val('delete-image');
            $('#form-images').submit();
        }
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
