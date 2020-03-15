function ajaxupdate(surl,nid,form_id)
{
    $.ajax({
        url: surl,
        type:'POST',
        data: {
            id: nid
        },
        success: function(data){
            $('#'+form_id).html(data);
        }
    })
}


