$('#nav-search-box').on('keypress', function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    var options = {
        source: function (request, response) {
            $.ajax({
                type: 'GET',
                url: "/dashboard/nav-search?search=" + $('#nav-search-box').val(),
                success: function (data) {
                    response(data);
                }
            });
        },
        focus: function (event, ui) {
            return false;
        },
        select: function (event, ui) {
            $(this).val(ui.item.label);
            $(cElement).closest('tr').find('.current_id').val(ui.item.value);
            // $(cElement).closest('tr').find('.current_price').val(ui.item.extra.price);
            applyCalculations();
            $(this).unbind("change");
            return false;
        }
    };
    $('body').on('keypress.autocomplete', '.nav-search-box', function () {
        $(this).autocomplete(options);
    });
})