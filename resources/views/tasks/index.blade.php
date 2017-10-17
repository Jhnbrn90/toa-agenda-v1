@extends ('layouts.master')

@section('content')
@include ('layouts.navbar')
<br>

    <center style="padding-bottom:15px;">
        <h4><a href="/datum/{{ $date_back }}" id="back_button" class="btn btn-outline-primary pointer"><strong><<</strong></a> &nbsp; Week {{ $weekdays[0]->formatLocalized('%U') }}, {{ $weekdays[0]->formatLocalized('%Y') }} &nbsp; <a href="/datum/{{ $date_forward }}" class="btn btn-outline-primary pointer"><strong>>></strong></a></h4>
        <a href="/">Huidige week</a>
    </center>

@include ('layouts.flash')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1">&nbsp;</div>

            @foreach($weekdays as $weekday)
                @php
                $activeLink = false;
                    if($weekday >= $today) {
                        $activeLink = true;
                    }
                @endphp
            <div class="col-xs-12 col-md-2">
                <div class="sticky-top">
                    <center>
                        <h3>{{ ucfirst($weekday->formatLocalized('%A')) }}</h3>
                            {{ $weekday->formatLocalized('%e %h') }}
                    </center>
                </div>

            @for($i = 0; $i < count($timeslots); $i++)
            @php
                $absence = $absences
                ->where('date', $weekday->format('d-m-Y'))
                ->where('school_hour', $timeslots[$i]->school_hour);
            @endphp

            @if($absence->count() > 0)
                <div class="card border-danger mb-3">
                    <a name="{{ $weekday->format('d-m-Y') }}H{{ $timeslots[$i]->school_hour }}"></a>
                    <div class="card-body">
                        <h4 class="card-title"><strong>{{ $timeslots[$i]->school_hour }}<sup>e</sup> uur</strong></h4>
                        <h6 class="card-subtitle mb-2 text-muted">
                            {{ $timeslots[$i]->starttime }} - {{ $timeslots[$i]->endtime }}
                        </h6>
                        <div class="card-text">
                            <span class="text-danger">Afwezig</span>
                            <div class="highlight">
                                {{ $absence->first()->message }}
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <a name="{{ $weekday->format('d-m-Y') }}H{{ $timeslots[$i]->school_hour }}"></a>
                    <div class="card-body">
                        <h4 class="card-title"><strong>{{ $timeslots[$i]->school_hour }}<sup>e</sup> uur</strong></h4>
                        <h6 class="card-subtitle mb-2 text-muted">
                            {{ $timeslots[$i]->starttime }} - {{ $timeslots[$i]->endtime }}
                        </h6>
                        <div class="card-text">
                                @if(($results = $timeslots[$i]->tasks->where('date', $weekday->format('d-m-Y'))->where('accepted', '>=', 1)) AND $results->count() !== 0)
                                    @foreach($results as $result)
                                        <span class="title title-status-{{ $result->accepted }}" t="{{ $result->id }}">
                                            @php
                                            switch($result->type) {
                                                case 'assistentie':
                                                echo '<i class="fa fa-circle" aria-hidden="true"></i>';
                                                break;
                                                case 'voorbereiding':
                                                echo '<i class="fa fa-dot-circle-o" aria-hidden="true"></i>';
                                                break;
                                                default:
                                                echo '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>';
                                                break;
                                            }
                                            @endphp

                                            <strong> {{ $result->title }} </strong>
                                        </span>
                                        <div id="desc{{ $result->id }}" class="highlight" style="font-size:0.9rem; display:none;">
                                            {{ $result->body }} <br>
                                            <small>{{ $result->class }} | {{ $result->location }} | {{ $result->user->name }} | {{ $result->type }}</small>
                                            @if($activeLink == true)
                                                @if(auth()->user()->id === $result->user->id)
                                                    <br><small><a class="text-danger" href="/aanvraag/{{ $result->id }}/bewerken">Bewerken</a></small>
                                                @endif
                                            @endif

                                        </div>
                                        <hr>

                                    @endforeach

                                    @else
                                    <p class="card-text">Beschikbaar</p>
                                @endif
                                @if($activeLink == true)
                                    <center><a href="/aanvraag/nieuw/{{ $weekday->format('d-m-Y') }}/{{ $timeslots[$i]->school_hour }}" class="card-link">Inplannen</a></center>
                                    @admin
                                    <center><a href="/afwezig/{{ $weekday->format('d-m-Y') }}/{{ $timeslots[$i]->school_hour }}" class="card-link text-danger">Afwezig melden</a></center>
                                    @endadmin
                                @endif

                        </div> <!-- card text -->
                    </div> <!-- card body -->
                </div> <!-- card -->
                @endif
            @endfor
            </div>
            @endforeach
       </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {

         $(".title").click(function(){
             $("#desc" + $(this).attr('t')).toggle();
         });

         $(".card-title").click(function() {
            $("[id^=desc]").toggle();
         });

         $(".card-title").mousedown(function(e){ e.preventDefault(); });
         $(".title").mousedown(function(e){ e.preventDefault(); });


        });
    </script>
@endsection

