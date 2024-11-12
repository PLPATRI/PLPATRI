//[Dashboard Javascript]

//Project:	Etikto Admin - Responsive Admin Template
//Primary use:   Used only for the main dashboard (index.html)


$(function () {

  'use strict';

  var options = {
          series: [{
          name: 'Open Ticket',
          data: [44, 55, 57, 56, 61, 58, 63, 60, 66, 70, 40, 50]
        }, {
          name: 'Close Ticket',
          data: [76, 85, 101, 98, 87, 105, 91, 114, 94, 50, 120, 35]
        }],
          chart: {
          type: 'bar',
          height: 270,
          stacked: false,  
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '35%',
            endingShape: 'rounded'
          },
        },
        legend: {
            show: false,
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 1,
          colors: ['transparent']
        },
        xaxis: {
          categories: ['Jan','Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct','Nov', 'Dec'],
        },
        yaxis: {
          title: {
            text: ''
          }
        },
        colors: ['#00baff', '#3762EA'],
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "" + val + ""
            }
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart-Overall"), options);
        chart.render();


  var options = {
          series: [{
          name: 'series1',
          data: [90, 60, 45, 40, 65, 52, 41]
        }, {
          name: 'series2',
          data: [50, 40, 55, 100, 42, 80, 60]
        }],
          chart: {
          height: 318,
          type: 'area',
          toolbar: {
            show: false,
            },
            offsetY: 30,
        },
        colors: ['#00baff', '#7047ee'],
        fill: {
          colors:['#00baff', '#7047ee'],
          opacity: 0.05,
            type: 'solid',
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
        width: [2, 2],
          curve: 'smooth'
        },
        grid: {
          show: false,
          padding: {
            left: -10,
            top: -25,
            right: -60,
          },
        },
        xaxis: {
          type: 'datetime',
          categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
        },
        legend: {
            show: false,
        },
        tooltip: {
          x: {
            format: 'dd/MM/yy HH:mm'
          },
        },
        yaxis: {
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false,
          },
          labels: {
            show: false,
            formatter: function (val) {
              return val + "%";
            }
          },
        },
        xaxis: {
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false,
          },
          labels: {
            show: false,
          },
        },
        };

        var chart = new ApexCharts(document.querySelector("#numberchart"), options);
        chart.render();



  var options = {
          series: [{
          name: 'Online Ticket',
          data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
        }, {
          name: 'Offline Ticket',
          data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
        }],
          chart: {
          type: 'bar',
          height: 298,
          offsetX: -15,
          offsetY: 8,
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        colors: ['#3596f7', '#cce5ff'],
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        },
        yaxis: {
          title: {
            text: ''
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "$ " + val + " thousands"
            }
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#revenue-chart"), options);
        chart.render();


	
	  	

	
	
}); // End of use strict
