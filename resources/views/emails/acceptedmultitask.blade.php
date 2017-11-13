@component('mail::message')
# Aanvraag:
{{ $title }}, {{ $hour }}e uur

## Geaccepteerde afspraken
{{ $acceptedDates }}

## Geweigerde afspraken
{{ $deniedDates }}

Bericht:
@component('mail::panel')
{{ $message }}
@endcomponent


@endcomponent
