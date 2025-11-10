<script>
    function manageOutsideClick() {
        const popup = Swal.getPopup();
        popup.classList.remove('swal2-show');
        setTimeout(() => {
            popup.classList.add('animate__animated', 'animate__shakeX');
        });
        setTimeout(() => {
            popup.classList.remove('animate__animated', 'animate__shakeX');
        }, 500);
        return false;
    }

    function askForLogout() {
        Swal.fire({
            title: "{{ __('general.ask_for_logout') }}",
            icon: "question",
            confirmButtonText: "{{ __('general.confirm_logout') }}",
            showCancelButton: true,
            customClass: {
                confirmButton: 'btn btn-success me-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false,
            focusCancel: true,
            allowOutsideClick: () => {
                const popup = Swal.getPopup();
                manageOutsideClick(popup);
                return false;
            }
        }).then((result) => {
            if (result.value === true) {
                $('#logoutForm').submit();
            }
        });
    }

    function askForReset(urlToReset) {
        Swal.fire({
            title: "{{ __('general.ask_for_reset') }}",
            icon: "question",
            confirmButtonText: "{{ __('general.confirm_reset') }}",
            cancelButtonText: "{{ __('general.cancel') }}",
            showCancelButton: true,
            customClass: {
                confirmButton: 'btn btn-success me-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false,
            focusCancel: true,
            allowOutsideClick: () => {
                const popup = Swal.getPopup();
                manageOutsideClick(popup);
                return false;
            }
        }).then((result) => {
            if (result.value === true) {
                location.assign(urlToReset);
            }
        });
    }

    function showToast(message, icon = 'success') {
        if (icon === 'success') {
            toastr.success(message);
        }
        if (icon === 'error') {
            toastr.error(message);
        }
        if (icon === 'warning') {
            toastr.warning(message);
        }
    }

    function SubmitAndPrint(form_id_to_submit) {
        $("#" + form_id_to_submit + " #doPrint").val('1');
        $("#" + form_id_to_submit).submit();
    }

    function SubmitAndNew(form_id_to_submit) {
        $("#" + form_id_to_submit + " #saveNew").val('1');
        $("#" + form_id_to_submit).submit();
    }

    function initDropify(element) {
        $(element).dropify({
            tpl: {
                message: '<div class="dropify-message"><span class="file-icon" /></div>',
            }
        });
    }

    function initTooltip() {
        $('.tooltip').remove();

        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl, {
                html: true
            });
        });
    }

    function initCurrencyFields(parentID = null) {
        let fieldName;
        if (parentID === null) {
            fieldName = '.currency-field';
        } else {
            fieldName = parentID + ' .currency-field';
        }

        $(fieldName).toArray().forEach(function (field) {
            new Cleave(field, {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand'
            });
        });
    }

    function printDiv() {
        let mode = 'iframe'; //popup
        let options = {
            mode: mode,
            popClose: true,
            popHt: 1300,
            popWd: 1000,
            popX: 0,
            popY: 0
        };
        $("#printArea").printArea(options);
    }

    $(document).on('click', '#printBtn', function () {
        printDiv();
    });

    function showWait() {
        Swal.fire({
            customClass: {
                confirmButton: 'd-none',
                cancelButton: 'd-none',
            },
            html: '{!! __('general.request_wait') !!}',
            allowOutsideClick: () => !Swal.isLoading(),
            allowEscapeKey: () => !Swal.isLoading(),
            allowEnterKey: () => !Swal.isLoading()
        });
        Swal.showLoading();
    }

    function hideWait() {
        Swal.close();
    }

    function initGeneralDataTable(tableID) {
        $('#' + tableID).DataTable().destroy();
        $('#' + tableID).DataTable({
            responsive: false,
            "pageLength": 100,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, '{{ __('general.all') }}']],
            "order": [],
            "aaSorting": [],
            dom: '<"dt-action-buttons text-end pt-3 pt-md-0"B><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>tr<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            "buttons": [],
        });
    }

    function initTextEditor(fieldID) {
        if ($(fieldID).length > 0) {
            const existingEditor = tinymce.get($(fieldID).attr('id'));
            if (existingEditor) {
                tinymce.remove(existingEditor);
            }

            tinymce.init({
                selector: fieldID,
                branding: false,
                menubar: false,
                plugins: ['lists'],
                toolbar: 'blocks | bold italic | alignleft aligncenter alignright alignjustify',
                setup: function (editor) {
                    editor.on('change', function () {
                        editor.save();
                    });
                }
            });
        }
    }

    window.onscroll = function () {
        scrollFunction()
    };

    function scrollFunction() {
        if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
            $('.scroll-to-top-btn').fadeIn();
        } else {
            $('.scroll-to-top-btn').fadeOut();
        }
    }

    function scrollToTop() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }

    $(document).on('hidden.bs.modal', '.modal', function () {
        $("body").css("padding-right", "0");
    });
    function showValidationErrors(request) {
        let errors = '<ul>';
        $.each(request.responseJSON.errors, function (index, value) {

            if (typeof value === 'object') {
                $.each(value, function (innerIndex, innerValue) {
                    errors += '<li>' + innerValue + '</li>';
                });
            } else {
                errors += '<li>' + value + '</li>';
            }
        });
        errors += '</ul>';

        showToast(errors, 'error');
    }

    $(function () {

        $('#generate-password').on('click', function () {
            function generatePassword(length = 12) {
                const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@#$!';
                let password = '';
                for (let i = 0; i < length; i++) {
                    password += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                return password;
            }

            const password = generatePassword();
            $('#new_password').val(password);
            $('#new_password_confirmation').val(password);
        });

        $(".redeem_code_copied").click(function () {
            navigator.clipboard.writeText($(this).text()).then(function () {
                showToast("Redeem Code Copied", 'success');
            }).catch(function (err) {
                showToast('Could not copy text', 'error');
            });
        });
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $(document).on('click', '.modal-add-btn, .modal-edit-btn', function () {
            $('#popup-modal').load($(this).data('href'), function () {
                $(this).modal('show')
                    .on('shown.bs.modal', function (e) {
                        loadExtraLibraries();
                        $('#popup_form').parsley().on('form:submit', function () {
                            showWait();
                        });
                    });
            });

            function loadExtraLibraries() {
                initTextEditor(".tinymce");
                initDropify('.dropify')
            }
        });
        $(document).on('submit', 'form#popup_form', function (e) {
            e.preventDefault();

            let form = $(this);
            let data = new FormData(this);

            showWait();
            $.ajax({
                method: 'POST',
                url: form.attr('action'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                success: function (result) {
                    hideWait();
                    if (result.success === true) {
                        showToast(result.msg, 'success');
                        $('#popup-modal').modal('hide');

                        if (result.print === true) {
                            window.open(result.printRoute, '_blank');
                        }
                        if (result.redirect_url) {
                            location.assign(result.redirect_url);
                        }
                        if (datatable) {
                            datatable.draw();
                        }
                    } else {
                        showToast(result.msg, 'error');
                    }
                },
                error: function (request, error, thrownError) {
                    hideWait();
                    if (request.status === 422) {
                        showValidationErrors(request);
                    } else {
                        showToast(request.status + ': ' + request.statusText, 'error');
                    }
                },
            });
        });
        $(document).on('click', '.modal-delete-btn', function () {
            let recordID = $(this).data('id');
            let deleteUrl = $(this).data('href');
            let row = $(this).closest('tr');

            Swal.fire({
                title: '{{ trans('general.ask_for_delete') }}',
                icon: "question",
                confirmButtonText: '{{ trans('general.confirm_delete') }}',
                showCancelButton: true,
                customClass: {
                    confirmButton: 'btn btn-success me-2',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false,
                focusCancel: true,
                backdrop: true,
                allowOutsideClick: () => {
                    const popup = Swal.getPopup();
                    manageOutsideClick(popup);
                    return false;
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    showWait();
                    $.ajax({
                        url: deleteUrl,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                            model_id: recordID
                        },
                        success: function (response) {
                            hideWait();
                            if (response.success) {
                                row.fadeOut(300, function () {
                                    $(this).remove();
                                });
                                showToast('success', '{{ trans('general.record_deleted_msg') }}');
                            } else {
                                showToast('error', response.msg || 'Something went wrong');
                            }
                        },
                        error: function (xhr) {
                            let msg = xhr.responseJSON?.message || '{{ trans('general.something_went_wrong') }}';
                            showToast('error', msg);
                        }
                    });
                }
            });
        });
        $(document).on('click', '.modal-view-btn', function () {
            $('#view-modal').load($(this).data('href'), function () {
                $(this).modal('show');
            });
        });
        $(document).on('submit', 'form.profile_form', function (e) {
            e.preventDefault();

            let form = $(this);
            let data = new FormData(this);

            $.ajax({
                method: 'POST',
                url: form.attr('action'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                beforeSend: function () {
                    form.find('button[type="submit"]').prop('disabled', true);
                    showWait();
                },
                success: function (result) {
                    hideWait();
                    if (result.success === true) {
                        showToast(result.msg, 'success');
                        window.location.reload();
                    } else {
                        showToast(result.msg, 'error');
                    }
                },
                error: function (request, error, thrownError) {
                    hideWait();
                    if (request.status === 422) {
                        showValidationErrors(request);
                    } else {
                        showToast(request.status + ': ' + request.statusText, 'error');
                    }
                },
                complete: function () {
                    form.find('button[type="submit"]').prop('disabled', false);
                }
            });
        });
    });
    function togglePassword(fieldId, el) {
        console.log(fieldId);
        let field = $("#"+fieldId);
        let icon = el.querySelector('i') || el;
        let type = field.attr('type');
        console.log(type);
        if (type === 'password') {
            field.attr('type','text');
            icon.classList.remove('ti-eye-off');
            icon.classList.add('ti-eye');
        } else {
            field.attr('type','password');
            icon.classList.remove('ti-eye');
            icon.classList.add('ti-eye-off');
        }
    }
</script>


@if(session('success'))
    <script>
        showToast("{{session('success')}}",'success')
    </script>
@endif
