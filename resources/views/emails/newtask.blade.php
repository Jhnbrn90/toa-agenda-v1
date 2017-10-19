@component('mail::message')
# Nieuwe aanvraag

** {{ $day }} **
<br>
** {{ $time }} **
<br>

@component('mail::table')

| Docent            |       | Vak                  |       | Type              |
|-------------------|-------|----------------------|-------|-------------------|
| {{ $user->name }} |       | {{ $task->subject }} |       | {{ $task->type }} |

| Klas               |       | Locatie               |
|--------------------|-------|-----------------------|
| {{ $task->class }} |       | {{ $task->location }} |

@endcomponent

<br>

## {{ $task->title }}

@component('mail::panel')
{{ $task->body }}
@endcomponent

@component('mail::button', ['url' => $actionURL])
Aanvraag bekijken
@endcomponent


@endcomponent
