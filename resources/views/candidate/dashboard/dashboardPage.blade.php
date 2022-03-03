@extends('layouts.site')
@section("pageTitle", "My Dashboard")
@section("dashboardPageActive", "active")
@section('pageContent')

    @includeIf('share.homeTopMenu', ['data' => '' ])

    @includeIf('candidate.dashboard.dashboardPageView', ['showPageCandidate'=> (isset($showPageCandidate) ? $showPageCandidate : 1)])

@endsection

{{-- Style --}}
@section('style')

@endsection

{{-- Script --}}
@section('script')
    <!-- chart -->
    <script src="{{ asset('assets/js/apexcharts/apexcharts.min.js')}}"></script>

    <script src="{{ asset('assets/js/custom.js')}}"></script>
    <script>
        var options = {
            chart: {
                height: 350,
                type: 'area',
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            series: [{
                name: 'Shortlisted Application',
                data: [31, 40, 28, 51, 42, 109, 100, 3]
            }, {
                name: 'Rejected Application',
                data: [11, 32, 45, 32, 34, 52, 41]
            }],
            colors: ['#228B22', '#FF0000'],

            xaxis: {
                type: 'datetime',
                categories: ["2018-09-19T00:00:00", "2018-09-19T01:30:00", "2018-09-19T02:30:00", "2018-09-19T03:30:00", "2018-09-19T04:30:00", "2018-09-19T05:30:00", "2018-09-19T06:30:00"],
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                },
            }
        }
        var chart = new ApexCharts(
            document.querySelector("#chart"),
            options
        );
        chart.render();

    </script>
@endsection
