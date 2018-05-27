$(function () {
    var table = $('#table').DataTable({
        stateSave: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: $('#table').attr('data-url'),
            type: 'post',
            data: function (d) {
//                d.additional_data = datatable_data;
                return d;
            }
        },
        autoWidth: false,
        columnDefs: [
            {
                orderable: false,
                targets: 'no-sort'
            },
            {
                className: 'text-center',
                targets: 'text-center'
            },
            {
                className: 'text-right',
                targets: 'text-right'
            }
        ],
        order: [[$('th.default-sort').index(), $('th.default-sort').attr('data-sort')]],
        dom: '<"datatable-header"fBl><"datatable-scroll"t><"datatable-footer"ip>',
        buttons: [
            {
                text: 'Button 1',
                action: function (e, dt, node, config) {
                    alert('Button 1 clicked on');
                }
            }
        ],
        language: {
            processing: lang.table.processing,
            zeroRecords: lang.table.zero_records,
            info: lang.table.info,
            infoEmpty: lang.table.info_empty,
            infoFiltered: lang.table.info_filtered,
            search: '<span>' + lang.table.search + ':</span> _INPUT_',
            searchPlaceholder: lang.table.search_placeholder,
            lengthMenu: '<span>' + lang.table.length_menu + ':</span> _MENU_',
            paginate: {'first': lang.table.first, 'last': lang.table.last, 'next': '&rarr;', 'previous': '&larr;'}
        },
//        "columns": [null, {"className": "text-center"}, null]
//        drawCallback: function () {
//            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
//        },
//        preDrawCallback: function () {
//            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
//        }
    });
    table.on('click', '.delete', function (e) {
        var url = $(this).attr('href');
        e.preventDefault();
        swal({
            title: lang.message.confirm.delete,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#EF5350",
            confirmButtonText: lang.button.delete,
            cancelButtonText: lang.button.cancel,
            closeOnConfirm: false
        }, function () {
            $.ajax({
                url: url,
                success: function (data) {
                    data = JSON.parse(data);
                    table.ajax.reload();
                    swal(data.message, '', data.status);
                }
            });
        });
    });
    table.on('click', '.activated', function (e) {
        var url = $(this).attr('href');
        e.preventDefault();
        swal({
            title: lang.message.confirm.activated,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#EF5350",
            confirmButtonText: lang.button.yes,
            cancelButtonText: lang.button.cancel,
            closeOnConfirm: false
        }, function () {
            $.ajax({
                url: url,
                success: function (data) {
                    data = JSON.parse(data);
                    table.ajax.reload();
                    swal(data.message, '', data.status);
                }
            });
        });
    })
});
