<x-mail::message>
Hello, {{$name}} your donation of amount {{$amount}} with {{ config('app.name') }}  is {{$status}}

Please login to keep track of your donations

<x-mail::button :url="$url">
  Login
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
