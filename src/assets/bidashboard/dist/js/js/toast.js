// requires jQuery ... for now

function ToastBuilder(options) {
    // options are optional
    var opts = options || {};

    // setup some defaults
    opts.defaultText = opts.defaultText || 'default text';
    opts.displayTime = opts.displayTime || 3000;
    opts.target = opts.target || 'body';
    opts.css_class = opts.css_class || 'default';

    return function (text, css_clss, delay) {
        $('<div/>')
            .addClass('toast')
            .addClass(css_clss || opts.css_class)
            .prependTo($(opts.target))
            .text(text || opts.defaultText)
            .queue(function(next) {
                $(this).css({
                    'opacity': 1
                });
                var topOffset = 35;
                $('.toast').each(function() {
                    var $this = $(this);
                    var height = $this.outerHeight();
                    var offset = 15;
                    $this.css('top', topOffset + 'px');

                    topOffset += height + offset;
                });
                next();
            })
            .delay(delay || opts.displayTime)
            .queue(function(next) {
                var $this = $(this);
                var width = $this.outerWidth() + 20;
                $this.css({
                    'left': '-' + width + 'px',
                    'opacity': 0
                });
                next();
            })
            .delay(600)
            .queue(function(next) {
                $(this).remove();
                next();
            });
    };
}

// customize it with your own options
var myOptions = {
    defaultText: 'Toast, yo!',
    css_class: 'default',
    displayTime: 3000,
    target: 'body',
};

var showtoast = new ToastBuilder(myOptions);


