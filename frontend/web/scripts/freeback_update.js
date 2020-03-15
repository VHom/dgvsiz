$(function () {
//    alert('qq');
    $('.update-freeback-click').click(function () {
        $('#update-freeback')
            .modal('show')
            .find('#updateFreebackContent')
            .load($(this).attr('value'));
    });
});