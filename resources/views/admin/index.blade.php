@extends('layouts.app')


@section('head')

    <script src="{{ asset('global_assets/js/plugins/visualization/echarts/echarts.min.js') }}"></script>

    <script>
    /* ------------------------------------------------------------------------------
 *
 *  # Echarts - Basic column example
 *
 *  Demo JS code for basic column chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


    // Setup module
    // ------------------------------

    var EchartsColumnsBasicLight = function() {


        //
        // Setup module components
        //

        // Basic column chart
        var _columnsBasicLightExample = function() {
            if (typeof echarts == 'undefined') {
                console.warn('Warning - echarts.min.js is not loaded.');
                return;
            }

            // Define element
            var columns_basic_element = document.getElementById('columns_basic');


            //
            // Charts configuration
            //

            if (columns_basic_element) {

                // Initialize chart
                var columns_basic = echarts.init(columns_basic_element);


                //
                // Chart config
                //

                // Options
                columns_basic.setOption({

                    // Define colors
                    color: ['#5ab1ef'],

                    // Global text styles
                    textStyle: {
                        fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                        fontSize: 13
                    },

                    // Chart animation duration
                    animationDuration: 750,

                    // Setup grid
                    grid: {
                        left: 0,
                        right: 40,
                        top: 35,
                        bottom: 0,
                        containLabel: true
                    },

                    // Add legend
                    legend: {
                        data: ['@lang('app.Transactions')'],
                        itemHeight: 8,
                        itemGap: 20,
                        textStyle: {
                            padding: [0, 5]
                        }
                    },

                    // Add tooltip
                    tooltip: {
                        trigger: 'axis',
                        backgroundColor: 'rgba(0,0,0,0.75)',
                        padding: [10, 15],
                        textStyle: {
                            fontSize: 13,
                            fontFamily: 'Roboto, sans-serif'
                        }
                    },

                    // Horizontal axis
                    xAxis: [{
                        type: 'category',
                        data: [@foreach($last30tran as $item) "{{ $item['date'] }}", @endforeach],
                        axisLabel: {
                            color: '#333'
                        },
                        axisLine: {
                            lineStyle: {
                                color: '#999'
                            }
                        },
                        splitLine: {
                            show: true,
                            lineStyle: {
                                color: '#eee',
                                type: 'dashed'
                            }
                        }
                    }],

                    // Vertical axis
                    yAxis: [{
                        type: 'value',
                        axisLabel: {
                            color: '#333'
                        },
                        axisLine: {
                            lineStyle: {
                                color: '#999'
                            }
                        },
                        splitLine: {
                            lineStyle: {
                                color: ['#eee']
                            }
                        },
                        splitArea: {
                            show: true,
                            areaStyle: {
                                color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.01)']
                            }
                        }
                    }],

                    // Add series
                    series: [
                        {
                            name: '@lang('app.Transactions')',
                            type: 'bar',
                            data: [@foreach($last30tran as $item) {{ $item['total'] }} , @endforeach],
                            itemStyle: {
                                normal: {
                                    label: {
                                        show: true,
                                        position: 'top',
                                        textStyle: {
                                            fontWeight: 500
                                        }
                                    }
                                }
                            },
                            markLine: {
                                data: [{type: 'average', name: 'Average'}]
                            }
                        }
                    ]
                });
            }


            //
            // Resize charts
            //

            // Resize function
            var triggerChartResize = function() {
                columns_basic_element && columns_basic.resize();
            };

            // On sidebar width change
            var sidebarToggle = document.querySelector('.sidebar-control');
            sidebarToggle && sidebarToggle.addEventListener('click', triggerChartResize);

            // On window resize
            var resizeCharts;
            window.addEventListener('resize', function() {
                clearTimeout(resizeCharts);
                resizeCharts = setTimeout(function () {
                    triggerChartResize();
                }, 200);
            });
        };


        //
        // Return objects assigned to module
        //

        return {
            init: function() {
                _columnsBasicLightExample();
            }
        }
    }();


    // Initialize module
    // ------------------------------

    document.addEventListener('DOMContentLoaded', function() {
        EchartsColumnsBasicLight.init();
    });

</script>
@endsection

@section('content')


    <!-- Content area -->
    <div class="content ">

        <div class="mb-3">
            <h6 class="mb-0 ">
                 @lang('app.main')
            </h6>
        </div>

        <div class="row">
            <div class="col-sm-6 col-xl-3">
                <a href="{{ asset('admin/users') }}" class="card card-body">
                    <div class="media">
                        <div class="mr-3 align-self-center">
                            <i class="icon-user icon-2x text-teal-400"></i>
                        </div>

                        <div class="media-body text-right">
                            <h3 class="font-weight-semibold text-black mb-0">1</h3>
                            <span class="text-uppercase font-size-sm text-muted"> @lang('app.Total_Users')</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-xl-3">
                <a href="{{ asset('admin/orders') }}" class="card card-body">
                    <div class="media">
                        <div class="mr-3 align-self-center">
                            <i class="icon-cart2 icon-2x text-indigo-400"></i>
                        </div>

                        <div class="media-body text-right">
                            <h3 class="font-weight-semibold text-black mb-0">2</h3>
                            <span class="text-uppercase font-size-sm text-muted">@lang('app.total_orders')</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-xl-3">
                <a href="{{ asset('admin/transactions') }}" class="card card-body">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="font-weight-semibold text-black mb-0">{{ $transactions }} ₾</h3>
                            <span class="text-uppercase font-size-sm text-muted"> @lang('app.total_transactions') </span>
                        </div>

                        <div class="ml-3 align-self-center">
                            <i class="icon-coin-dollar icon-2x text-blue-400"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-xl-3">
                <a href="{{ asset('admin/transactions') }}" class="card card-body">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="font-weight-semibold text-black mb-0">{{ $today }} ₾</h3>
                            <span class="text-uppercase font-size-sm text-muted"> @lang('app.total_today') </span>
                        </div>

                        <div class="ml-3 align-self-center">
                            <i class="icon-arrow-up-right2 icon-2x text-success-400"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row">

            <div class="col-sm-6 col-xl-3">
                <a href="{{ asset('admin/orders?status=1' ) }}" class="card card-body bg-success-600 has-bg-image">
                    <div class="media">
                        <div class="mr-3 align-self-center">
                            <i class="icon-checkmark4 icon-2x opacity-75"></i>
                        </div>

                        <div class="media-body text-right">
                            <h3 class="mb-0">1 @lang('app.order_main') </h3>
                            <span class="text-uppercase font-size-xs">@lang('app.orders_success')</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-xl-3">
                <a href="{{ asset('admin/orders?status=3' ) }}" class="card card-body bg-orange-600 has-bg-image">
                    <div class="media">
                        <div class="mr-3 align-self-center">
                            <i class="icon-pause icon-2x opacity-75"></i>
                        </div>

                        <div class="media-body text-right">
                            <h3 class="mb-0">2 @lang('app.order_main')</h3>
                            <span class="text-uppercase font-size-xs">@lang('app.orders_padding')</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-xl-3">
                <a href="{{ asset('admin/orders?status=2' ) }}" class="card card-body bg-danger-600 has-bg-image">
                    <div class="media">
                        <div class="mr-3 align-self-center">
                            <i class="icon-cross2 icon-2x opacity-75"></i>
                        </div>

                        <div class="media-body text-right">
                            <h3 class="mb-0">4 @lang('app.order_main')</h3>
                            <span class="text-uppercase font-size-xs">@lang('app.orders_canceled') </span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-xl-3">
                <a href="{{ asset('admin/orders?status=6' ) }}" class="card card-body bg-blue-400 has-bg-image">
                    <div class="media">
                        <div class="mr-3 align-self-center">
                            <i class="icon-history icon-2x opacity-75"></i>
                        </div>

                        <div class="media-body text-right">
                            <h3 class="mb-0">6 @lang('app.order_main')</h3>
                            <span class="text-uppercase font-size-xs">@lang('app.orders_confirmed')</span>
                        </div>
                    </div>
                </a>
            </div>


        </div>

        <!-- Basic columns -->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">@lang('app.last_30_days')</h5>
            </div>

            <div class="card-body">
                <div class="chart-container">
                    <div class="chart has-fixed-height" id="columns_basic"></div>
                 </div>
            </div>



        </div>
        <!-- /basic columns -->



    </div>
    <!-- /content area -->

@endsection
