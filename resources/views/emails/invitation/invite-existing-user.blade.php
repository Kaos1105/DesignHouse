//@formatter:off
@component('mail::message')
<body>
<h2>Hi,</h2>

You have been invited to join the team <strong>{{$invitation->team->name}}</strong>.
Because you are already registered to the platform, you just need to accept
or reject invitation in your <a href="{{$url}}">team management console</a>.

@component('mail::button', ['url' => $url])
Go to Dashboard
@endcomponent
Thanks,<br>{{ config('app.name') }}
</body>
@endcomponent
