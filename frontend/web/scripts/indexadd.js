/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function myadd(id, act, modname)
{
    modform : modname+'_insert';
    var modalContainer = $(modname+'_insert');
//    var modalContainer = $('#specs_edit');
//    alert(act+'->'+modname+'->'+id);
    modalContainer.modal({show: true});
    $.ajax({
        url: act,
        type: "POST",
        data: {'id': id, 'act': 'modal'},
        success: function (data) {
            $('.modal-body').html(data);
            modalContainer.modal({show: true});

            $(modform).on("submit", function (event) {
//                event = document.getElementById('content');/////////////////////
                event.preventDefault();
//                this.disabled="disabled";//////////////////////////
                var data = $(this).serialize();
                data.id = id;
                $.ajax({
                    url: act,
                    type: "POST",
                    data: data.id,
                    success: function (data) {
                        $('.modal-body').html(data);
                    }
                });
            });
        }
    });
}
