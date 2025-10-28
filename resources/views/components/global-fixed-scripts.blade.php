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

    function deletePermanentAccount(userId) {
        Swal.fire({
            title: "{{ __('general.delete_confirm_title') }}",
            text: "{{ __('general.delete_confirm_text') }}",
            icon: "error",
            confirmButtonText: "{{ __('general.confirm_delete_permanently') }}",
            cancelButtonText: "{{ __('general.cancel') }}",
            showCancelButton: true,
            customClass: {
                confirmButton: 'btn btn-danger me-2',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false,
            focusCancel: true,
            allowOutsideClick: () => {
                const popup = Swal.getPopup();
                manageOutsideClick(popup);
                return false;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                let data = new FormData();
                data.append('userId', userId);
                $.ajax({
                    method: 'POST',
                    url: '{{ route('website.user.profile.delete') }}',
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: data,
                    beforeSend: function () {
                        showWait();
                    },
                    success: function (result) {
                        hideWait();
                        if (result.success === true) {
                            showToast(result.msg, 'success');
                            location.assign('/register');
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
                    }
                });
            }
        });
    }

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

    function submitTask(cElement, taskId, submitId = null) {
        Swal.fire({
            title: 'Submit Task',
            html:
                `<input type="hidden" id="task_id" value="${taskId}">
            <div class="mb-3 text-start">
                <label for="image" class="form-label">
                    Proof Image <span class="text-danger">*</span>
                </label>
                <input type="file" class="form-control dropify" id="image" required>
            </div>`,
            showCancelButton: true,
            confirmButtonText: 'Submit',
            cancelButtonText: 'No',
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
            didOpen: () => {
                initDropify('.dropify');
            },
            preConfirm: () => {
                const imageInput = document.getElementById('image');
                if (!imageInput.files.length) {
                    showToast('Please select an image', 'error');
                    return false;
                }
                const formData = new FormData();
                formData.append('task_id', taskId);
                formData.append('submitId', submitId);
                formData.append('image', imageInput.files[0]);
                return $.ajax({
                    method: 'POST',
                    url: '{{ route('website.branches.submit') }}',
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                        showWait();
                    },
                    success: function (response) {
                        if (response.success === true) {
                            showToast(response.msg, 'success');
                            location.assign('/task/' + taskId);
                        } else {
                            showToast(response.msg, 'error');
                        }
                    },
                    error: function (request, error, thrownError) {
                        showToast(error, 'error');
                    },
                    complete: function () {
                        hideWait();
                    }
                });
            }
        });
    }

    function readNotification(notification_type, notification_id, notification_position, event) {
        let targetElement = event.target;
        let parentElement = $(targetElement);
        let formData = new FormData();
        formData.append('notification_type', notification_type);
        formData.append('notification_id', notification_id);
        formData.append('notification_position', notification_position);
        formData.append('user_id', '{{auth()->id()}}');
        $.ajax({
            method: 'POST',
            url: '{{ route('read-notification') }}',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                showWait();
            },
            success: function (response) {
                hideWait();
                let notificationParent = $(".notification-parent");
                if (notification_type === 'all') {
                    notificationParent.empty();
                    $(".mark-all-read-btn").remove();
                    if (notification_position === '{{\App\Enums\NotificationPositionEnum::WEBSITE_LIST}}') {
                        notificationParent.append('<div class="card shadow-sm text-center p-3">No Notification Found</div>');
                    } else if (notification_position === '{{\App\Enums\NotificationPositionEnum::HEADER_LIST}}') {
                        notificationParent.append('<li class="text-center p-3">No Notification Found</li>');
                    } else if (notification_position === '{{\App\Enums\NotificationPositionEnum::ADMIN_LIST}}') {
                        notificationParent.append('<tr><td class="text-center" colspan="5">No Notification Found</td></tr>');
                    }
                } else {
                    if (notification_position === '{{\App\Enums\NotificationPositionEnum::ADMIN_LIST}}') {
                        console.log(parentElement.closest('tr'));
                    } else {
                        $(".notification_holder_" + notification_id).remove();
                    }
                }
            },
            error: function (request, error, thrownError) {
                showToast(error, 'error');
            },
            complete: function () {
                hideWait();
            }
        })

    }

    function changeSubmissionStatus(cElement) {
        let id = $(cElement).attr('data-id');
        let type = $(cElement).attr('data-type');
        Swal.fire({
            title: "{{ __('general.ask_for_change_status') }}",
            icon: "question",
            confirmButtonText: "{{ __('general.confirm') }}",
            cancelButtonText: "{{ __('general.cancel') }}",
            showCancelButton: true,
            customClass: {
                confirmButton: 'btn btn-success me-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false,
            backdrop: true,
            allowOutsideClick: () => {
                const popup = Swal.getPopup();
                manageOutsideClick(popup);
                return false;
            },
        }).then((result) => {
            if (result.value === true) {
                const formData = new FormData();
                formData.append('id', id);
                formData.append('status', type);
                return $.ajax({
                    method: 'POST',
                    url: '{{ route('admin.submissions.update') }}',
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                        showWait();
                    },
                    success: function (response) {
                        if (response.success === true) {
                            showToast(response.msg, 'success');
                            location.assign('/admin/submissions');
                        } else {
                            showToast(response.msg, 'error');
                        }
                    },
                    error: function (request, error, thrownError) {
                        showToast(error, 'error');
                    },
                    complete: function () {
                        hideWait();
                    }
                });
            }
        });
    }
    function applyGiftCard(user_id, gift_card_id, point_cost, name) {
        let yourPoints = parseInt("{{ auth()->check() ? auth()->user()->total_coins : 0 }}");
        let hasEnoughPoints = yourPoints >= point_cost;
        let shortage = point_cost - yourPoints;

        let message = hasEnoughPoints
            ? `<p class="mb-4 px-4">Redeem ${point_cost} points for a ${name}.</p>`
            : `<p class="mb-2 px-4 text-danger">You need ${shortage} more coins to redeem this gift card.</p>`;

        let html = `
        <i class="fa-solid fa-gift fa-3x text-primary mb-2 mt-4"></i><br>
        <h4>Redeem Gift Card</h4>
        ${message}
    `;

        Swal.fire({
            html: html,
            icon: "",
            confirmButtonText: "{{ __('general.confirm') }}",
            cancelButtonText: "{{ __('general.cancel') }}",
            showCancelButton: true,
            showConfirmButton: true,
            customClass: {
                confirmButton: 'btn btn-success me-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false,
            backdrop: true,
            allowOutsideClick: () => {
                const popup = Swal.getPopup();
                manageOutsideClick(popup);
                return false;
            },
            didOpen: () => {
                if (!hasEnoughPoints) {
                    const confirmBtn = Swal.getConfirmButton();
                    confirmBtn.disabled = true;
                }
            }
        }).then((result) => {
            if (result.isConfirmed && hasEnoughPoints) {
                const formData = new FormData();
                formData.append('user_id', user_id);
                formData.append('gift_card_id', gift_card_id);

                $.ajax({
                    method: 'POST',
                    url: '{{ route('website.redeem.request') }}',
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                        showWait();
                    },
                    success: function (response) {
                        hideWait();
                        if (response.success === true) {
                            Swal.fire({
                                html: `
                                        <img src="{{ asset('assets/img/front-pages/check.png') }}" class="mx-auto d-block mb-3" alt="Success Icon" style="width: 80px;">
                                        <h4>Congratulations!</h4>
                                        <p class="mb-4 px-4">You've successfully requested a gift card. You'll receive the redemption code within 24 hours.</p>
                                    `,
                                icon: "",
                                confirmButtonText: "OK",
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                },
                                buttonsStyling: false,
                                timer: 5000,
                                timerProgressBar: true,
                                willClose: () => {
                                    location.reload();
                                }
                            });
                        } else {
                            showToast(response.msg ?? "Something went wrong!", 'error');
                        }
                    },
                    error: function (request, error, thrownError) {
                        hideWait();
                        showToast("An error occurred: " + error, 'error');
                    }
                });
            }
        });
    }

    function approvedRedeemRequest(redeem_id, gift_card_id) {
        $.ajax({
            method: 'GET',
            url: '/inventories-by-gift-card/' + gift_card_id,
            dataType: 'json',
            cache: false,
            beforeSend: function (xhr) {
                showWait();
            },
            success: function (response) {
                hideWait();
                if (response.success) {
                    Swal.fire({
                        html: response.html,
                        icon: "",
                        confirmButtonText: "{{ __('general.add') }}",
                        cancelButtonText: "{{ __('general.cancel') }}",
                        showCancelButton: true,
                        showConfirmButton: true,
                        customClass: {
                            popup: 'swal-wide',
                            confirmButton: 'btn btn-success me-2',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false,
                        backdrop: true,
                        allowOutsideClick: () => {
                            const popup = Swal.getPopup();
                            manageOutsideClick(popup);
                            return false;
                        },
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let inventory_id = parseInt($('input[name="inventory_id"]:checked').val());
                            let formData = new FormData();
                            formData.append('redeem_id', redeem_id);
                            formData.append('inventory_id', inventory_id);
                            formData.append('gift_card_id', gift_card_id);
                            $.ajax({
                                method: 'POST',
                                url: '{{ route('admin.redeems.approved') }}',
                                dataType: 'json',
                                cache: false,
                                contentType: false,
                                processData: false,
                                data: formData,
                                beforeSend: function (xhr) {
                                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                                    showWait();
                                },
                                success: function (response) {
                                    hideWait();
                                    if (response.success === true) {
                                        showToast("Redeem Approved Successfully", 'success')
                                        location.assign('/admin/redeems?status=approved');
                                    }
                                }
                            });
                        }
                    });
                } else {
                    showToast("Something went wrong!", 'error');
                }
            },
            error: function () {
                hideWait();
                showToast("Failed to load data.", 'error');
            }
        });
    }

    function resetPasswordRequest() {
        Swal.fire({
            title: '',
            html: `
            <div class="text-center mt-4">
                <img class="avatar avatar-xl" src="/assets/img/password-reset-icon.png" alt=""/>
                <h4>Are you sure you want to reset your password?</h4>
                <p>This will send a request to the admin for processing.</p>
                <input type="email" id="emailInput" class="form-control mt-2" placeholder="Enter Your Valid Email Address">
            </div>`,
            icon: '',
            confirmButtonText: "{{ __('general.request_reset') }}",
            cancelButtonText: "{{ __('general.cancel') }}",
            showCancelButton: true,
            showConfirmButton: true,
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false,
            backdrop: true,
            allowOutsideClick: () => {
                const popup = Swal.getPopup();
                manageOutsideClick(popup);
                return false;
            },
            preConfirm: () => {
                const email = document.getElementById('emailInput').value;
                if (!email) {
                    Swal.showValidationMessage('Email is required');
                    return false;
                }
                return {email: email};
            }
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                let formData = new FormData();
                formData.append('email', result.value.email);
                $.ajax({
                    method: 'POST',
                    url: '{{ route('password-reset.request') }}',
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                        showWait();
                    },
                    success: function (response) {
                        hideWait();
                        if (response.success == false) {
                            showToast(response.msg, 'error');
                        }else{
                            showToast(response.msg, 'success');
                        }
                        console.log(response);
                    }
                });
            }
        });
    }

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
