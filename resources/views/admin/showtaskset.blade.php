@extends ('admin.master')

@section('head')
<style>
.card {
  transition: all 0.2s ease-out;
}

.selected {
  background: #1A8113D4;
  color: white;
}

</style>
@endsection

@section ('content')

    @include ('admin.navbar')

        <div class="container-fluid">
          <div class="row">

            @include('admin.sidebar')

            <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
                <h1>Herhalende Aanvraag</h1>
                <h3>{{ $taskSet_title }}</h3>
                <h5>{{ ucfirst($taskSet_day) }} {{ $taskSet_time }}e uur</h5>

                <div class="row">
                  <div class="col-md-10">
                    <form action="/admin/taskset" method="POST">
                      {{ csrf_field() }}
                      <input type="hidden" name="taskset_id" value="{{ $taskSet_id }}">
                      <input type="hidden" name="taskset_title" value="{{ $taskSet_title }}">
                      <input type="hidden" name="taskset_email" value="{{ $taskSet_email }}">
                      <input type="hidden" name="taskset_time" value="{{ $taskSet_time }}">
                    <center>
                            @foreach($taskSet as $task)
                              <div class="card" style="display:inline-block; margin:5px; cursor: pointer;">
                                <div class="card-body text-center">
                                  {{ $task->date }} <br>
                                  @php
                                  preg_match('(\d\/\d)', $task->title, $count);
                                  echo '(' . $count[0]. ')';
                                  @endphp
                                  <input type="checkbox" name="tasks[]" value="{{ $task->id }}" style="display:none;">
                                </div>
                              </div>
                            @endforeach
                            <br><br>
                            <textarea rows="3" class="form-control" placeholder="Voeg bericht toe.." name="message" onChange="updateMessage(this)"></textarea> <br>
                           <button class="btn btn-lg btn-success">Geselecteerde accepteren</button>
                          </form>
                          <br><br>
                          <form action="/admin/taskset" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <input type="hidden" name="taskset_id" value="{{ $taskSet_id }}">
                            <input type="hidden" name="taskset_email" value="{{ $taskSet_email }}">
                            <input type="hidden" name="message" id="deniedMessage" value="">
                            <button class="btn btn-lg btn-danger">Alles weigeren</button>
                          </form>
                         </center>
                    </div>
                  </div>

              </main>
            </div>
          </div>
@endsection

@section('scripts')
<script type="text/javascript">
  $(document).ready(function() {
    $('.card').click(function() {

      $(this).toggleClass('selected');

      var checkBox = $(this).find('input:checkbox:first');
      checkBox.prop("checked", !checkBox.prop("checked"));

    });
  });

function updateMessage(message) {
  document.getElementById('deniedMessage').value = message.value;
}

</script>
@endsection
