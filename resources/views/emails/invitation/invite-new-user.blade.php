//@formatter:off
@component('mail::message')
<body>
<h2>Hi,</h2>

You have been invited to join the team <strong>{{$invitation->team->name}}</strong>.
Because you are not yet signed up to the platform,
please <a href="{{$url}}">Register for free</a>,
then you can accept or reject the invitation
in your team management console.

@component('mail::button', ['url' => $url])
Register for free
@endcomponent

Thanks,<br>
{{ config('app.name') }}
</body>
@endcomponent
