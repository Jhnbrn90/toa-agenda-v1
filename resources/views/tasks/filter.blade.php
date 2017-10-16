@extends ('layouts.master')

@section('content')
@include ('layouts.navbar')
<br>

    <center style="padding-bottom:15px;">
        <h4><a href="/filter/{{ $date_back }}" id="back_button" class="btn btn-outline-primary pointer"><strong><<</strong></a> &nbsp; Week {{ $weekdays[0]->formatLocalized('%U') }}, {{ $weekdays[0]->formatLocalized('%Y') }} &nbsp; <a href="/filter/{{ $date_forward }}" class="btn btn-outline-primary pointer"><strong>>></strong></a></h4>
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

                @if(($results = $tasks->where('date', $weekday->format('d-m-Y'))->where('accepted', '>=', 1)->where('user_id', Auth::user()->id)) AND $results->count() !== 0)
                    @foreach($results as $result)
                        <div class="card">
                            <a name="{{ $weekday->format('d-m-Y') }}H{{ $result->timetable->school_hour }}"></a>
                            <div class="card-body">
                                <h4 class="card-title"><strong>{{ $result->timetable->school_hour }}<sup>e</sup> uur</strong></h4>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    {{ $result->timetable->starttime }} - {{ $result->timetable->endtime }}
                                </h6>
                                <div class="card-text">
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
                                </div> <!-- card text -->
                            </div> <!-- card body -->
                        </div> <!-- card -->
                    @endforeach
                @endif
            </div> <!-- column -->
            @endforeach
       </div> <!-- row -->
    </div> <!-- container -->

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

