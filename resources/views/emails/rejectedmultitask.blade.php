@component('mail::message')
# Aanvraag:
{{ $title }}, {{ $time }}e uur

## Geweigerde afspraken
{{ $dates }}

Bericht:
@component('mail::panel')
{{ $message }}
@endcomponent


@endcomponent
