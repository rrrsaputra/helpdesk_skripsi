@extends('layouts.admin')

@section('header')
    <x-admin.header title="Dashboard" />
@endsection

@section('content')
    <div class="container-fluid" id="dashboard-content">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-3">
                <div class="btn-group" role="group">
                    <button id="show-tickets" class="btn btn-outline-primary active"><i class="fas fa-ticket-alt mr-1"></i> Tickets</button>
                    <button id="show-users" class="btn btn-outline-primary"><i class="fas fa-users mr-1"></i> Users</button>
                </div>
                <button id="save-pdf" class="btn btn-danger"><i class="fas fa-file-pdf mr-1"></i> Save as PDF</button>
            </div>
            
            <div id="tickets-dashboard">
                <div class="row">
                    <div class="col-lg-12">
                        <form id="date-range-form" method="GET" action="{{ route('admin.dashboard.index') }}" class="mb-4">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-5">
                                    <label for="start_date" class="form-label">Start Date:</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="date" id="start_date" name="start_date" class="form-control"
                                            value="{{ request('start_date') ?? now()->addDay()->subWeek()->startOfDay()->format('Y-m-d') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label for="end_date" class="form-label">End Date:</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="date" id="end_date" name="end_date" class="form-control"
                                            value="{{ request('end_date') ?? now()->addDay()->endOfDay()->format('Y-m-d') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i> Filter</button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-primary shadow-sm hover-shadow">
                            <div class="inner">
                                <h3>{{ $tickets->count() }}</h3>
                                <p class="mb-0">Total Tickets</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-secondary shadow-sm hover-shadow">
                            <div class="inner">
                                <h3>{{ $tickets->where('assigned_to', null)->count() }}</h3>
                                <p class="mb-0">Unassigned Tickets</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-clock"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success shadow-sm hover-shadow">
                            <div class="inner">
                                <h3>{{ $tickets->where('status', 'open')->count() }}</h3>
                                <p class="mb-0">Open Tickets</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-envelope-open-text"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-dark shadow-sm hover-shadow">
                            <div class="inner">
                                <h3>{{ $tickets->where('status', 'on hold')->count() }}</h3>
                                <p class="mb-0">On Hold Tickets</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-pause-circle"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning shadow-sm hover-shadow">
                            <div class="inner">
                                <h3>{{ $tickets->where('status', 'closed')->count() }}</h3>
                                <p class="mb-0">Closed Tickets</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger shadow-sm hover-shadow">
                            <div class="inner">
                                <h3>{{ $agents->count() }}</h3>
                                <p class="mb-0">Total Agents</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-cog"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info shadow-sm hover-shadow">
                            <div class="inner">
                                <h3>{{ $users->count() }}</h3>
                                <p class="mb-0">Total Users</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
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
                                    <i class="fas fa-clock mr-1"></i>
                                    Hours Until First Agent Reply
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="hours-until-reply-chart" height="300" style="height: 300px;"></canvas>
                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var ctx = document.getElementById('hours-until-reply-chart').getContext('2d');
                                    var hoursUntilReplyChart = new Chart(ctx, {
                                        type: 'bar',
                                        data: {
                                            labels: ['0-1 hours', '1-8 hours', '8-24 hours', '>24 hours'],
                                            datasets: [{
                                                label: 'Number of Tickets',
                                                data: @json(array_values($timeCategories)),
                                                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                                                borderColor: 'rgba(255, 159, 64, 1)',
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
                                                        text: 'Time Categories'
                                                    }
                                                },
                                                y: {
                                                    display: true,
                                                    title: {
                                                        display: true,
                                                        text: 'Number of Tickets'
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
                    
                </div>

                <div class="row">
                    <section class="col-lg-12 connectedSortable">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-line mr-1"></i>
                                    Agent Performance
                                </h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-hover shadow-sm">
                                    <thead>
                                        <tr>
                                            <th>Agent</th>
                                            <th>Total Tickets</th>
                                            <th>Open Tickets</th>
                                            <th>On Hold Tickets</th>
                                            <th>Closed Tickets</th>
                                            <th>Avg Get Ticket (min)</th>
                                            <th>Avg Close Ticket (min)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($agentPerformance as $performance)
                                            <tr>
                                                <td>{{ $performance['name'] }}</td>
                                                <td>{{ $performance['total'] }}</td>
                                                <td>{{ $performance['open'] }}</td>
                                                <td>{{ $performance['on hold'] }}</td>
                                                <td>{{ $performance['closed'] }}</td>
                                                <td>{{ $performance['avg_get'] }} min</td>
                                                <td>{{ $performance['avg_closed'] }} min</td>
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

            {{-- USERS DASHBOARD --}}
            <div id="users-dashboard" style="display: none;">
                <div class="row">
                    <div class="col-lg-12">
                        <form id="date-range-form" method="GET" action="{{ route('admin.dashboard.index') }}"
                            class="mb-3">
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
                                        <button type="submit" class="btn btn-primary"
                                            style="width: 103%">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <label for="user-select">Select User:</label>
                        <select id="user-select" class="form-control">
                            <option value="" disabled selected>Select a user</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <p>Name</p>
                                <h3 id="selected-user-name">Select a User</h3>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3 id="selected-user-tickets">0</h3>
                                <p>Total Tickets</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="row" id="user-charts" style="display: none;">
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
                                    <canvas id="user-total-tickets-chart" height="300" style="height: 300px;"></canvas>
                                </div>
                            </div>
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
                                    <canvas id="user-tickets-per-category-chart" height="300"
                                        style="height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <!-- End Generation Here -->
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        document.getElementById('save-pdf').addEventListener('click', function() {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            const fileName = `Dashboard ${startDate}_to_${endDate}.pdf`;

            const {
                jsPDF
            } = window.jspdf;

            const generatePDF = (dashboardId) => {
                html2canvas(document.querySelector(dashboardId), {
                    scale: 2 // Meningkatkan skala untuk mengurangi distorsi gambar
                }).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const pdf = new jsPDF('l', 'mm', 'a4'); // Mengubah orientasi ke landscape
                    const imgWidth = 297; // Lebar untuk landscape A4
                    const pageHeight = 210; // Tinggi untuk landscape A4
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
                    pdf.save(fileName);

                }).catch(function(error) {
                    console.error('Error generating PDF:', error);
                });
            };

            if (document.getElementById('tickets-dashboard').style.display !== 'none') {
                generatePDF('#tickets-dashboard');
            } else if (document.getElementById('users-dashboard').style.display !== 'none') {
                generatePDF('#users-dashboard');
            }
        });

        document.getElementById('show-tickets').addEventListener('click', function() {
            document.getElementById('tickets-dashboard').style.display = 'block';
            document.getElementById('users-dashboard').style.display = 'none';
            document.getElementById('show-tickets').classList.add('active');
            document.getElementById('show-users').classList.remove('active');
        });

        document.getElementById('show-users').addEventListener('click', function() {
            document.getElementById('tickets-dashboard').style.display = 'none';
            document.getElementById('users-dashboard').style.display = 'block';
            document.getElementById('show-users').classList.add('active');
            document.getElementById('show-tickets').classList.remove('active');
        });

        document.getElementById('user-select').addEventListener('change', function() {
        var userId = this.value;
        var startDate = document.getElementById('start_date').value;
        var endDate = document.getElementById('end_date').value;

        fetch(`/admin/dashboard/user/${userId}?start_date=${startDate}&end_date=${endDate}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('selected-user-name').innerText = data.name;
                document.getElementById('selected-user-tickets').innerText = data.tickets_count;

                // Render charts
                document.getElementById('user-charts').style.display = 'flex';

                // Update or create the line chart
                var ctxLine = document.getElementById('user-total-tickets-chart').getContext('2d');
                if (window.userTotalTicketsChart) {
                    window.userTotalTicketsChart.data.labels = data.userTicketLabels;
                    window.userTotalTicketsChart.data.datasets[0].data = data.userTicketData;
                    window.userTotalTicketsChart.update();
                } else {
                    window.userTotalTicketsChart = new Chart(ctxLine, {
                        type: 'line',
                        data: {
                            labels: data.userTicketLabels,
                            datasets: [{
                                label: 'Total Tickets',
                                data: data.userTicketData,
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
                }

                // Update or create the bar chart
                var ctxBar = document.getElementById('user-tickets-per-category-chart').getContext('2d');
                if (window.userTicketsPerCategoryChart) {
                    window.userTicketsPerCategoryChart.data.labels = data.userTicketCategories;
                    window.userTicketsPerCategoryChart.data.datasets[0].data = data.userTicketDataCategories;
                    window.userTicketsPerCategoryChart.update();
                } else {
                    window.userTicketsPerCategoryChart = new Chart(ctxBar, {
                        type: 'bar',
                        data: {
                            labels: data.userTicketCategories,
                            datasets: [{
                                label: 'Total Tickets',
                                data: data.userTicketDataCategories,
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
                }
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
@endsection
