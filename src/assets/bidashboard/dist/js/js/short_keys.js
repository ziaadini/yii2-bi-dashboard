$('body').dbKeypress(16, function (e) { // Shift
    $('#quickAccessModal').modal('show');
    setTimeout(function () {
        $('#shortCode').val('').focus();
    }, 500);
});

$('body').dbKeypress(18, function (e) { // Alt
    var $baseUrl = $('#shortCode').data('base-url');
    window.open($baseUrl + '/mongo-target/index');
});

$('body').dbKeypress(81, function (e) { // qq
    var $baseUrl = $('#shortCode').data('base-url');
    window.open($baseUrl + '/queue/index');
});

$('body').dbKeypress(83, function (e) { // ss
    var $baseUrl = $('#shortCode').data('base-url');
    window.open($baseUrl + '/system/index');
});

$('body').dbKeypress(73, function (e) { // ii
    var $baseUrl = $('#shortCode').data('base-url');
    window.open($baseUrl + '/developer/import-sql');
});

$('body').dbKeypress(67, function (e) { // cc
    var $baseUrl = $('#shortCode').data('base-url');
    window.open($baseUrl + '/mongo-log/index');
});

$('body').dbKeypress(17, function (e) { // Ctrl
    $('#search').focus();
});

$('body').dbKeypress(27, function (e) { // Ctrl
    $(".service-panel-toggle").trigger('mouseenter');
});
$(document).ready(function () {
    $('#shortCode').change(function () {
        var text = $('#shortCode').val();

        var $action = text.substring(0, 1);
        var $id = text.substring(1);
        var $baseUrl = $('#shortCode').data('base-url');
        if ($.isNumeric($action)) {
            window.open($baseUrl + '/orders/order/view?id=' + text);
        }
        if ($action == 'o') {
            if ($id) {
                window.open($baseUrl + '/orders/order/view?id=' + $id);
            } else {
                window.open($baseUrl + '/orders/order/index');
            }
        }
        if ($action == 'd') {
            if ($id) {
                window.open($baseUrl + '/orders/dispatch/view?id=' + $id);
            } else {
                window.open($baseUrl + '/orders/dispatch/index');
            }
        }
        if ($action == 'p') {
            if ($id) {
                window.open($baseUrl + '/content/product/view?id=' + $id);
            } else {
                window.open($baseUrl + '/content/product/index');
            }
        }
        if ($action == 'v') {
            window.open($baseUrl + '/content/product-variety/view?id=' + $id);
        }
        if ($action == 'i') {
            window.open($baseUrl + '/invoice/product-variety/view?id=' + $id);
        }
        if ($action == 'u') {
            if ($id) {
                window.open($baseUrl + '/user-details/view?id=' + $id, '_blank');
            } else {
                window.open($baseUrl + '/user/index', '_blank');
            }
        }
        if ($action == 'M') {
            $parts = $id.split('-');
            if ($parts[2]) {
                window.open($baseUrl + '/orders/dispatch/view?id=' + $parts[2], '_blank');
            } else {
                window.open($baseUrl + '/orders/dispatch/index', '_blank');
            }
        }

        $('#quickAccessModal').modal('hide');
    });
});