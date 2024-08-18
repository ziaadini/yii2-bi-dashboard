function copyToClipboard(text) {
    var $temp = $("<textarea>");
    $("body").append($temp);
    $temp.html(text).select();
    document.execCommand("copy");
    $temp.remove();
    swal({
        position: 'top-end',
        timer: 2000,
        title: "<span class='text-success'>کپی شد</span>",
        type: "success",
        background: '#d4edda',
        showConfirmButton: false,
        toast: true,
    });
    return false;
}

function generateAccessKeyLink(accessKey) {
    const urlPrefix = location.hostname + '/bidashboard/report-page/view-by-access-key?access_key=';
    return urlPrefix + accessKey;
}

$(function () {
    "use strict";

    // ==============================================================
    //tooltip
    // ==============================================================
    $(function () {
        $('[data-toggle="tooltip"]').tooltip({container: 'body'})
    })

    $(document).on("pjax:send", function (xhr, options) {
        $('[data-toggle="tooltip"]').tooltip({container: 'body'});
        $(window).on('scroll', function () {
            $('[data-toggle="tooltip"]').tooltip('hide');
            $('.tooltip').remove();
        });
    });

    $(document).on("pjax:end", function (xhr, options) {
        $('[data-toggle="tooltip"]').tooltip({container: 'body'});
        $(window).on('scroll', function () {
            $('[data-toggle="tooltip"]').tooltip('hide');
            $('.tooltip').remove();
        });
    });
});