@extends ('layouts.master')

@section ('header')
    <center>
        <h4>Weekoverzicht</h4>
        <h5>Week 40, 2017</h5>
    </center>
@endsection

@section('content')
        <center>
            <h4>Week {{ $weekdays[0]->formatLocalized('%U') }}, {{ $weekdays[0]->formatLocalized('%Y') }}</h4>
        </center>
<br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1">&nbsp;</div>

            @foreach($weekdays as $weekday)
            <div class="col-xs-12 col-md-2">
                <div class="sticky-top">
                    <center>
                        <h3>{{ ucfirst($weekday->formatLocalized('%A')) }}</h3>
                             {{ $weekday->formatLocalized('%e %h') }}
                    </center>
                </div>

            @for($i = 0; $i < count($timeslots); $i++)
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><strong>{{ $timeslots[$i]->school_hour }}<sup>e</sup> uur</strong></h4>
                        <h6 class="card-subtitle mb-2 text-muted">
                            {{ $timeslots[$i]->starttime }} - {{ $timeslots[$i]->endtime }}
                        </h6>
                        <div class="card-text">
                                @if(($results = $timeslots[$i]->tasks->where('date', $weekday->format('d-m-Y'))) AND $results->count() !== 0)
                                    @foreach($results as $result)
                                        <strong class="title" t="{{ $result->id }}" style="cursor:pointer;">
                                            @php
                                            switch($result->type) {
                                                case 'assistentie':
                                                echo '<i class="fa fa-circle" aria-hidden="true"></i>';
                                                break;
                                                case 'voorbereiding':
                                                echo '<i class="fa fa-dot-circle-o" aria-hidden="true"></i>';
                                                break;
                                            }
                                            @endphp

                                            {{ $result->title }}
                                        </strong>
                                        <div id="desc{{ $result->id }}" class="highlight" style="font-size:0.9rem; display:none;">
                                            {{ $result->body }} <br>
                                            <small>{{ $result->class }} | {{ $result->location }} | {{ $result->user->name }} | {{ $result->type }}</small>
                                        </div>
                                        <br>
                                    @endforeach

                                    @else
                                    <p class="card-text">Beschikbaar</p>
                                @endif
                                <hr>
                                <center><a href="#" class="card-link">Inplannen</a></center>
                        </div> <!-- card text -->
                    </div> <!-- card body -->
                </div> <!-- card -->
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
        });
    </script>
@endsection
