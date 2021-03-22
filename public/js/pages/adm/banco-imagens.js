//function atualizar() { location.reload(true) } window.setInterval("atualizar()",3000);

$(document).ready(function()
{

    $('.edit').click(function() {
        var file = JSON.parse( $(this).attr('rel') );

        $(".img-modal").attr("src", '/'+file.namefilefull);
        $('#modalEditGalery input[name*="id"]').val(file.id);
        $('#modalEditGalery input[name*="name"]').val(file.name);
        $('#modalEditGalery input[name*="description"]').val(file.description);
        $('#modalEditGalery input[name*="alternative_text"]').val(file.alternative_text);
        $('#modalEditGalery select[name*="category"] option').removeAttr('selected').filter('[value='+file.category_id+']').attr('selected', true)

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

});
