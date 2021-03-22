$( document ).ready(function()
{
    //Inicializa os ToolTips
    $('[data-toggle="tooltip"]').tooltip()


    $(".edita").click(function ()
    {
        var input = $(this).parent().parent().find('.form-control');
        var id = $(input).attr('rel');
        var valor = input.val();

        $('input[name*="id"]').val(id);
        $('input[name*="nomeEdit"]').val(valor);
        $('input[name*="action"]').val('edit');

        $('#form-categorias').submit();
    });

    $(".deleta").click(function ()
    {
        var input = $(this).parent().parent().find('.form-control');
        var id = $(input).attr('rel');

        $('input[name*="id"]').val(id);
        $('input[name*="action"]').val('delete');

        $('#form-categorias').submit();
    });
});
