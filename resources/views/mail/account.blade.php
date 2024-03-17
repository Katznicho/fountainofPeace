<x-mail::message>

Hello, {{$name}} your account with {{ config('app.name') }}

You can use {{$password }} to login into {{ config('app.name') }}

<x-mail::button :url="$url">
  Login
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
