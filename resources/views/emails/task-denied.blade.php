@component('mail::message')
# Aanvraag geweigerd
{{ $day }} <br>
{{ $time }}, {{ $task->class }} <br>
<br>
** {{ $task->title }} ** ({{ $task->type }}) <br>
{{ $task->subject }}, locatie: {{ $task->location }}
<br><br>
Bericht:
<br>
@component('mail::panel')
{{ $task->message }}
@endcomponent
<br>
Beschrijving van taak:
<br>
@component('mail::panel')
{{ $task->body }}
@endcomponent
<br>



@endcomponent
