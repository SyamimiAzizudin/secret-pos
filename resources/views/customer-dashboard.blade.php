@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Customer Dashboard</h1>
            <ol class="breadcrumb col-md-7 pull-left">
                <li><a href="{{ url('/home') }}">Home</a></li>
                <li class="active">Customer Dashboard</li>
            </ol>
            <div class="form-group col-md-5 pull-right filter-width">
                <label for="year" class="col-sm-3 control-label filter-year">Year: </label>
                <div class="col-sm-4 filter-year">
                    <select name="year" class="form-control" id="main_filteryear">
                    </select>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="table-container">
                <div class="col-md-3 col-xs-12 panel panel-default">
                    <div class="panel-heading text-center">
                         <h5>Area Cover</h5>
                    </div>
                    <div class="panel-body text-center">
                        <h3>20</h3>
                    </div>
                </div>

                <div class="col-md-3 col-xs-12 panel panel-default">
                    <div class="panel-heading text-center">
                        <h5>No. of Customer</h5>
                    </div>
                    <div class="panel-body text-center">
                        <h3>255</h3>
                    </div>
                </div>
                
                <div class="col-md-3 col-xs-12 panel panel-default margin-left-table">
                    <div class="panel-heading text-center">
                        <h5>Yearly % (Cumm) </h5>
                    </div>
                    <div class="panel-body text-center">
                        <h3>45 %</h3>
                    </div>
                </div>
                    
                <div class="col-md-3 col-xs-12 panel panel-default">
                    <div class="panel-heading text-center">
                        <h5>Monthly % (Cumm)</h5>
                    </div>
                    <div class="panel-body text-center">
                        <h3>55 %</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="container">
                <p class="text-right">Last Update Savings: 11:42 PM, 04 December 2018</p>
            </div>
        </div>

        <!-- Main Chart Section -->
        <div class="col-lg-12">
            <center>
                <div id="app">
                    <div id="chart" ref="barchart"></div>
                </div>
            </center>
        </div>

        <!--Main Summary-->
        <div class="col-lg-12">
            <h3 class="page-header">Customer Summary</h3>
            <div class="col-md-12">
                <div class="form-group col-md-6">
                    <label for="month" class="col-sm-3 control-label">Month</label>
                    <div class="col-md-6">
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
            <div class="col-md-12">
                <div class="form-group">
                    <table class="table table-bordered table-summary">
                        <tr class="text-center">
                            <td><label class="col-md-12 control-label">Area Cover</label></td>
                            <td><label class="col-md-12 control-label">No. of Customer</label></td>
                            <td><label class="col-md-12 control-label">%</label></td>
                        </tr>
                        <tr class="text-center">
                            <td class="text-left"><a class="control-label" href="#">SS16</a></td>
                            <td><label class="col-md-12 control-label">50</label></td>
                            <td><label class="col-md-12 control-label">30</label></td>
                        </tr>
                        <tr class="text-center">
                            <td class="text-left"><a class="control-label" href="#">Taman Megah</a></td>
                            <td><label class="col-md-12 control-label">45</label></td>
                            <td><label class="col-md-12 control-label">15</label></td>
                        </tr>
                        <tr class="text-center">
                            <td class="text-left"><a class="control-label" href="#">USJ7</a></td>
                            <td><label class="col-md-12 control-label">89</label></td>
                            <td><label class="col-md-12 control-label">65</label></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script>

    // get year
    var currentTime = new Date();
    var year = currentTime.getFullYear();

    // do loop year
    var i = 2020 - 2018;

    //  append for asc, prepend for desc
    while(i>=0){
        $('#main_filteryear').prepend($('<option>', {
            value: year + i,
            text: year + i
        }));
        i--;
    }

    $(function() {
        $('#main_filteryear').on('change', function(){
            var selected_value = $(this).find(':selected').val();
            getYear(selected_value);
        });
    });

    new Vue({
        el: '#app',
        mounted: function() {
            new ApexCharts(this.$refs.barchart, {
                chart: {
                    type: 'bar',
                    height: 400
                },
                series: [{
                    name: 'No. of Customer',
                    data: [55,40,45,60,49,50,70,90,65]
                }],
                xaxis: {
                    categories: ['USJ5','Section 14','Taman Mayang','Taman Megah','SS16','USJ2','SS2', 'Section 2','Taman Equine']
                }
            }).render()
        }
    });

</script>

@endsection