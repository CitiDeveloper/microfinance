@extends('layouts.app')
@section('content')
    @include('partials.dashboard')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart data from PHP
            const chartData = @json($loanDisbursementData);

            // Initialize the chart
            const options = {
                chart: {
                    type: 'line',
                    height: 350,
                    toolbar: {
                        show: true
                    },
                    zoom: {
                        enabled: true
                    }
                },
                series: [{
                    name: 'Loan Disbursements',
                    data: chartData.data
                }],
                xaxis: {
                    categories: chartData.categories,
                    title: {
                        text: 'Date'
                    },
                    labels: {
                        rotate: -45,
                        formatter: function(value) {
                            return new Date(value).toLocaleDateString('en-US', {
                                month: 'short',
                                day: 'numeric'
                            });
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: 'Amount ($)'
                    },
                    labels: {
                        formatter: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                markers: {
                    size: 5,
                    hover: {
                        size: 7
                    }
                },
                colors: ['#007bff'],
                grid: {
                    borderColor: '#f1f1f1',
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    },
                    x: {
                        formatter: function(value) {
                            return new Date(value).toLocaleDateString('en-US', {
                                weekday: 'short',
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric'
                            });
                        }
                    }
                },
                title: {
                    text: 'Daily Loan Disbursements',
                    align: 'left',
                    style: {
                        fontSize: '16px',
                        fontWeight: 'bold'
                    }
                }
            };

            const chart = new ApexCharts(document.querySelector("#loanDisbursementChart"), options);
            chart.render();
        });
    </script>
@endsection
