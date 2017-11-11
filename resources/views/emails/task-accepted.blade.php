@component('mail::message')
# Aanvraag geaccepteerd
{{ $day }} <br>
{{ $time }}, {{ $task->class }} <br>
<br>
** {{ $task->title }} ** ({{ $task->type }}) <br>
{{ $task->subject }}, locatie: {{ $task->location }}

<br>
Bericht:
<br>
@component('mail::panel')
{{ $task->message }}
@endcomponent
<br>
@component('mail::button', ['url' => $actionURL])
Aanvraag bewerken
@endcomponent



@endcomponent
