<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    
    <div class="py-8">
        <div class="flex gap-2 justify-center max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Grafico linha flow bite -->
            <div class="w-full lg:w-1/2 bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                <div class="flex justify-between p-4 md:p-6 pb-0 md:pb-0">
                    <div>
                        <h5 class="leading-none text-1xl font-bold text-gray-900 dark:text-white pb-2">Entradas e saidas: {{ $totalentradasesaidas }} - Total</h5>
                    </div>
                    <div title="Porcentagem total com base no mês anterior" class="flex items-center px-1.5 py-0.5 text-base font-semibold {{ $porcentagem >= 0 ? 'text-green-500' : 'text-red-500' }} text-center">
                        {{ $porcentagem }} %
                        <svg class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
                            @if ($porcentagem >= 0)
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
                            @else
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1v12m0 0L1 9m4 4 4-4"/>
                            @endif
                        </svg>
                    </div>                    
                </div>
                <div id="labels-chart" class="px-2.5"></div>        
            </div>

            <!-- Grafico Pizza flow bite -->
            <div class="w-full lg:w-1/2 bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                <div class="flex justify-between items-start w-full">
                    <div class="flex-col items-center">
                        <div class="flex items-center mb-1">
                            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white me-1">Produtos por categorias</h5>
                            <svg data-popover-target="chart-info" data-popover-placement="bottom" class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white cursor-pointer ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm0 16a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm1-5.034V12a1 1 0 0 1-2 0v-1.418a1 1 0 0 1 1.038-.999 1.436 1.436 0 0 0 1.488-1.441 1.501 1.501 0 1 0-3-.116.986.986 0 0 1-1.037.961 1 1 0 0 1-.96-1.037A3.5 3.5 0 1 1 11 11.466Z"/>
                            </svg>
                            <div data-popover id="chart-info" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                <div class="p-3 space-y-2">
                                    <p>Quantidade de produtos separados por categorias.</p>                                    
                                </div>
                                <div data-popper-arrow></div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="flex justify-center items-center p-4 md:p-6">
                    <div id="pie-chart"></div>
                </div>
            </div>



            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                <div class="flex justify-between border-gray-200 border-b dark:border-gray-700 pb-3">
                  <dl>
                    <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Profit</dt>
                    <dd class="leading-none text-3xl font-bold text-gray-900 dark:text-white">$5,405</dd>
                  </dl>
                  <div>
                    <span class="bg-green-100 text-green-800 text-xs font-medium inline-flex items-center px-2.5 py-1 rounded-md dark:bg-green-900 dark:text-green-300">
                      <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
                      </svg>
                      Profit rate 23.5%
                    </span>
                  </div>
                </div>
              
                <div class="grid grid-cols-2 py-3">
                  <dl>
                    <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Income</dt>
                    <dd class="leading-none text-xl font-bold text-green-500 dark:text-green-400">$23,635</dd>
                  </dl>
                  <dl>
                    <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Expense</dt>
                    <dd class="leading-none text-xl font-bold text-red-600 dark:text-red-500">-$18,230</dd>
                  </dl>
                </div>
              
                <div id="bar-chart"></div>
                  <div class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
                    <div class="flex justify-between items-center pt-5">
                      <!-- Button -->
                      <button
                        id="dropdownDefaultButton"
                        data-dropdown-toggle="lastDaysdropdown"
                        data-dropdown-placement="bottom"
                        class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                        type="button">
                        Last 6 months
                        <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                      </button>
                      <!-- Dropdown menu -->
                      <div id="lastDaysdropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                          <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                            <li>
                              <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Yesterday</a>
                            </li>
                            <li>
                              <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Today</a>
                            </li>
                            <li>
                              <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 7 days</a>
                            </li>
                            <li>
                              <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 30 days</a>
                            </li>
                            <li>
                              <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 90 days</a>
                            </li>
                            <li>
                              <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 6 months</a>
                            </li>
                            <li>
                              <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last year</a>
                            </li>
                          </ul>
                      </div>
                      <a
                        href="#"
                        class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500  hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
                        Revenue Report
                        <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                      </a>
                    </div>
                  </div>
              </div>
              
              
              
        </div>
        
    </div>
    {{-- grafico de pizza flowbite --}}
    <script>            

        const getChartOptions = () => {
        return {
            series: [52.8, 26.8, 20.4],
            colors: {!! $categoriasColors !!},
            chart: {
            height: 420,
            width: "100%",
            type: "pie",
            },
            stroke: {
            colors: ["white"],
            lineCap: "",
            },
            plotOptions: {
            pie: {
                labels: {
                show: true,
                },
                size: "100%",
                dataLabels: {
                offset: -25
                }
            },
            },
            labels: {!! $categoriasEstoque !!},
            dataLabels: {
            enabled: true,
            style: {
                fontFamily: "Inter, sans-serif",
            },
            },
            legend: {
            position: "bottom",
            fontFamily: "Inter, sans-serif",
            },
            yaxis: {
            labels: {
                formatter: function (value) {
                return value + "%"
                },
            },
            },
            xaxis: {
            labels: {
                formatter: function (value) {
                return value  + "%"
                },
            },
            axisTicks: {
                show: false,
            },
            axisBorder: {
                show: false,
            },
            },
        }
        }

        if (document.getElementById("pie-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("pie-chart"), getChartOptions());
        chart.render();
        }

    </script>

    <script>
              const options = {
        // set the labels option to true to show the labels on the X and Y axis
        xaxis: {
        show: true,
        categories: {!! $months !!},
        labels: {
            show: true,
            style: {
            fontFamily: "Inter, sans-serif",
            cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
            }
        },
        axisBorder: {
            show: false,
        },
        axisTicks: {
            show: false,
        },
        },
        yaxis: {
        show: true,
        labels: {
            show: true,
            style: {
            fontFamily: "Inter, sans-serif",
            cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
            },
            formatter: function (value) {
            return '$' + value;
            }
        }
        },
        series: [
        {
            name: "Entradas",
            data: {!! $entradas !!},
            color: "#1A56DB",
        },   
        {
            name: "Saidas",
            data: {!! $saidas !!},
            color: "#7E3BF2",
        },
        ],
        chart: {
        sparkline: {
            enabled: false
        },
        height: "100%",
        width: "100%",
        type: "area",
        fontFamily: "Inter, sans-serif",
        dropShadow: {
            enabled: false,
        },
        toolbar: {
            show: false,
        },
        },
        tooltip: {
        enabled: true,
        x: {
            show: false,
        },
        },
        fill: {
        type: "gradient",
        gradient: {
            opacityFrom: 0.55,
            opacityTo: 0,
            shade: "#1C64F2",
            gradientToColors: ["#1C64F2"],
        },
        },
        dataLabels: {
        enabled: false,
        },
        stroke: {
        width: 6,
        },
        legend: {
        show: false
        },
        grid: {
        show: false,
        },
        }

        if (document.getElementById("labels-chart") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("labels-chart"), options);
            chart.render();
        }
    </script>

    <script>

        const options = {
        series: [
            {
            name: "Income",
            color: "#31C48D",
            data: ["1420", "1620", "1820", "1420", "1650", "2120"],
            },
            {
            name: "Expense",
            data: ["788", "810", "866", "788", "1100", "1200"],
            color: "#F05252",
            }
        ],
        chart: {
            sparkline: {
            enabled: false,
            },
            type: "bar",
            width: "100%",
            height: 400,
            toolbar: {
            show: false,
            }
        },
        fill: {
            opacity: 1,
        },
        plotOptions: {
            bar: {
            horizontal: true,
            columnWidth: "100%",
            borderRadiusApplication: "end",
            borderRadius: 6,
            dataLabels: {
                position: "top",
            },
            },
        },
        legend: {
            show: true,
            position: "bottom",
        },
        dataLabels: {
            enabled: false,
        },
        tooltip: {
            shared: true,
            intersect: false,
            formatter: function (value) {
            return "$" + value
            }
        },
        xaxis: {
            labels: {
            show: true,
            style: {
                fontFamily: "Inter, sans-serif",
                cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
            },
            formatter: function(value) {
                return "$" + value
            }
            },
            categories: ["Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            axisTicks: {
            show: false,
            },
            axisBorder: {
            show: false,
            },
        },
        yaxis: {
            labels: {
            show: true,
            style: {
                fontFamily: "Inter, sans-serif",
                cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
            }
            }
        },
        grid: {
            show: true,
            strokeDashArray: 4,
            padding: {
            left: 2,
            right: 2,
            top: -20
            },
        },
        fill: {
            opacity: 1,
        }
        }

        if(document.getElementById("bar-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("bar-chart"), options);
        chart.render();
        }

    </script>
    
   
</x-app-layout>
