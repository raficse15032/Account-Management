<h1>Hello</h1>
<p>
	Please activate your account
	<a href="{{ env('APP_URL')}}/api/activate/{{$user->email}}/{{$code}}">Activate Account</a>
</p>
