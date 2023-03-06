const imageUploadURL = '/image/upload';

let currentChatId = null;
$(document)
    .on('change', '.upload-image', function(e) {
        let fd = new FormData();
        fd.append('file', this.files[0]);
        $.ajax({
            url: imageUploadURL,
            method: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            success: function(data) {
                $('input.image-id').val(data.id);
            },
        });
    })
;

$(document).on('click', '.delete_product', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');
        const chatItem = $(this).closest('.market_item')
        $.ajax({
            url: url,
            method: 'DELETE',
            success: function(data) {
                chatItem.remove();
            }
        })
    ;
});

$(document).on('click', '.delete_user', function (e) {
    e.preventDefault();
    const url = $(this).attr('href');
    const userItem = $(this).closest('.user_item')
    $.ajax({
        url: url,
        method: 'DELETE',
        success: function(data) {
            userItem.remove();
        }
    })
;
});