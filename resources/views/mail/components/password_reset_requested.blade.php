<p style="font-size: 20px; color: #333;">
    Hello Admin,
</p>

<p>A user has requested a password reset. The details are as follows:</p>

<p><strong>User Email:</strong> {{ $model->createdBy->email }}</p>

<p>Please review and process this request.</p>

<p style="margin-top: 30px;">
    <a href="{{ route('admin.password.change',$model->id) }}" style="display: inline-block; padding: 12px 20px; background-color: #007bff; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold;">
        Reset Password Now
    </a>
</p>

<p style="margin-top: 30px;">
    Thank you,<br><strong>RIO REWARDS</strong>
</p>
