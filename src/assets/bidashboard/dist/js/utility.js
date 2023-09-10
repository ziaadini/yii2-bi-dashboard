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
