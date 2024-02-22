@extends('admin.share.master')
@section('content')
    <div class="row" id="app">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-4">
                        <label for="">Từ Ngày</label>
                        <input type="date" class="form-control" id="begin">
                    </div>
                    <div class="col-md-4">
                        <label for="">Đến Ngày</label>
                        <input type="date" class="form-control" id="end">
                    </div>
                    <div class="col-md-4" style="margin-top: 20px">
                        <button class="btn btn-success" id="search">Search</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div>
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart');
        var dataKey = [];
        let chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: "Số Lần Click",
                    fill: true,
                    data: [],
                    borderWidth: 1,
                    backgroundColor: ['#CB4335', '#1F618D', '#F1C40F', '#27AE60', '#884EA0', '#D35400'],
                }]
            },
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            beforeTitle: function(context, data) {
                                if (dataKey.length > 0) {
                                    return "Name: " + dataKey[context[0].dataIndex];
                                }
                                return null;
                            },
                            title: function(context) {
                                return "Code: " + context[0].label;
                            },
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        loadData();

        function loadData() {
            axios
                .get('/admin/keyword/data-chart')
                .then((res) => {
                    chart.data.labels = res.data.labels;
                    chart.data.datasets[0].data = res.data.datas;
                    dataKey = res.data.dataKey;
                    chart.update();
                });
        }

        $("#search").click(function() {
            var payload = {
                'begin': $("#begin").val(),
                'end': $("#end").val()
            }
            axios
                .post('/admin/keyword/search', payload)
                .then((res) => {
                    chart.data.labels = res.data.labels;
                    chart.data.datasets[0].data = res.data.datas;
                    dataKey = res.data.dataKey;
                    chart.update();
                })
                .catch((err) => {
                    displayErrors(err);
                });
        });
    </script>
@endsection
