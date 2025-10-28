<p>Hello {{ $model->username }},</p>
<p>Your password has been reset by the administrator.</p>
<p>Here are your new login credentials:</p>
<ul>
    <li><strong>Email:</strong> {{ $model->email }}</li>
    <li><strong>Password:</strong> {{ $model->new_password }}</li>
</ul>
<p>We recommend logging in and changing your password immediately for security purposes.</p>
<p>Login here:<a href="{{ route('login') }}">{{ route('login') }}</a></p>
<p>Thank you,<br>Your Support Team</p>
