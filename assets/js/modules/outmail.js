$(function () {
    
})
function upload(id) {
    $('#form-upload #id').val(id);
    $('#form-upload #file').val('');
    $('#modal-upload').modal('show');
}
function submit_upload() {
    $('#form-upload').ajaxSubmit({
        success: function (response) {
            response = JSON.parse(response);
            if (response.status == 'error') {
                error_message(response.message);
            } else {
                $('#modal-upload').modal('hide');
                success_message(response.message);
                $('#view-file-'+response.id).attr('data-file', response.file);
                $('#view-file-'+response.id).show();
            }
        }
    });
    return false;
}
function view_file(id) {
    var file = $('#view-file-'+id).data('file');
    $.fancybox(file);
}