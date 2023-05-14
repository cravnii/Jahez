{{ __('emails/reset.value') }}

@component('mail::message')
# {{ __('subject') }}
{{ __('greeting') }}
{{ __('body') }}

@component('mail::button', ['url' => url('password/reset', $token)])
{{ __('mail.button') }}
@endcomponent

{{ __('mail.message') }}
{{ __('salutation') }}
@endcomponent
