<script>
    $(function () {
        @if ($message = \Illuminate\Support\Facades\Session::get('success'))
        showAlert('{!! $message !!}', 'success');
        @endif

        @if ($error = \Illuminate\Support\Facades\Session::get('error'))
        showAlert('{!! $error !!}', 'error');
        @endif
    });
</script>
