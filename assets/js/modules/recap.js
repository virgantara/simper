$(function () {
    var table = $('#table-recap').DataTable({
        stateSave: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: $('#table-recap').attr('data-url'),
            type: 'post',
            data: function (d) {
                d.haha = 'oke';
                d.date_start = $('#date-start').val();
                d.date_end = $('#date-end').val();
                console.log(d);
                console.log($('#date-start').val());
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
        dom: '<"datatable-scroll"t><"datatable-footer"ilp>',
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
    });
    $('#filter').on('click', function () {
        table.ajax.reload();
    });
    $('#print').on('click', function () {
        var type = $(this).data('type');
        var win = window.open(site_url + 'recap/'+type+'mail/prints?start=' + $('#date-start').val() + '&end=' + $('#date-end').val(), '_blank');
        if (win) {
            win.focus();
        } else {
            alert('Please allow popups for this website');
        }

    })
});
