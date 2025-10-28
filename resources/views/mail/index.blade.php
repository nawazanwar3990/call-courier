@include('mail.components.header')
@include(sprintf('mail.components.%s',$type))
@include('mail.components.footer')
