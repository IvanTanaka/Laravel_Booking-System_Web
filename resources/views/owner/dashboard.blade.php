@extends('layouts.base')
@section('head')
    <style>
        .card-membee .card-header, .bg-membee{
            background-color: #FF7266 !important;
            color: #fff;
        }
    </style>
@endsection
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark"></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->




    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h1 class="m-0 text-dark">Dashboard</h1>
                </div>
                <div class="card-body">
                  <div class="row">
                    @if(count($branchNoCashier) != 0)
                    <div class="col-12">
                      <div class="card bg-gradient-warning">
                        <div class="card-header">
                          <h3 class="card-title">Warning there's a branch without cashier appointed yet</h3>

                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                          </div>
                          <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                          Here are the list of branch without cashier apointed yet
                          <ul>
                          @foreach($branchNoCashier as $branch)
                            <li>{{$branch->name}}</li>
                          @endforeach
                          </ul>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                    </div>
                    @endif
                    @if($totalMenu == 0)
                    <div class="col-12">
                      <div class="card bg-gradient-warning">
                        <div class="card-header">
                          <h3 class="card-title">Warning No Menu Registered.</h3>

                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                          </div>
                          <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                          <div>
                          Without any menu, customer won't be able to find this franchise.
                          </div>
                          <a href="{{url('/menus/create')}}" class="btn btn-outline-secondary">Add Menu</a>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                    </div>
                    @endif
                    <div class="col-12 col-sm-6 col-md-3">
                      <div class="info-box">
                        <span class="info-box-icon bg-membee elevation-1"><i class="fas fa-star"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Rating</span>
                          <span class="info-box-number">
                            {{ number_format($rateTotal, 1)}}
                          </span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>


                    <div class="col-12 col-sm-6 col-md-3">
                      <div class="info-box">
                        <span class="info-box-icon bg-membee elevation-1"><i class="fas fa-dollar-sign"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Total Amount</span>
                          <span class="info-box-number">
                            {{$totalAmount}}
                          </span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>


                    <div class="col-12 col-sm-6 col-md-3">
                      <div class="info-box">
                        <span class="info-box-icon bg-membee elevation-1"><i class="fas fa-user-friends"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Today's Sales</span>
                          <span class="info-box-number">
                            {{$todaySale}}
                          </span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                      <div class="info-box">
                        <span class="info-box-icon bg-membee elevation-1"><i class="fas fa-utensils"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Menu</span>
                          <span class="info-box-number">
                            {{$totalMenu}}
                          </span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>

                    <div class="col-12">

                      <!-- LINE CHART -->
                      <div class="card card-membee">
                        <div class="card-header">
                          <h3 class="card-title">Sales Amount within year</h3>
                        </div>
                        <div class="card-body">
                          <div class="chart">
                            <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                          </div>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                    </div>

                    <div class="col-md-6">

                      <!-- PIE CHART -->
                      <div class="card card-membee">
                        <div class="card-header">
                          <h3 class="card-title">Top 5 best seller menu</h3>
                        </div>
                        <div class="card-body">
                          <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->

                    </div>
                    <!-- /.col (LEFT) -->
                    <div class="col-md-6">

                      <!-- BAR CHART -->
                      <div class="card card-membee">
                        <div class="card-header">
                          <h3 class="card-title">Top 5 branch by Sales Amount</h3>
                        </div>
                        <div class="card-body">
                          <div class="chart">
                            <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                          </div>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->

                    </div>
                    <!-- /.col (RIGHT) -->


                    <div class="col-12">

                      <!-- LINE CHART -->
                      <div class="card card-membee">
                        <div class="card-header">
                          <h3 class="card-title">Sales Revenue within a year</h3>
                        </div>
                        <div class="card-body">
                          <div class="chart">
                            <canvas id="yearsTotalChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                          </div>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
@endsection


@section('script')

<!-- ChartJS -->
<script src="/plugins/chart.js/Chart.min.js"></script>

<script>
    $(function () {
      function formatNumber(number, decimalsLength, decimalSeparator, thousandSeparator) {
       var n = number,
           decimalsLength = isNaN(decimalsLength = Math.abs(decimalsLength)) ? 2 : decimalsLength,
           decimalSeparator = decimalSeparator == undefined ? "," : decimalSeparator,
           thousandSeparator = thousandSeparator == undefined ? "." : thousandSeparator,
           sign = n < 0 ? "-" : "",
           i = parseInt(n = Math.abs(+n || 0).toFixed(decimalsLength)) + "",
           j = (j = i.length) > 3 ? j % 3 : 0;

       return sign +
           (j ? i.substr(0, j) + thousandSeparator : "") +
           i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousandSeparator) +
           (decimalsLength ? decimalSeparator + Math.abs(n - i).toFixed(decimalsLength).slice(2) : "");
      }
      /* ChartJS
       * -------
       * Here we will create a few charts using ChartJS
       */

      var monthlySalesData = {
        labels  : [
        @foreach($monthlyArr as $key => $salesData)
          "{{$key}}",
        @endforeach],
        datasets: [
          {
            label               : 'Sales Amount',
            backgroundColor     : '#1f84d7',
            borderColor         : '#1f84d7',
            pointRadius         : 10,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            lineTension         : 0,
            data                : [
        @foreach($monthlyArr as $salesData)
          {{$salesData}},
        @endforeach]
          }
        ]
      }


      var monthlySalesTotalData = {
        labels  : [
        @foreach($monthlyTotalArr as $key => $salesTotalData)
          "{{$key}}",
        @endforeach],
        datasets: [
          {
            label               : 'Sales Revenue',
            backgroundColor     : '#1f84d7',
            borderColor         : '#1f84d7',
            pointRadius         : 10,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            lineTension         : 0,
            data                : [
        @foreach($monthlyTotalArr as $salesTotalData)
          {{$salesTotalData}},
        @endforeach]
          }
        ]
      }

      var monthlySalesOption = {
        maintainAspectRatio : false,
        responsive : true,
        legend: {
          display: true
        },
        scales: {
          xAxes: [{
            gridLines : {
              display : true,
            }
          }],
          yAxes: [{
            gridLines : {
              display : false,
            },
            ticks :{
              precision: 0
            }
          }]
        }
      }


      var monthlySalesTotalOption = {
        maintainAspectRatio : false,
        responsive : true,
        legend: {
          display: true
        },
        scales: {
          xAxes: [{
            gridLines : {
              display : true,
            }
          }],
          yAxes: [{
            gridLines : {
              display : false,
            },
            ticks :{
              precision: 0,
              callback: function (value) {
                  return "Rp "+formatNumber(value,'0');
              }
            }
          }],
        },
        tooltips: {
            callbacks: {
                label: function(tooltipItem, chart){
                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                    return datasetLabel + ': RP ' + formatNumber(tooltipItem.yLabel,'0');
                }
            }
        }
      }

      //-------------
      //- LINE CHART -
      //--------------
      var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
      var lineChartOptions = jQuery.extend(true, {}, monthlySalesOption)
      var lineChartData = jQuery.extend(true, {}, monthlySalesData)
      lineChartData.datasets[0].fill = false;
      lineChartOptions.datasetFill = false

      var lineChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: lineChartData,
        options: lineChartOptions
      })

      var lineChartCanvas = $('#yearsTotalChart').get(0).getContext('2d')
      var lineChartOptions = jQuery.extend(true, {}, monthlySalesTotalOption)
      var lineChartData = jQuery.extend(true, {}, monthlySalesTotalData)
      lineChartData.datasets[0].fill = false;
      lineChartOptions.datasetFill = false

      var lineChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: lineChartData,
        options: lineChartOptions
      })

      //-------------
      //- TOP TEN SALES -
      //-------------
      var topTenSalesData        = {
        labels: [
              @foreach($bestSellingMenu as $menu)
              "{{$menu->name}}",
              @endforeach
        ],
        datasets: [
          {
            data: [
              @foreach($bestSellingMenu as $menu)
              {{$menu->sales_qty}},
              @endforeach
            ],
            backgroundColor : ['#d92323', '#f39c12', '#00a65a',  '#8c2be0', '#00c0ef'],
          }
        ]
      }
      var topTenSalesOptions     = {
        maintainAspectRatio : false,
        responsive : true,
      }

      // Get context with jQuery - using jQuery's .get() method.
      var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      var pieChart = new Chart(pieChartCanvas, {
        type: 'pie',
        data: topTenSalesData,
        options: topTenSalesOptions
      })

      //-------------
      //- BAR CHART -
      //-------------

      var branchSalesData = {
        labels  : [
        @foreach($bestBranch as $key=>$salesData)
          "{{$key}}",
        @endforeach],
        datasets: [
          {
            label               : 'Sales Amount',
            backgroundColor     : '#1f84d7',
            borderColor         : '#1f84d7',
            pointRadius         : 10,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            lineTension         : 0,
            data                : [
        @foreach($bestBranch as $salesData)
          {{$salesData}},
        @endforeach]
          }
        ]
      }


      var barChartCanvas = $('#barChart').get(0).getContext('2d')
      var barChartData = jQuery.extend(true, {}, branchSalesData)
      var temp0 = branchSalesData.datasets[0]
      barChartData.datasets[0] = temp0
    //   barChartData.datasets[1] = temp0

      var barChartOptions = {
        responsive              : true,
        maintainAspectRatio     : false,
        datasetFill             : false,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    precision: 0
                }
            }]
        }
      }

      var barChart = new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
      })
    })
  </script>
@endsection
