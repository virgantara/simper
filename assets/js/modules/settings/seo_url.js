$(function () {


});
function set_filter_category(e) {
    $('#filter-category').html($(e).text() + ' <span class="caret"></span>');
    var category = $(e).data('category');
    datatable_data.category = category;
    var table = $('#table').DataTable();

//    table.data(datatable_data).draw();
//    table.ajax.data = datatable_data;
    table.ajax.reload();
//    var id = $(e).data('id');
//    var value = $(e).val();
//    $.ajax({
//        type: 'POST',
//        url: current_url + "/update_sort_order",
//        data: {id: id, value: value},
//        success: function (data) {
//            if (data.status == 'error') {
//                error_message(data.message);
//            }
//        }
//    });
}