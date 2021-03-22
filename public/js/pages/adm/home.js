//function atualizar() { location.reload(true) } window.setInterval("atualizar()",3000);

$(document).ready(function()
{

    $('#banners .edit').click(function() {
        var id = $(this).attr('rel');
        var listStringIds = $(this).attr('listStringIds');
        $('#form-edit input[name*="id"]').val(id);
        $('#form-edit input[name*="section"]').val('banner');
        $('#form-edit input[name*="listStringIds"]').val(listStringIds);
        $('#form-edit').submit();
    });

    $('#banners .delete').click(function()
    {
        if (confirm('Tem certeza que deseja deletar este registro'))
        {
            var id = $(this).attr('rel');
            $('#form-delete input[name*="id"]').val(id);
            $('#form-delete input[name*="section"]').val('banner');
            $('#form-delete').submit();
        }
    });

    $('#destaques .edit').click(function() {
        var id = $(this).attr('rel');
        var listStringIds = $(this).attr('listStringIds');
        $('#form-edit input[name*="id"]').val(id);
        $('#form-edit input[name*="section"]').val('destaque');
        $('#form-edit input[name*="listStringIds"]').val(listStringIds);
        $('#form-edit').submit();
    });

    $('#destaques .delete').click(function()
    {
        if (confirm('Tem certeza que deseja deletar este registro'))
        {
            var id = $(this).attr('rel');
            $('#form-delete input[name*="id"]').val(id);
            $('#form-delete input[name*="section"]').val('destaque');
            $('#form-delete').submit();
        }
    });


    $('#colunistas .edit').click(function() {
        var id = $(this).attr('rel');
        var listStringIds = $(this).attr('listStringIds');
        $('#form-edit input[name*="id"]').val(id);
        $('#form-edit input[name*="section"]').val('colunista');
        $('#form-edit input[name*="listStringIds"]').val(listStringIds);
        $('#form-edit').submit();
    });

    $('#colunistas .delete').click(function()
    {
        if (confirm('Tem certeza que deseja deletar este registro'))
        {
            var id = $(this).attr('rel');
            $('#form-delete input[name*="id"]').val(id);
            $('#form-delete input[name*="section"]').val('colunista');
            $('#form-delete').submit();
        }
    });


    $('#tvAdverso .edit').click(function() {
        var id = $(this).attr('rel');
        $('#form-edit input[name*="id"]').val(id);
        $('#form-edit input[name*="section"]').val('tvAdverso');
        $('#form-edit').submit();
    });

    $('#tvAdverso .delete').click(function()
    {
        if (confirm('Tem certeza que deseja deletar este registro'))
        {
            var id = $(this).attr('rel');
            $('#form-delete input[name*="id"]').val(id);
            $('#form-delete input[name*="section"]').val('tvAdverso');
            $('#form-delete').submit();
        }
    });

});
