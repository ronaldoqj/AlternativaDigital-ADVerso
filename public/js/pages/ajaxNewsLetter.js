
$(document).ready(function()
{

    $('#bt_cadastrar_newsletter').click(function()
    {
        if ($('#name_newsletter').val() != '' && $('#email_newsletter').val() != '')
        {
            registerNewsLetter();
            return false;
        }
    });

});


function registerNewsLetter()
{
    var retorno;

    var ajax = $.ajax({
        url: '/ajax_registerNewsLetter',
        method: "GET",
        data: {
                name: $('#name_newsletter').val(),
                email: $('#email_newsletter').val()
              }
    });

    ajax.done(function (data)
    {
        $('#name_newsletter').val('');
        $('#email_newsletter').val('');
        $('#alert .title-alert').html('Inscrição realizada com sucesso');
        $('#alert .text-alert').html('Obrigado por realizar o cadastro no Portal ADVerso.');
        instanceAlert.open();
    });
    ajax.fail(function (jqXHR, textStatus) {
        alert('Não foi possível realizar a inscrição!');
    });

    return retorno;
}
