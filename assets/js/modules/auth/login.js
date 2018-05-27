$(function () {
    $('#login').submit(function () {
        $('#login').ajaxSubmit({
            success: function (data) {
                data = JSON.parse(data);
                if (data.status == 'success') {
                    window.setTimeout(function () {
                        window.location = data.redirect;
                    }, 1000);
                } else {
                    swal({
                        title: "Oops...",
                        text: data.message,
                        confirmButtonColor: "#EF5350",
                        type: "error",
                        html: true
                    });
                }
            }
        });
        return false;
    });
});