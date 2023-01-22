$(function () {
    $.nette.init();
});



$(function() {
    setTimeout(function(){
        $('.alert').slideUp(500);
    }, 5000);
});


$.nette.ext("modals", {
    success: function(payload) {
        if (payload.redirect) {
            $(".modal-ajax").modal("hide");
        } else if(payload.isModal) {
            $('.modal-ajax').modal('show');
        }
    }
});