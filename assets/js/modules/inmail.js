function view_file(id) {
    var file = $('#view-file-'+id).data('file');
    $.fancybox(file);
}