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