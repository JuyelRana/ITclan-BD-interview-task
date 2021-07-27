@extends('layouts.app')

@section('content')

    @if(session()->has('message'))
        <div
            id="show-message"
            class="alert alert-success alert-dismissible text-center">
            <button
                type="button"
                class="close"
                data-dismiss="alert"
                aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session()->get('message') }}
        </div>
    @endif

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="font-weight-bold"> Idea List</h4>
                            </div>

                            <div id="stopwatch" style="font-size: 20px; font-weight: bolder"
                                 class="col-md-4 justify-content-center align-content-center">

                            </div>

                            <div class="col-md-4 row justify-content-end align-items-end">
                                <a class="btn btn-primary" href="{{ route('ideas.create') }}">
                                    Add Idea
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body" id="reloaded_div">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Sl</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Idea</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ideas ?? '' as $key=>$idea)
                                <tr class="{{ $idea->is_win === 1 ? 'bg-info' : '' }}">
                                    <th scope="row">{{ ++$key }}</th>
                                    <td>{{ $idea->name }}</td>
                                    <td>{{ $idea->email }}</td>
                                    <td>{{ $idea->idea }}</td>
                                    <td>
                                        @if($idea->is_win === 0)
                                            Loser
                                        @elseif($idea->is_win === 1)
                                            Winner
                                        @elseif($idea->is_win === 2)
                                            Player
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('ideas.destroy',$idea) }}" method="POST">

                                            <a class="btn btn-primary"
                                               href="{{ route('ideas.edit',$idea) }}">
                                                Edit
                                            </a>

                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                onclick="return confirm('Are you sure?')"
                                                class="btn btn-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script>
        setTimeout(() => {
            let container = document.getElementById('show-message');
            if (container) {
                container.style.display = 'none';
            }

            let players = @json($players);
            console.log(players.length);

            if (players.length) {
                startTimer();

            }

        }, 3000)


        let hr = 0;
        let min = 0;
        let sec = 0;
        let stoptime = true;

        function startTimer() {
            if (stoptime == true) {
                stoptime = false;
                timerCycle();
            }
        }

        function stopTimer() {
            if (stoptime == false) {
                stoptime = true;
            }
        }

        function timerCycle() {
            if (stoptime == false) {
                sec = parseInt(sec);
                min = parseInt(min);
                hr = parseInt(hr);

                sec = sec + 1;

                if (sec == 60) {
                    min = min + 1;
                    sec = 0;
                }
                if (min == 60) {
                    hr = hr + 1;
                    min = 0;
                    sec = 0;
                }

                if (sec < 10 || sec == 0) {
                    sec = '0' + sec;
                }
                if (min < 10 || min == 0) {
                    min = '0' + min;
                }
                if (hr < 10 || hr == 0) {
                    hr = '0' + hr;
                }

                document.getElementById("stopwatch").innerHTML = hr + ':' + min + ':' + sec;

                console.log(parseFloat(min));

                if (parseFloat(min) === 1) {
                    $("#reloaded_div").load(window.location.href + " #reloaded_div");
                } else if (parseFloat(min) === 2) {
                    $("#reloaded_div").load(window.location.href + " #reloaded_div");
                } else if (parseFloat(min) === 3) {
                    $("#reloaded_div").load(window.location.href + " #reloaded_div");
                    stopTimer();
                }

                setTimeout("timerCycle()", 1000);
            }
        }

        function resetTimer() {
            timer.innerHTML = '00:00:00';
        }

    </script>
@endpush
