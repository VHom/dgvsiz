/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    $('.update-modal-click').click(function () {
        $('#update-modal')
            .modal('show')
            .find('#updateModalContent')
            .load($(this).attr('value'));
    });
});


