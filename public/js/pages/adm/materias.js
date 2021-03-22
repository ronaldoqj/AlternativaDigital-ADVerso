$(document).ready(function()
{
    var type = $('#formIni input[name*="type"]').val();
    $(".input-data").mask("00/00/0000");

    $('.edit').click(function() {
        return true;
        var file = JSON.parse( $(this).attr('rel') );
        var data = $(this).attr('relData');

        var image = '/images/default.png';
        if (file.fileBackground_namefilefull != null) {
             image = '/'+file.fileBackground_namefilefull;
        }
        else if (file.namefilefull != null) {
             image = '/'+file.namefilefull;
        }

        $(".img-modal").attr("src", image);

        $('#modalEdit select[name*="colunista"] option').removeAttr('selected').filter('[value='+file.colunista+']').attr('selected', true);
        $('#modalEdit select[name*="backgroundbanner"] option').removeAttr('selected').filter('[value='+file.backgroundbanner+']').attr('selected', true);

        if (file.ativo == 'S') { $('#modalEdit input[name*="ativo"]').attr("checked", true); }
        else { $('#modalEdit input[name*="ativo"]').attr("checked", false); }
        $('#modalEdit input[name*="id"]').val(file.id);
        $('#modalEdit input[name*="assunto"]').val(file.assunto);
        $('#modalEdit input[name*="data"]').val(data);
        $('#modalEdit input[name*="title"]').val(file.title);
        $('#modalEdit input[name*="subtitle"]').val(file.subtitle);
        $('#modalEdit textarea[name="extra_text"]').val(file.extra_text);
        CKEDITOR.instances['textEdit1'].setData(file.text1);
        $('#modalEdit select[name*="image"] option').removeAttr('selected').filter('[value='+file.image+']').attr('selected', true);
        $('#modalEdit select[name*="video"] option').removeAttr('selected').filter('[value='+file.video+']').attr('selected', true);
        $('#modalEdit select[name*="galeria"] option').removeAttr('selected').filter('[value='+file.galeria+']').attr('selected', true);
        CKEDITOR.instances['textEdit2'].setData(file.text2);
        $('#modalEdit textarea[name*="text2"]').text(file.text2);
        $('#modalEdit input[name*="facebook"]').val(file.facebook);
        $('#modalEdit input[name*="twitter"]').val(file.twitter);
        $('#modalEdit input[name*="whatsapp"]').val(file.whatsapp);
        $('#modalEdit').modal();
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
