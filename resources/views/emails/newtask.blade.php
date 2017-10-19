@component('mail::message')
# Nieuwe aanvraag

Docent: {{ $user->name }}

# {{ $task->title }}
> {{ $task->body }}

@component('mail::button', ['url' => $actionURL])
Aanvraag bekijken
@endcomponent


@endcomponent
