$(function () {
    $('.update-contact-click').click(function () {
        $('#update-contact')
            .modal('show')
            .find('#updateContactContent')
            .load($(this).attr('value'));
    });
});

