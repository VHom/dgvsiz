function myedit(id,  act, modname)
{
    modform : modname;
    var modalContainer = $(modname);
    modalContainer.modal({show: true});
    $.ajax({
        url: act,
        type: "POST",
        data: {'id': id, 'act': 'modal'},
        success: function (data) {
            $('.modal-body').html(data);
            modalContainer.modal({show: true});

            $(modform).on("submit", function (event) {
                event.preventDefault();                
                var data = $(this).serialize();
                data.id = id;
                $.ajax({
                    url: act,
                    type: "POST",
                    data: data,
                    success: function (data) {
                        $('.modal-body').html(data);
                    }
                });
            });
        }
    });
}