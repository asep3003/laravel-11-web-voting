@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="col-md-12">
        @include('includes.alert')
    </div>

    @role('voter')
        @can('vote-create')
            <div class="row justify-content-center">
                <div class="col-12 mb-4">
                    <h1 class="text-center">Pilih kandidat terfavorit kamu</h1>
                </div>

                <div class="row w-100 justify-content-center">
                    @foreach ($candidates as $candidate)
                        <div class="col-12 col-sm-6 col-lg-3 mb-4">
                            <div class="card h-100">
                                <img src="{{ asset('storage/' . $candidate->image) }}" alt="{{ $candidate->name }}"
                                    class="card-img-top img-fluid">

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-center">{{ $candidate->name }}</h5>
                                    <p class="mb-1"><strong>Ketua & Wakil:</strong> {{ $candidate->chairman }} &
                                        {{ $candidate->vice_chairman }}</p>
                                    <p class="mb-1"><strong>Visi:</strong> {{ $candidate->vision }}</p>
                                    <p class="mb-3"><strong>Misi:</strong> {{ $candidate->mission }}</p>

                                    @if (Auth::user()->voter->vote)
                                        <button class="btn btn-secondary mt-auto" disabled>Already Voted</button>
                                    @else
                                        <a href="{{ route('app.vote', $candidate->id) }}" class="btn btn-primary mt-auto">Vote</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endcan
    @endrole

    @role('admin')
        <div class="row justify-content-center mt-5">
            <div class="col-12 col-md-8 col-lg-6">
                <h2 class="text-center mb-3">Hasil Voting Realtime</h2>

                <div class="card">
                    <div class="card-body">
                        <div id="pie-results"></div>
                    </div>
                </div>
            </div>
        </div>
    @endrole
@endsection

@section('scripts')
    @role('admin')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var candidates = @json($candidates->pluck('name'));
                var votes = @json($candidates->pluck('votes_count'));

                var options = {
                    chart: {
                        type: "pie",
                        width: "100%",
                    },
                    series: votes,
                    labels: candidates,
                };

                var chart = new ApexCharts(document.querySelector("#pie-results"), options);
                chart.render();
            })
        </script>

        <script>
            setTimeout(function() {
                location.reload()
            }, 5000);
        </script>
    @endrole
@endsection
