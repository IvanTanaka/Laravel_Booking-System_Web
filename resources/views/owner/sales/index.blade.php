@extends('layouts.base')
@section('head')
    <style>
        .card-info .card-header{
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
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Sales</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li>
            </ol>
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
            
              <!-- LINE CHART -->
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Sales Amount</h3>
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
              <div class="card card-danger">
                <div class="card-header">
                  <h3 class="card-title">Best Seller</h3>
  
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                  </div>
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
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">Bar Chart</h3>
  
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                  </div>
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
            }
          }]
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
              {{$menu->order_details_count}},
              @endforeach
            ],
            backgroundColor : ['#d92323', '#00a65a', '#00c0ef', '#adf542', '#f39c12', '#6b2c43', '#3c8dbc', '#d2d6de', '#8c2be0'],
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
      var barChartCanvas = $('#barChart').get(0).getContext('2d')
      var barChartData = jQuery.extend(true, {}, monthlySalesData)
      var temp0 = monthlySalesData.datasets[0]
    //   var temp1 = monthlySalesData.datasets[1]
      barChartData.datasets[0] = temp0
    //   barChartData.datasets[1] = temp0
  
      var barChartOptions = {
        responsive              : true,
        maintainAspectRatio     : false,
        datasetFill             : false
      }
  
      var barChart = new Chart(barChartCanvas, {
        type: 'bar', 
        data: barChartData,
        options: barChartOptions
      })
    })
  </script>
@endsection