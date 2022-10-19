<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<style>
    div.chartWrapper {
        position: relative;
        overflow: auto;
        width: 100%;
        -ms-overflow-style: none;
        /* IE and Edge */
        scrollbar-width: none;
    }

    div.chartWrapper::-webkit-scrollbar {
        display: none;
    }

    div.chartContainer {
        position: relative;
        height: 300px;
        min-height: 300px;
    }

    div.actionContainer {
        position: relative;
        height: 450px;
        min-height: 300px;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between ">
                <div class="header-title">
                    <h4 class="card-title">Tickets</h4>
                </div>
                <div class="card-header-toolbar d-flex align-items-center">
                    <select name="ticket-filter-xaxis" id="ticket-filter-xaxis" class="form-control ">
                        <option value="month">Monthly</option>
                        <option value="year">Yearly</option>
                        <option value="week">Weekly</option>
                        <option value="day">Daily</option>
                    </select>
                </div>
            </div>
            <div class="card-body pt-0 ">
                <div class="chartWrapper">
                    <div class="chartContainer">
                        <canvas class="canvas" id="ticket_chart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-block card-stretch card-height  plan-bg">
            <div class="card-body">
                <h4 class="mb-3 text-white">Welcome <?= $session->username ?></h4>
                <p>Role<br> Agent black squad</p>
                <div class="row align-items-center justify-content-between">
                    <div class="col-6 go-white ">
                        <a href="#" class="btn d-inline-block mt-5">Go Premium</a>
                    </div>
                    <div class="col-6">
                        <img src="../assets/images/layouts/mydrive/lock-bg.png" class="img-fluid" alt="image1">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card ">
            <div class="card-header pb-0 d-flex justify-content-between ">
                <div class="header-title">
                    <h4 class="card-title">Action</h4>
                </div>
                <div class="card-header-toolbar d-flex align-items-center">
                    <select name="action-filter-xaxis" id="action-filter-xaxis" class="form-control ">
                        <option value="month">Month</option>
                        <option value="year">Year</option>
                        <option value="week">Week</option>
                        <option value="day">Day</option>
                    </select>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="chartWrapper">
                    <div class="actionContainer">
                        <canvas class="canvas" id="inventory_action"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        window.fitChart = (id, chartInstance) => {
            var xAxisLabelMinWidth = 120; // Replace this with whatever value you like
            var chartCanvas = document.getElementById(id);
            var maxWidth = chartCanvas.parentElement.parentElement.clientWidth;
            var width = Math.max(chartInstance.data.labels.length * xAxisLabelMinWidth, maxWidth);
            // console.log({
            //     min: chartInstance.data.labels.length * xAxisLabelMinWidth,
            //     datalength: chartInstance.data.labels.length,
            //     width,
            //     maxWidth
            // });
            chartCanvas.parentElement.style.width = width + 'px';
        }
        let store_data = {
            labels: [],
            datasets: [{
                label: 'Total',
                fill: true,
                backgroundColor: 'rgb(201, 203, 207,0.2)',
                borderColor: 'rgb(201, 203, 207)',
                borderWidth: 2,
                borderDash: [4, 4],
                width: 1,
                pointRadius: 3,
                pointStyle: 'circle',
                data: [],
                cubicInterpolationMode: 'default',
                tension: 0,
                hoverBackgroundColor: 'rgba(143,147,246,1)',
                hoverBorderDash: [4, 4],
                hoverOffset: 4
            }, {
                label: 'New assigned',
                fill: true,
                backgroundColor: 'rgba(127,221,133,0.2)',
                borderColor: 'rgba(127,221,133,1)',
                borderWidth: 2,
                borderDash: [0, 0],
                width: 1,
                pointRadius: 3,
                pointStyle: 'circle',
                data: [],
                cubicInterpolationMode: 'default',
                tension: 0,
                hoverBackgroundColor: 'rgba(127,221,133,1)',
                hoverBorderDash: [4, 4],
                hoverOffset: 4
            }, {
                label: 'Damaged',
                fill: true,
                backgroundColor: 'rgba(250,150,116,0.2)',
                borderColor: 'rgba(250,150,116,1)',
                borderWidth: 2,
                borderDash: [0, 0],
                width: 1,
                pointRadius: 3,
                pointStyle: 'circle',
                data: [],
                cubicInterpolationMode: 'default',
                tension: 0,
                hoverBackgroundColor: 'rgba(250,150,116,1)',
                hoverBorderDash: [4, 4],
                hoverOffset: 4
            }, {
                label: 'Moved to Repair',
                fill: true,
                backgroundColor: 'rgba(255, 99, 132,0.2)',
                borderColor: 'rgb(255, 99, 132)',
                borderWidth: 2,
                borderDash: [0, 0],
                width: 1,
                pointRadius: 3,
                pointStyle: 'circle',
                data: [],
                cubicInterpolationMode: 'default',
                tension: 0,
                hoverBackgroundColor: 'rgba(127,221,133,1)',
                hoverBorderDash: [4, 4],
                hoverOffset: 4
            }, {
                label: 'Moved to Upgrade',
                fill: true,
                backgroundColor: 'rgba(255, 159, 64,0.2)',
                borderColor: 'rgb(255, 159, 64)',
                borderWidth: 2,
                borderDash: [0, 0],
                width: 1,
                pointRadius: 3,
                pointStyle: 'circle',
                data: [],
                cubicInterpolationMode: 'default',
                tension: 0,
                hoverBackgroundColor: 'rgba(127,221,133,1)',
                hoverBorderDash: [4, 4],
                hoverOffset: 4
            }, {
                label: 'Completed Repaired',
                fill: true,
                backgroundColor: 'rgba(153, 102, 255,0.2)',
                borderColor: 'rgb(153, 102, 255)',
                borderWidth: 2,
                borderDash: [0, 0],
                width: 1,
                pointRadius: 3,
                pointStyle: 'circle',
                data: [],
                cubicInterpolationMode: 'default',
                tension: 0,
                hoverBackgroundColor: 'rgba(127,221,133,1)',
                hoverBorderDash: [4, 4],
                hoverOffset: 4
            }, {
                label: 'Completed Upgrade',
                fill: true,
                backgroundColor: '#8f93f633',
                borderColor: '#8f93f6',
                borderWidth: 2,
                borderDash: [0, 0],
                width: 1,
                pointRadius: 3,
                pointStyle: 'circle',
                data: [],
                cubicInterpolationMode: 'default',
                tension: 0,
                hoverBackgroundColor: 'rgba(127,221,133,1)',
                hoverBorderDash: [4, 4],
                hoverOffset: 4
            }, ]
        };
        let data = {
            labels: [],
            datasets: [{
                label: 'Total',
                fill: true,
                backgroundColor: '#8f93f61a',
                borderColor: '#8f93f6',
                borderWidth: 2,
                borderDash: [4, 4],
                width: 1,
                pointRadius: 3,
                pointStyle: 'circle',
                data: [],
                cubicInterpolationMode: 'default',
                tension: 0,
                hoverBackgroundColor: 'rgba(143,147,246,1)',
                hoverBorderDash: [4, 4],
                hoverOffset: 4
            }, {
                label: 'Open',
                fill: true,
                backgroundColor: 'rgba(127,221,133,0.1)',
                borderColor: 'rgba(127,221,133,1)',
                borderWidth: 2,
                borderDash: [0, 0],
                width: 1,
                pointRadius: 3,
                pointStyle: 'circle',
                data: [],
                cubicInterpolationMode: 'default',
                tension: 0,
                hoverBackgroundColor: 'rgba(127,221,133,1)',
                hoverBorderDash: [4, 4],
                hoverOffset: 4
            }, {
                label: 'Close',
                fill: true,
                backgroundColor: 'rgba(250,150,116,0.1)',
                borderColor: 'rgba(250,150,116,1)',
                borderWidth: 2,
                borderDash: [0, 0],
                width: 1,
                pointRadius: 3,
                pointStyle: 'circle',
                data: [],
                cubicInterpolationMode: 'default',
                tension: 0,
                hoverBackgroundColor: 'rgba(250,150,116,1)',
                hoverBorderDash: [4, 4],
                hoverOffset: 4
            }]
        };
        let option = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    align: 'start',
                    padding: 20,
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        pointRadius: 5,
                        width: 5,
                        font: {
                            family: 'Helvetica, Arial, sans-serif',
                            size: 14,
                        }
                    },
                    title: {
                        display: true,
                        position: 'start',
                    }
                }
            },
            scales: {
                y: {
                    stacked: false,
                    grid: {
                        display: true,
                        color: "rgba(235,235,235,1)"
                    },
                    suggestedMin: 0,

                },
                x: {

                    type: 'time',
                    time: {
                        displayFormats: {
                            quarter: 'MMM YYYY'
                        }
                    },
                    ticks: {
                        font: {
                            size: 12,
                        },
                        stepSize: 500,
                    },
                    type: 'category',
                    grid: {
                        display: false,
                        color: "rgba(235,235,235,1)",
                        borderColor: '#F3F3F3',
                        borderWidth: 2,
                    }
                }
            },
            layout: {
                padding: {
                    top: 50,
                }
            }
        };
        let config = {
            type: 'line',
            options: option,
            data: data,
        };
        let store_config = {
            type: 'line',
            options: option,
            data: store_data,
        };

        Chart.defaults.font.size = 12;

        window.ticket_chart = new Chart(
            document.getElementById('ticket_chart').getContext('2d'),
            config
        );
        window.action_chart = new Chart(
            document.getElementById('inventory_action').getContext('2d'),
            store_config
        );

        //fitChart('ticket_chart', ticket_chart);
        async function render_ticket_chart() {
            window.ticket_chart.data.labels.length = 0;
            window.ticket_chart.data.datasets.map((value, index, array) => {
                window.ticket_chart.data.datasets[index].data.length = 0;
                console.log(index);
            });
            window.ticket_chart.update();
            data = {
                resourse: "get_data",
                group: $('#ticket-filter-xaxis').val(),
            }
            const url = "<?= base_url('api/dashboard/get-ticket-report') ?>";
            const options = {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams(data).toString(),
            }
            const response = await fetch(url, options);
            const res = await response.json();
            let lables = res.Lables,
                total = res.Total,
                open = res.Open,
                close = res.Close;
            lables.map(ticket_chart_lables);
            total.map(ticket_chart_total);
            open.map(ticket_chart_open);
            close.map(ticket_chart_close);
            window.ticket_chart.update();
            fitChart('ticket_chart', ticket_chart);

        }
        ticket_total = window.ticket_chart.data.datasets[0].data
        ticket_open = window.ticket_chart.data.datasets[1].data
        ticket_close = window.ticket_chart.data.datasets[2].data
        ticket_chart_lables = (value, index, array) => {
            window.ticket_chart.data.labels.push(value);
            //console.log(value);
        }
        ticket_chart_total = (value, index, array) => {
            ticket_total.push(value);
        }
        ticket_chart_open = (value, index, array) => {
            ticket_open.push(value);
        }
        ticket_chart_close = (value, index, array) => {
            ticket_close.push(value);
        }
        render_ticket_chart();
        $('#ticket-filter-xaxis').change(render_ticket_chart);
        //action chart
    });
</script>
<script>
    $(document).ready(function() {

        async function render_action_chart() {
            window.action_chart.data.labels.length = 0;
            window.action_chart.data.datasets.map((value, index, array) => {
                window.action_chart.data.datasets[index].data.length = 0;
                console.log(index);
            });
            window.action_chart.update();
            data = {
                resourse: "get_data",
                group: $('#action-filter-xaxis').val(),
            }
            const url = "<?= base_url('api/dashboard/get-action-report') ?>";
            const options = {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams(data).toString(),
            }
            const response = await fetch(url, options);
            const res = await response.json();
            let lables = res.Lables,
                total = res.Total,
                open = res.Open,
                close = res.Close;
            lables.map(action_chart_lables);
            res.Total.map(action_makeup, {
                add: 'total'
            });
            res.assigned.map(action_makeup, {
                add: 'assigned'
            });
            res.damaged.map(action_makeup, {
                add: 'damaged'
            });

            res.m2_repaired.map(action_makeup, {
                add: 'm2_repaired'
            });
            res.m2_upgrade.map(action_makeup, {
                add: 'm2_upgrade'
            });
            res.comp_repaired.map(action_makeup, {
                add: 'comp_repaired'
            });
            res.comp_upgrade.map(action_makeup, {
                add: 'comp_upgrade'
            });

            window.action_chart.update();
            fitChart('inventory_action', action_chart);

        }
        action_total = window.action_chart.data.datasets[0].data;
        action_assigned = window.action_chart.data.datasets[1].data;
        action_damaged = window.action_chart.data.datasets[2].data;
        action_m2_repair = window.action_chart.data.datasets[3].data;
        action_m2_upgrade = window.action_chart.data.datasets[4].data;
        action_comp_repair = window.action_chart.data.datasets[5].data;
        action_comp_upgrade = window.action_chart.data.datasets[6].data;
        action_chart_lables = (value, index, array) => {
            window.action_chart.data.labels.push(value);
        }

        function action_makeup(value, index, array) {
            //console.log(this.add);
            switch (this.add) {
                case 'total':
                    action_total.push(value);
                    break;
                case 'assigned':
                    action_assigned.push(value);
                    break;
                case 'damaged':
                    action_damaged.push(value);
                    break;
                case 'm2_repaired':
                    action_m2_repair.push(value);
                    break;
                case 'm2_upgrade':
                    action_m2_upgrade.push(value);
                    break;
                case 'comp_repaired':
                    action_comp_repair.push(value);
                    break;
                case 'comp_upgrade':
                    action_comp_upgrade.push(value);
                    break;

                default:
                    break;
            }
        }

        render_action_chart();
        $('#action-filter-xaxis').change(render_action_chart);
    });
</script>

<?= $this->endSection() ?>