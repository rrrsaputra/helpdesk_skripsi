@extends('layouts.agent')

@section('header')
    <x-agent.header title="Dashboard" />
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <button id="save-pdf" class="btn btn-danger mb-3">Save as PDF</button>
                    <form id="date-range-form" method="GET" action="{{ route('agent.dashboard.index') }}" class="mb-3">
                        <div class="form-row">
                            <div class="form-group col-md-12 d-flex flex-wrap align-items-end">
                                <div class="col-md-5 mb-2">
                                    <label for="start_date">Start Date:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" id="start_date" name="start_date" class="form-control"
                                            value="{{ request('start_date') ?? now()->subWeek()->startOfDay()->format('Y-m-d') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-5 mb-2">
                                    <label for="end_date">End Date:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" id="end_date" name="end_date" class="form-control"
                                            value="{{ request('end_date') ?? now()->endOfDay()->format('Y-m-d') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <button type="submit" class="btn btn-primary" style="width: 103%">Filter</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $tickets->count() }}</h3>
                            <p>Total Tickets</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $tickets->where('status', 'open')->count() }}</h3>
                            <p>Open Tickets</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $tickets->where('status', 'closed')->count() }}</h3>
                            <p>Closed Tickets</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $agents->count() }}</h3>
                            <p>Total Agents</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <section class="col-lg-7 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-line mr-1"></i>
                                Total Tickets per Week
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="total-tickets-chart" height="300" style="height: 300px;"></canvas>
                            </div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var ctx = document.getElementById('total-tickets-chart').getContext('2d');
                                var totalTicketsChart = new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels: @json($ticketLabels),
                                        datasets: [{
                                            label: 'Total Tickets',
                                            data: @json($ticketData),
                                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                            borderColor: 'rgba(54, 162, 235, 1)',
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        scales: {
                                            x: {
                                                display: true,
                                                title: {
                                                    display: true,
                                                    text: 'Days of the Week'
                                                }
                                            },
                                            y: {
                                                display: true,
                                                title: {
                                                    display: true,
                                                    text: 'Total Tickets'
                                                }
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                display: true,
                                                position: 'top'
                                            }
                                        }
                                    }
                                });
                            });
                        </script>
                    </div>
                </section>
                <section class="col-lg-5 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar mr-1"></i>
                                Total Tickets per Category
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="tickets-per-category-chart" height="300" style="height: 300px;"></canvas>
                            </div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var ctx = document.getElementById('tickets-per-category-chart').getContext('2d');
                                var ticketsPerCategoryChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: @json($ticketCategories),
                                        datasets: [{
                                            label: 'Total Tickets',
                                            data: @json($ticketDataCategories),
                                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                            borderColor: 'rgba(75, 192, 192, 1)',
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        scales: {
                                            x: {
                                                display: true,
                                                title: {
                                                    display: true,
                                                    text: 'Category'
                                                },
                                                ticks: {
                                                    autoSkip: false,
                                                    maxRotation: 90,
                                                    minRotation: 45
                                                }
                                            },
                                            y: {
                                                display: true,
                                                title: {
                                                    display: true,
                                                    text: 'Total Tickets'
                                                }
                                            }
                                        }
                                    }
                                });
                            });
                        </script>
                    </div>
                </section>
            </div>
            <div class="row">
                <section class="col-lg-6 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Tickets per Status
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="tickets-per-status-chart" height="300" style="height: 300px;"></canvas>
                            </div>
                        </div>
                        
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var ctx = document.getElementById('tickets-per-status-chart').getContext('2d');
                                var ticketsPerStatusChart = new Chart(ctx, {
                                    type: 'pie',
                                    data: {
                                        labels: @json($ticketStatus),
                                        datasets: [{
                                            label: 'Total Tickets',
                                            data: @json($ticketDataStatus),
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.2)', // Red for closed
                                                'rgba(54, 162, 235, 0.2)', // Blue for open
                                                'rgba(255, 206, 86, 0.2)',
                                                'rgba(153, 102, 255, 0.2)',
                                                'rgba(75, 192, 192, 0.2)'
                                            ],
                                            borderColor: [
                                                'rgba(255, 99, 132, 1)', // Red for closed
                                                'rgba(54, 162, 235, 1)', // Blue for open
                                                'rgba(255, 206, 86, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(75, 192, 192, 1)'
                                            ],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false
                                    }
                                });
                            });
                        </script>
                    </div>
                </section>

                <section class="col-lg-6 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-line mr-1"></i>
                                Agent Performance
                            </h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Agent</th>
                                        <th>Total Tickets</th>
                                        <th>Open Tickets</th>
                                        <th>Closed Tickets</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($agentPerformance as $performance)
                                        <tr @if($performance['name'] == Auth::user()->name) class="table-info" @endif>
                                            <td>{{ $performance['name'] }}</td>
                                            <td>{{ $performance['total'] }}</td>
                                            <td>{{ $performance['open'] }}</td>
                                            <td>{{ $performance['closed'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-20">
                                {{ $agents->links() }}
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- End Generation Here -->
@endsection

@push('scripts')
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script>
        document.getElementById('save-pdf').addEventListener('click', function() {
            const {
                jsPDF
            } = window.jspdf;

            html2canvas(document.querySelector('.container-fluid')).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF('p', 'mm', 'a4');
                const imgWidth = 210;
                const pageHeight = 295;
                const imgHeight = canvas.height * imgWidth / canvas.width;
                let heightLeft = imgHeight;
                let position = 0;

                pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;

                while (heightLeft >= 0) {
                    position = heightLeft - imgHeight;
                    pdf.addPage();
                    pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;
                }
                pdf.save('dashboard.pdf');
            });
        });
    </script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function() {
            $(".datepicker").datepicker({
                dateFormat: "yy-mm-dd"
            });
        });
    </script>
@endpush
