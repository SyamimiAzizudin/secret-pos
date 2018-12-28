<div class="text-center">
    <div class="table-container">
        <div class="col-md-2 col-xs-12 panel panel-default">
            <div class="panel-heading text-center">
                 <h5>Yearly Target</h5>
            </div>
            <div class="panel-body text-center">
                <h3>RM {{ number_format( ($yearly_target/1000000), 2, '.', ',' ) }} m</h3>
            </div>
        </div>

        <div class="col-md-3 col-xs-12 panel panel-default">
            <div class="panel-heading text-center">
                <h5>Target Savings (Cumm) </h5>
            </div>
            <div class="panel-body text-center">
                <h3>RM {{ number_format( ($cummulative_target), 2, '.', ',' ) }}</h3>
            </div>
        </div>
            
        <div class="col-md-3 col-xs-12 panel panel-default">
            <div class="panel-heading text-center">
                <h5>Actual Savings (Cumm) </h5>
            </div>
            <div class="panel-body text-center">
                <h3>RM {{ number_format( ($cummulative_actual), 2, '.', ',' ) }}</h3>
            </div>
        </div>
        <div class="col-md-2 col-xs-12 panel panel-default margin-left-table">
            <div class="panel-heading text-center">
                <h5>Yearly % (Cumm) </h5>
            </div>
            <div class="panel-body text-center">
                @if($yearly_target != '0')
                    <h3>{{ number_format(( ($cummulative_actual/$yearly_target) * 100),0) }} %</h3>
                @else
                    <h3>0</h3>
                @endif
            </div>
        </div>
                
        <div class="col-md-2 col-xs-12 panel panel-default">
            <div class="panel-heading text-center">
                <h5>Monthly % (Cumm)</h5>
            </div>
            <div class="panel-body text-center">
                @if($cummulative_target != '0')
                    <h3>{{ number_format(($cummulative_actual/$cummulative_target) * 100,0) }} %</h3>
                @else
                    <h3>0</h3>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Get Main Latest Date-->
            <div class="col-lg-12">
                <p class="text-right">Last Update Savings: {{ Carbon\Carbon::parse($last_update)->format('g:i A, d F Y') }}</p>
            </div>
        </div>
    </div>
    
    <!-- Main Chart Section -->
    <div class="row menu-dashboard">
        <div class="col-lg-12">
            <center>
                
                <div id="main_app">
                    <highcharts :options="options" ref="highcharts"></highcharts>
                </div>

                <br>

                @if(Auth::user()->role != 'subsidiary')
                <div class="col-md-8 col-md-offset-2">
                    <?php $i=0 ?>
                    @forelse ($companies as $company)
                    <div class="col-md-4 col-xs-12 col-sm-4">
                        <a href="{{ url('/group-dashboard') }}/{{$company->group}}" type="button" class="btn btn-lg btn-primary custom1">Dashboard {{$company->group}}</a>
                    </div>
                    <?php $i++; ?>
                    @empty
                    @endforelse
                </div>
                @else
                <div class="col-md-4 col-md-offset-4">
                    <?php $i=0 ?>
                    @forelse ($companies as $company)
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <a href="{{ url('/group-dashboard') }}/{{$company->group}}" type="button" class="btn btn-lg btn-primary custom1">Dashboard {{$company->group}}</a>
                    </div>
                    <?php $i++; ?>
                    @empty
                    @endforelse
                </div>
                @endif

            </center>
        </div>
    </div>

    <div class="container">

    <!--Main Summary-->
    <div class="row">
        <div class="col-md-12 padding2">
            <div class="col-md-12">
                <h3 class="page-header">Cost Saving Summary - Group</h3>

                <div class="form-group col-md-6">
                    <label for="month" class="col-sm-3 control-label">Month</label>
                    <div class="col-sm-6">
                        <select name="month" class="form-control" id="main_filtermonth">
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-12 padding2">
                <div class="form-group">
                    <div id="main_saving_summary_month"></div>
                </div>
            </div>
        </div>
    </div>   

    <div class="row">
        <div class="col-lg-12">
            <div class="text-right padding2">
                {{-- <a href="{{ route('dashboard_pdfview', $year) }}" class="btn btn-outline-success success print-ipad">Download PDF</a> --}}
                <button onclick="myPrint()" class="btn btn-outline-success success print-ipad">Print PDF</button>
            </div>
        </div>
    </div>
</div>
</div>

<script>

    // pass value to js
    var year = <?php echo json_encode($year); ?>;
    
    // initial load
    getTable(year, 1);
    $(function() {
        $("#main_filtermonth").on('change', function(){
            var value = $(this).find(":selected").val();
            var curr_year = <?php echo json_encode($year); ?>;
            getTable(curr_year, value);
        });
    });

    function getTable(year, month)
    {
        $.ajax({
            url: 'dashboard_cost_saving_summary/'+year+'/'+month, //this is the submit URL
            type: 'GET', //or POST
            success: function(data){
                $("#main_saving_summary_month").html(data);
            }
        });
    }
    
    Vue.use(VueHighcharts);

    var options = {
        title: {
            text: '',
            x: -20 //center
        },
        xAxis: {
            title: {
                text: 'Month'
            },
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: 'Saving (RM)',
                position: "top"
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ''
        },
        legend: {
            position: "bottom"
        },
        series: [{
            name: 'Target Savings (RM)',
            data: <?php echo json_encode($graphs['targets']); ?>
        }, {
            name: 'Actual Savings (RM)',
            data: <?php echo json_encode($graphs['actual']); ?>
        }, {
            name: 'Yearly Target (RM)',
            data: <?php echo json_encode($graphs['yearly_target']); ?>
        }]
    };

    var vm = new Vue({
        el: '#main_app',
        data: {
        options: options
        },
        methods: {
            updateCredits: function() {
                var chart = this.$refs.highcharts.chart;
                chart.credits.update({
                    style: {
                        color: '#' + (Math.random() * 0xffffff | 0).toString(16)
                    }
                });
            }
        }
    });

</script>