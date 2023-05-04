{{ __('emails/login.value') }}

@component('mail::table')
{{ __('emails/login.name') }} {{ $name }}
{{ __('emails/login.email') }} {{ $email }}
{{ __('emails/login.device') }} {{ $device }}
{{ __('emails/login.browser') }} {{ $browser }}
{{ __('emails/login.platform') }} {{ $platform }}
{{ __('emails/login.ip_address') }} {{ $ip }}
{{ __('emails/login.time') }} {{ $time }}
@endcomponent

{{ __("Regards") }},<br>
{{ config('app.name') }}
