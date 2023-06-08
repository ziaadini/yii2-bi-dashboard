// ('#modalButton').click( function () {
//     window.alert('message');
// });
$(function () {
    // Pjax Modal

    var modalPjax = $('#modal-pjax');
    modalPjax.on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        modalPjax.find('.modal-dialog').addClass(button.data('size'));
        modalPjax.find('#modalPjaxHeader').html('<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4>' + button.data('title') + '</h4>');
    });

    modalPjax.on('shown.bs.modal', function (e) {
        var button = $(e.relatedTarget),
            redirect = button.data('redirect'),
            hideModal = button.data('hide-modal'),
            reloadPjaxContainer = button.data('reload-pjax-container'),
            reloadPjaxContainerModal = button.data('reload-pjax-container-modal'),
            reloadPjaxContainerOnShow = button.data('reload-pjax-container-on-show'),
            handleFormSubmit = button.data('handle-form-submit'),
            resetForm = button.data('resetForm'),
            url = button.data('reload-url'),
            pjaxSettings = {
                timeout: false,
                scrollTo: false,
                push: false,
                skipOuterContainers: true,
                url: button.data('url'),
                container: '#modalPjaxContent'
            };

        handleFormSubmit = handleFormSubmit !== undefined ? handleFormSubmit : true;
        $('#modalPjaxContent').off('pjax:error');
        $('#modalPjaxContent').on('pjax:error', function (event, xhr, textStatus, error, options) {
            modalPjax.modal('hide');
            swal({
                position: 'top-end',
                timer: 2000,
                title: "<span class='text-danger'>" + xhr.responseText + "</span>",
                type: "error",
                background: '#f8d7da',
                showConfirmButton: false,
                toast: true,
            });
            return false;
        });
        $('#modalPjaxContent').off('pjax:complete');
        $('#modalPjaxContent').on('pjax:complete', function (event, xhr, textStatus, options) {

            // ==============================================================
            //tooltip
            // ==============================================================
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
            // ==============================================================
            //Popover
            // ==============================================================
            $(function () {
                $('[data-toggle="popover"]').popover()
            })

            reloadPjaxContainerOnShow = reloadPjaxContainerOnShow !== undefined ? reloadPjaxContainerOnShow : false;
            if (reloadPjaxContainerOnShow && reloadPjaxContainer !== undefined) {
                $.pjax.reload('#' + reloadPjaxContainer, {
                    timeout: false,
                    scrollTo: false,
                    push: false,
                    skipOuterContainers: true,
                });
            }
            modalPjax.off('submit', 'form');
            modalPjax.on('submit', 'form', function (e) {
                if (!handleFormSubmit) {
                    return true;
                }
                var $form = $(this);
                var submitBtn = $form.find(':submit');
                var submitBtnOldHtml = submitBtn.html();
                var fd = new FormData(document.getElementById($form.attr('id')));
                submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>').attr('disabled', true);
                $.ajax({
                    url: $form.attr('action'),
                    data: fd,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function (data) {
                        if (data.success === true) {
                            swal({
                                position: 'top-end',
                                timer: 2000,
                                title: "<span class='text-success'>" + data.msg + "</span>",
                                type: "success",
                                background: '#d4edda',
                                showConfirmButton: false,
                                toast: true,
                            });
                            if (reloadPjaxContainer !== undefined) {
                                $.pjax.reload('#' + reloadPjaxContainer, {
                                    timeout: false,
                                    scrollTo: false,
                                    push: false,
                                    skipOuterContainers: true,
                                    url: url
                                });
                            }

                            if (hideModal == undefined || data.hideModal) {
                                modalPjax.modal('hide');
                            }
                            if (reloadPjaxContainerModal !== undefined) {
                                $('#' + reloadPjaxContainerModal).html(data.html);
                            }
                            if (redirect !== undefined || data.redirect) {
                                window.location.replace(data.url);
                            }

                            if (data.redirect_pop_up) {
                                window.open(data.url, 'popupWindow');
                            }

                            if (resetForm !== undefined || data.resetForm) {
                                $form[0].reset();
                            }

                        } else if (data.success === false) {
                            swal({
                                position: 'top-end',
                                timer: 2000,
                                title: "<span class='text-danger'>" + data.msg + "</span>",
                                type: "error",
                                background: '#f8d7da',
                                showConfirmButton: false,
                                toast: true,
                            });
                            //modalPjax.modal('hide');
                        }
                        // errors handling
                        else {
                            if (data.errors) {
                                $.each(data.errors, function (id, messages) {
                                    var input = $form.find('#' + id);
                                    input.removeClass('has-success').addClass('has-error');
                                    input.parent().find('.invalid-feedback').html(messages.join('<br>')).show();
                                });
                            } else {
                                $form.yiiActiveForm('updateMessages', data, true);
                                $.each(data, function (id, messages) {
                                    var msgs = messages[0];
                                    var input = $form.find('#' + id);
                                    input.removeClass('has-success').addClass('has-error');
                                    input.parent().parent().parent().find('.invalid-feedback').html(msgs).show();
                                });
                            }
                        }
                    }
                }).fail(function (xhr, status, error) {
                    submitBtn.attr('disabled', false).text(submitBtnOldHtml);
                    swal({
                        position: 'top-end',
                        timer: 2000,
                        title: "<span class='text-danger'>" + xhr.responseText + "</span>",
                        type: "error",
                        background: '#f8d7da',
                        showConfirmButton: false,
                        toast: true,
                    });
                }).then(function (result) {
                    submitBtn.attr('disabled', false).text(submitBtnOldHtml);
                });
                return false;
            })
        });

        $.pjax(pjaxSettings);
    });

    modalPjax.on('hidden.bs.modal', function (e) {
        $(this).find('#modalPjaxContent').html('<div class="d-flex justify-content-center align-items-center" style="min-height:150px;"> <div class="spinner-grow text-mobit p-3" role="status"> <span class="sr-only">Loading ...</span> </div> </div>');
    });

    // Pjax Over Modal

    var modalPjaxOver = $('#modal-pjax-over');
    modalPjaxOver.on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        modalPjaxOver.find('.modal-dialog').addClass(button.data('size'));
        modalPjaxOver.find('#modalPjaxOverHeader').html('<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4>' + button.data('title') + '</h4>');
    });

    modalPjaxOver.on('shown.bs.modal', function (e) {
        var button = $(e.relatedTarget),
            redirect = button.data('redirect'),
            hideModal = button.data('hide-modal'),
            reloadPjaxContainer = button.data('reload-pjax-container'),
            reloadPjaxUrl = button.data('reload-pjax-url'),
            reloadUnderPjaxContainer = button.data('reload-under-pjax-container'),
            reloadPjaxContainerOnShow = button.data('reload-pjax-container-on-show'),
            handleFormSubmit = button.data('handle-form-submit'),
            pjaxSettings = {
                timeout: false,
                scrollTo: false,
                push: false,
                skipOuterContainers: true,
                url: button.data('url'),
                container: '#modalPjaxOverContent'
            };

        handleFormSubmit = handleFormSubmit !== undefined ? handleFormSubmit : true;
        $('#modalPjaxOverContent').off('pjax:error');
        $('#modalPjaxOverContent').on('pjax:error', function (event, xhr, textStatus, error, options) {
            modalPjaxOver.modal('hide');
            swal({
                position: 'top-end',
                timer: 2000,
                title: "<span class='text-danger'>" + xhr.responseText + "</span>",
                type: "error",
                background: '#f8d7da',
                showConfirmButton: false,
                toast: true,
            });
            return false;
        });
        $('#modalPjaxOverContent').off('pjax:complete');
        $('#modalPjaxOverContent').on('pjax:complete', function (event, xhr, textStatus, options) {
            // ==============================================================
            //tooltip
            // ==============================================================
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
            // ==============================================================
            //Popover
            // ==============================================================
            $(function () {
                $('[data-toggle="popover"]').popover()
            })

            reloadPjaxContainerOnShow = reloadPjaxContainerOnShow !== undefined ? reloadPjaxContainerOnShow : false;
            if (reloadPjaxContainerOnShow && reloadPjaxContainer !== undefined) {
                $.pjax.reload('#' + reloadPjaxContainer, {
                    timeout: false,
                    scrollTo: false,
                    push: false,
                    skipOuterContainers: true,
                });
            }
            modalPjaxOver.off('submit', 'form');
            modalPjaxOver.on('submit', 'form', function (e) {
                var $form = $(this);
                if (!handleFormSubmit || $form.attr('class') === 'search') {
                    return true;
                }
                var submitBtn = $form.find(':submit');
                var submitBtnOldHtml = submitBtn.html();
                var fd = new FormData(document.getElementById($form.attr('id')));
                submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>').attr('disabled', true);

                $.ajax({
                    url: $form.attr('action'),
                    data: fd,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function (data) {
                        if (data.success === true) {
                            swal({
                                position: 'top-end',
                                timer: 2000,
                                title: "<span class='text-success'>" + data.msg + "</span>",
                                type: "success",
                                background: '#d4edda',
                                showConfirmButton: false,
                                toast: true,
                            });

                            if (reloadPjaxContainer !== undefined) {
                                $.pjax.reload('#' + reloadPjaxContainer, {
                                    timeout: false,
                                    scrollTo: false,
                                    push: false,
                                    replace: false,
                                    skipOuterContainers: true,
                                    url: reloadPjaxUrl,
                                });
                            }

                            if (hideModal == undefined || data.hideModal) {
                                modalPjaxOver.modal('hide');
                            }

                            if (data.redirect_pop_up) {
                                window.open(data.url, 'popupWindow');
                            }

                            if (redirect !== undefined || data.redirect) {
                                window.location.replace(data.url);
                            }
                        } else if (data.success === false) {
                            swal({
                                position: 'top-end',
                                timer: 2000,
                                title: "<span class='text-danger'>" + data.msg + "</span>",
                                type: "error",
                                background: '#f8d7da',
                                showConfirmButton: false,
                                toast: true,
                            });
                            //modalPjaxOver.modal('hide');
                        }
                        // errors handling
                        else {
                            $form.yiiActiveForm('updateMessages', data, true);
                        }
                    }
                }).fail(function (xhr, status, error) {
                    submitBtn.attr('disabled', false).text(submitBtnOldHtml);
                    swal({
                        position: 'top-end',
                        timer: 2000,
                        title: "<span class='text-danger'>" + xhr.responseText + "</span>",
                        type: "error",
                        background: '#f8d7da',
                        showConfirmButton: false,
                        toast: true,
                    });
                }).then(function (result) {
                    submitBtn.attr('disabled', false).text(submitBtnOldHtml);
                });
                return false;
            })
        });

        if (reloadUnderPjaxContainer !== undefined) {
            $('#' + reloadPjaxContainer).on('pjax:complete', function (event, xhr, textStatus, options) {
                $.pjax.reload('#' + reloadUnderPjaxContainer, {
                    timeout: false,
                    scrollTo: false,
                    push: false,
                    skipOuterContainers: true
                });
            });
            $("#modal-pjax").css({overflow: "auto"});
        }
        $.pjax(pjaxSettings);
    });

    modalPjaxOver.on('hidden.bs.modal', function (e) {
        $(this).find('#modalPjaxOverContent').html('<div class="d-flex justify-content-center align-items-center" style="min-height:150px;"> <div class="spinner-grow text-mobit p-3" role="status"> <span class="sr-only">Loading ...</span> </div> </div>');
    });

    // Pjax Btn
    $("body").on("click", ".p-jax-btn", function (e) {
        e.preventDefault();
        var button = $(e.currentTarget),
            confirmAlert = button.data('confirm-alert') !== undefined ? button.data('confirm-alert') : 1,
            confirmTitle = button.data('confirm-title') !== undefined ? button.data('confirm-title') : 'تایید',
            confirmText = button.data('confirm-text') !== undefined ? button.data('confirm-text') : 'آیا مطمئن هستید؟',
            confirmBtnText = button.data('confirm-btn-text') !== undefined ? button.data('confirm-btn-text') : 'بله',
            cancelBtnText = button.data('cancel-btn-text') !== undefined ? button.data('cancel-btn-text') : 'خیر',
            successTitle = button.data('success-title') !== undefined ? button.data('success-title') : 'عملیات موفق',
            hideModal = button.data('hide-modal') !== undefined ? button.data('hide-modal') : 1,
            url = button.data('url'),
            reloadUrl = button.data('reload-url'),
            pjaxContainer = button.data('reload-pjax-container'),
            closeForm = button.closest('form'),
            postData = {};

        var btnOldHtml = button.html();
        button.html('<i class="fas fa-spinner fa-pulse"></i>').prop("disabled", true);
        var modalPjax = $('#modal-pjax');

        // Prevent of bad request exception (Unable to verify your data submission.)
        if (closeForm !== undefined) {
            jQuery.extend(postData, {'_csrf-mnv': closeForm.find("input[name*='_csrf-mnv']").val()});
        }

        function sendRequest() {
            $.post(url, postData, function (data) {
                if (data.status !== false) {
                    button.prop("disabled", false).html(btnOldHtml);
                }
                // errors handling
                else {
                    return false;
                }
            }).fail(function (xhr, status, error) {
                defaultSettings = {
                    title: xhr.responseText,
                    type: 'error',
                    confirmButtonText: '<i class ="fas fa-thumbs-up font-22"></i>'
                };
                withoutConfirmAlertSettings = {
                    title: xhr.responseText,
                    toast: true,
                    position: 'top-end',
                    timer: 3000,
                    background: '#f8d7da',
                    showConfirmButton: false,
                };
                if (confirmAlert === 0) {
                    jQuery.extend(defaultSettings, withoutConfirmAlertSettings);
                }
                swal(defaultSettings);
                button.prop("disabled", false).html(btnOldHtml);
            }).then(function (result) {
                if (result.status === true) {
                    var defaultSettings = {
                            title: successTitle,
                            text: result.message,
                            type: 'success',
                            confirmButtonText: '<i class ="fas fa-thumbs-up font-22"></i>',
                        },
                        withoutConfirmAlertSettings = {
                            text: null,
                            title: result.message,
                            toast: true,
                            position: 'top-end',
                            timer: 3000,
                            background: '#d4edda',
                            showConfirmButton: false,
                        };
                    if (confirmAlert === 0) {
                        jQuery.extend(defaultSettings, withoutConfirmAlertSettings);
                    }
                    swal(defaultSettings);
                    pjaxOptions = {
                        timeout: false,
                        scrollTo: false,
                        push: false,
                        replace: false,
                        skipOuterContainers: true,
                    };
                    if (reloadUrl !== undefined) {
                        jQuery.extend(pjaxOptions, {url: reloadUrl})
                    }
                    $.pjax.reload('#' + pjaxContainer, pjaxOptions);
                    button.prop("disabled", false).html(btnOldHtml);
                    if (hideModal) {
                        modalPjax.modal('hide');
                    }
                } else {
                    defaultSettings = {
                        title: 'خطا',
                        text: result.message,
                        type: 'error',
                        confirmButtonText: '<i class ="fas fa-thumbs-up font-22"></i>',
                    };
                    withoutConfirmAlertSettings = {
                        text: null,
                        title: result.message,
                        toast: true,
                        position: 'top-end',
                        timer: 3000,
                        background: '#f8d7da',
                        showConfirmButton: false,
                    };
                    if (confirmAlert === 0) {
                        jQuery.extend(defaultSettings, withoutConfirmAlertSettings);
                    }
                    swal(defaultSettings);
                }
                button.prop("disabled", false).html(btnOldHtml);
            });
        }

        if (confirmAlert) {
            swal({
                title: confirmTitle,
                text: confirmText,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: cancelBtnText,
                confirmButtonText: confirmBtnText
            }).then((result) => {
                if (result.value) {
                    sendRequest();
                } else {
                    button.prop("disabled", false).html(btnOldHtml);
                }
            });
        } else {
            sendRequest();
        }
    });

    // Confirm Btn
    $("body").on("click", ".confirm-btn", function (e) {
        e.preventDefault();
        var button = $(e.currentTarget),
            confirmTitle = button.data('confirm-title') !== undefined ? button.data('confirm-title') : 'تایید',
            confirmText = button.data('confirm-text') !== undefined ? button.data('confirm-text') : 'آیا مطمئن هستید؟',
            confirmBtnText = button.data('confirm-btn-text') !== undefined ? button.data('confirm-btn-text') : 'بله',
            cancelBtnText = button.data('cancel-btn-text') !== undefined ? button.data('cancel-btn-text') : 'خیر',
            url = button.data('url');

        var btnOldHtml = button.html();
        button.html('<i class="fas fa-spinner fa-pulse"></i>').prop("disabled", true);

        swal({
            title: confirmTitle,
            text: confirmText,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: cancelBtnText,
            confirmButtonText: confirmBtnText
        }).then((result) => {
            if (result.value) {
                window.location.replace(url);
            } else {
                button.prop("disabled", false).html(btnOldHtml);
            }
        });
    });

    // Alert Btn
    $("body").on("click", ".alert-btn", function (e) {
        e.preventDefault();
        var button = $(e.currentTarget),
            alertTitle = button.data('alert-title') !== undefined ? button.data('alert-title') : 'هشدار',
            alertText = button.data('alert-text') !== undefined ? button.data('alert-text') : 'امکان انجام این عملیت وجود ندارد!',
            alertBtnText = button.data('alert-btn-text') !== undefined ? button.data('alert-btn-text') : 'باشه';

        swal({
            title: alertTitle,
            text: alertText,
            type: 'warning',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: alertBtnText
        });
    });
});