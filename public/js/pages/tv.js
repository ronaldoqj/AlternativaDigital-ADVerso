var elem = document.querySelector('#modalVideos');
var options = {
  opacity: 0.9,
  onCloseEnd: closeModal
};
var register;
var instance = M.Modal.init(elem, options);

function closeModal(){
    $("#modalVideos .video-container").html('');
}

$(document).ready(function()
{
    $('.outra').click(function() {
        register = JSON.parse( $(this).attr('rel') );

        instance.open();
        $("#modalVideos .video-container").html(register.link);
    });

    $('#modalVideos').click(function(){
        instance.close();
    });
});
