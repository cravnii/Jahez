{{ __('emails/reset.value') }}

@component('mail::message')
    {{ __('emails/reset.subject') }}
    {{ __('emails/reset.greeting') }}
    {{ __('emails/reset.body') }}

    @component('mail::button', ['url' => url('password/reset', $token)])
        {{ __('emails/reset.button') }}
    @endcomponent


    {{ __('emails/reset.salutation') }}
@endcomponent
