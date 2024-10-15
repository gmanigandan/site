@if ($template && $template->content)
    @php
        $content = $template->render([
            'name' => $admin->name,
            'reset_link' => $reset_link,
        ]);
    @endphp
    {!! $content !!}
@else
<div class="container">
   
    <p>Hello {{$admin->name}},</p>
    <p>We received a request to reset your password. If you did not make this request, please ignore this email.</p>
    <p>To reset your password, click the button below:</p>
    <a href="{{$reset_link}}" class="reset-button">Reset Password</a>
    <p>If the button above does not work, you can also copy and paste the following link into your browser:</p>
    <p>{{$reset_link}}</p>
    <p>This link will expire in 15 minutes.</p>
    <p>Thank you,<br>support Team</p>
</div>
@endif
