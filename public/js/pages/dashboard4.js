//[Dashboard Javascript]

//Project:	Etikto Admin - Responsive Admin Template
//Primary use:   Used only for the main dashboard (index.html)


$(function () {

  'use strict';


   var options = {
          series: [{
          data: [1200, 1100, 1000, 900, 800, 700, 690, 550, 400, 360]
        }],
          chart: {
            toolbar: {
              show: false,
            },
          type: 'bar',
          height: 354
        },
        plotOptions: {
          bar: {
            borderRadius: 4,
            borderRadiusApplication: 'end',
            horizontal: true,
          }
        },
        dataLabels: {
          enabled: false
        },
        grid: {
          show: false,
        },
        xaxis: {
          categories: ['Theresa Wabb', 'Cameron', 'Willamson', 'Robert Fox', 'Russell', 'Jacob', 'Watson',
            'Floyd', 'Marvin', 'Savannah'
          ],
          labels: {
            show: false,
          },
          axisBorder: {
          show: false,
        },
        },
        };

        var chart = new ApexCharts(document.querySelector("#tickets_solved"), options);
        chart.render();


        var options = {
          series: [40, 35, 30, 25, 20],
          chart: {
          width: 380,
          type: 'polarArea'
        },
        labels: ['New', 'Open', 'Pending', 'Resolved', ' Close'],
        fill: {
          opacity: 1,
          colors:['#20b89b','#ffc043','#3d77ff','#70bade','#9553fb',],
        },
        stroke: {
          width: 0,
          colors: undefined
        },
        yaxis: {
          show: false
        },
        legend: {
          position: 'left',
          show: false,
        },
        plotOptions: {
          polarArea: {
            rings: {
              strokeWidth: 0
            },
            spokes: {
              strokeWidth: 0
            },
          }
        },
        theme: {
          monochrome: {
            enabled: true,
            shadeTo: 'light',
            shadeIntensity: 0.6
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#current_tickets"), options);
        chart.render();
      





//         var chart = c3.generate({
//           bindto: "#current_tickets",
//     data: {
//         columns: [
//             ['Very Satisfied - 31%', 31],
//             ['Satisfied - 40%', 40],
//             ['Nautral - 17%', 17],
//             ['Unsatisfied - 7%', 7],
//             ['Very Unsatisfied - 5%', 5],
//         ],
//         type : 'donut',
//         onclick: function (d, i) { console.log("onclick", d, i); },
//         onmouseover: function (d, i) { console.log("onmouseover", d, i); },
//         onmouseout: function (d, i) { console.log("onmouseout", d, i); }
//     },
//     legend: {
//         position: 'right'
//     },
//     donut: {
//         title: "70% Positive"
//     },  
// });

// setTimeout(function () {
//     chart.load({
//         columns: [
//             ["setosa", 0.2, 0.2, 0.2, 0.2, 0.2, 0.4, 0.3, 0.2, 0.2, 0.1, 0.2, 0.2, 0.1, 0.1, 0.2, 0.4, 0.4, 0.3, 0.3, 0.3, 0.2, 0.4, 0.2, 0.5, 0.2, 0.2, 0.4, 0.2, 0.2, 0.2, 0.2, 0.4, 0.1, 0.2, 0.2, 0.2, 0.2, 0.1, 0.2, 0.2, 0.3, 0.3, 0.2, 0.6, 0.4, 0.3, 0.2, 0.2, 0.2, 0.2],
//             ["versicolor", 1.4, 1.5, 1.5, 1.3, 1.5, 1.3, 1.6, 1.0, 1.3, 1.4, 1.0, 1.5, 1.0, 1.4, 1.3, 1.4, 1.5, 1.0, 1.5, 1.1, 1.8, 1.3, 1.5, 1.2, 1.3, 1.4, 1.4, 1.7, 1.5, 1.0, 1.1, 1.0, 1.2, 1.6, 1.5, 1.6, 1.5, 1.3, 1.3, 1.3, 1.2, 1.4, 1.2, 1.0, 1.3, 1.2, 1.3, 1.3, 1.1, 1.3],
//             ["virginica", 2.5, 1.9, 2.1, 1.8, 2.2, 2.1, 1.7, 1.8, 1.8, 2.5, 2.0, 1.9, 2.1, 2.0, 2.4, 2.3, 1.8, 2.2, 2.3, 1.5, 2.3, 2.0, 2.0, 1.8, 2.1, 1.8, 1.8, 1.8, 2.1, 1.6, 1.9, 2.0, 2.2, 1.5, 1.4, 2.3, 2.4, 1.8, 1.8, 2.1, 2.4, 2.3, 1.9, 2.3, 2.5, 2.3, 1.9, 2.0, 2.3, 1.8],
//         ]
//     });
// }, 1500);

// setTimeout(function () {
//     chart.unload({
//         ids: 'data1'
//     });
//     chart.unload({
//         ids: 'data2'
//     });
//     chart.unload({
//         ids: 'data3'
//     });
//     chart.unload({
//         ids: 'data4'
//     });
//     chart.unload({
//         ids: 'data5'
//     });
// }, 2500);



 var options = {
          series: [{
          name: 'Tickets',
          data: [0, 30, 5, 40, 20, 60, 20, 40, 10, 40, 20, 40, 20, 40]
        }],
          chart: {
          height: 334,
          type: 'area',
          toolbar: {
            show: false,
            },
            offsetY: 0,
        },
        colors: ['#7047ee'],
        fill: {
          colors:['#7047ee'],
          opacity: 0,
            type: 'solid',
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
        width: [3.5],
          curve: 'smooth'
        },
        grid: {
          show: true,
          padding: {
            left: 0,
            top: 0,
            right: 0,
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
            show: true
          },
          axisTicks: {
            show: true,
          },
          labels: {
            show: true,
            formatter: function (val) {
              return val + "%";
            }
          },
        },
        xaxis: {
          axisBorder: {
            show: true
          },
          axisTicks: {
            show: true,
          },
          labels: {
            show: true,
          },
        },
        };

        var chart = new ApexCharts(document.querySelector("#best_selling"), options);
        chart.render();



         var options = {
          series: [{
          name: 'Tickets',
          data: [0, 30, 5, 40, 20, 60, 20, 40, 10, 40, 20, 40, 20, 40]
        }],
          chart: {
          height: 80,
          width: 150,
          type: 'area',
          toolbar: {
            show: false,
            },
            offsetY: 10,
        },
        colors: ['#FF6C6C'],
        fill: {
          colors:['#FF6C6C'],
          opacity: 0,
            type: 'solid',
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
        width: [2],
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

        var chart = new ApexCharts(document.querySelector("#ticket-chart"), options);
        chart.render();


         var options = {
          series: [{
          name: 'Tickets',
          data: [0, 30, 5, 40, 20, 40, 20, 40, 10, 40, 20, 40, 20, 40]
        }],
          chart: {
          height: 80,
          width: 150,
          type: 'area',
          toolbar: {
            show: false,
            },
            offsetY: 10,
        },
        colors: ['#04a08b'],
        fill: {
          colors:['#04a08b'],
          opacity: 0,
            type: 'solid',
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
        width: [2],
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

        var chart = new ApexCharts(document.querySelector("#sales-chart"), options);
        chart.render();


        var options = {
          series: [{
          name: 'Tickets',
          data: [0, 30, 5, 30, 20, 10, 20, 40, 10, 60, 20, 40, 20, 40]
        }],
          chart: {
          height: 80,
          width: 150,
          type: 'area',
          toolbar: {
            show: false,
            },
            offsetY: 10,
        },
        colors: ['#FF6C6C'],
        fill: {
          colors:['#FF6C6C'],
          opacity: 0,
            type: 'solid',
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
        width: [2],
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

        var chart = new ApexCharts(document.querySelector("#sales-chart-2"), options);
        chart.render();








  var options = {
          series: [{
          name: 'Read',
          data: [80,50,30,40,100,20],
        }, {
          name: 'Delivery',
          data: [20,30,40,80,20,80],
        }, {
          name: 'Failed',
          data: [44,76,78,13,43,10],
        }],
          chart: {
          height: 360,
          type: 'radar',
          dropShadow: {
            enabled: true,
            blur: 1,
            left: 1,
            top: 1
          }
        },
        colors:['#3762EA', '#172b4c', '#FF6C6C'],
        stroke: {
          width: 2
        },
        fill: {
          opacity: 0.1
        },
        markers: {
          size: 0
        },
        xaxis: {
          categories: ['2018', '2019', '2020', '2021', '2022', '2023']
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart-56"), options);
        chart.render();


	
	    var options = {
          series: [{
          name: 'All Revenue',
          type: 'line',
          data: [49, 62, 55, 67, 73, 110, 120, 115, 129, 123, 133]
        }, {
          name: 'All Expenses',
          type: 'line',
          data: [62, 76, 67, 49, 63, 70, 37, 52, 44, 61, 43]
        }, {
          name: 'Profit',
          type: 'line',
          data: [12, 36, 29, 33, 37, 58, 37, 52, 44, 61, 43]
        }],
          chart: {
          	toolbar: { show: false,},
	          height: 250,
	          type: 'line',
        },

        stroke: {
        	 width: [2, 2, 2],
          curve: 'smooth'
        },
        fill: {
          type:'solid',
          opacity: [1, 1, 1],
        },
        labels: ['Jan', 'Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        markers: {
          size: 0
        },
        legend: {
      		show: false,
      	},
        colors:['#3762EA', '#b5b5c3', '#172b4c'],
        yaxis: [
          {
            title: {
              text: ' ',
            },
          },
          {
            opposite: true,
            title: {
              text: ' ',
            },
          },
        ],
        tooltip: {
          shared: true,
          intersect: false,
          y: {
            formatter: function (y) {
              if(typeof y !== "undefined") {
                return  y.toFixed(0) + " points";
              }
              return y;
            }
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#balance_overview"), options);
        chart.render();






 			var options = {
          series: [50, 80, 44],
          chart: {
          height: 338,
          type: 'radialBar',
        },
        plotOptions: {
          radialBar: {
            dataLabels: {
              name: {
                fontSize: '22px',
              },
              value: {
                fontSize: '16px',
              },
              total: {
                show: true,
                label: 'Total',
                formatter: function (w) {
                  // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                  return 249
                }
              }
            }
          }
        },
        labels: ['Send', 'Received', 'Failed'],
        };

        var chart = new ApexCharts(document.querySelector("#chart-redio"), options);
        chart.render();


        var options = {
          series: [{
          name: 'Activ User',
          data: [44, 55, 41, 67, 22, 43,50]
        }, {
          name: 'New Users',
          data: [13, 23, 20, 8, 13, 27,25]
        },],
          chart: {
          type: 'bar',
          height: 338,
          stacked: true,
          toolbar: {
            show: false
          },
          zoom: {
            enabled: false
          }
        },
        colors:['#3762EA', '#b5b5c3'],
        responsive: [{
          breakpoint: 480,
          options: {
            legend: {
              position: 'top',
              offsetX: -50,
              offsetY: 0
            }
          }
        }],
        plotOptions: {
          bar: {
            horizontal: false,
            borderRadius: 10,
            dataLabels: {
              total: {
                enabled: true,
                style: {
                  fontSize: '13px',
                  fontWeight: 100
                }
              }
            }
          },
        },
        xaxis: {
          categories: ["Jan","Feb","Mar","Apr","May","Jun","Jul"
          ],
        },
        legend: {
          position: 'bottom',
          offsetY: 5
        },
        fill: {
          opacity: 1
        }
        };

        var chart = new ApexCharts(document.querySelector("#activity-chart"), options);
        chart.render();



        var options = {
          series: [{
          name: 'Marine Sprite',
          data: [44, 55, 41, 37, 22, 43, 21]
        }, {
          name: 'Striking Calf',
          data: [53, 32, 33, 52, 13, 43, 32]
        }, {
          name: 'Tank Picture',
          data: [12, 17, 11, 9, 15, 11, 20]
        }, {
          name: 'Bucket Slope',
          data: [9, 7, 5, 8, 6, 9, 4]
        }],
          chart: {
          type: 'bar',
          height: 350,
          stacked: true,
          toolbar:{
          	show: false,
          }
        },
        colors:['#3762ea', '#3762ead9', '#3762ea99', '#3762ea80'],
        plotOptions: {
          bar: {
            horizontal: true,
            dataLabels: {
              total: {
                enabled: false,
                offsetX: 10,
                style: {
                  fontSize: '13px',
                  fontWeight: 900
                }
              }
            }
          },
        },
        stroke: {
          width: 1,
          colors: ['#fff']
        },
        
        xaxis: {
          categories: ["Jan","Feb","Mar","Apr","May","Jun","Jul"],
          labels: {
            formatter: function (val) {
              return val + ""
            }
          }
        },
        yaxis: {
          title: {
            text: undefined
          },
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val + "K"
            }
          }
        },
        fill: {
          opacity: 1
        },
        legend: {
        	show: false,
          position: 'top',
          horizontalAlign: 'left',
          offsetX: 40
        }
        };

        var chart = new ApexCharts(document.querySelector("#status-chart"), options);
        chart.render();



        $('.scroll').slimScroll({
			    height: 'auto'
			  });

	
	
	
	
		var options = {
          series: [9, 5, 13],
			labels: ['Prog..', 'Comp..', 'Ye to'],
          chart: {
          height:230,
          type: 'donut',
        },
        dataLabels: {
          enabled: false
        },
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              show: false
            }
          }
        }],
		colors:['#04a08b', '#6993ff', '#F6B749'],
        legend: {
          position: 'bottom',
      	  horizontalAlign: 'center',
        }
        };

        var chart = new ApexCharts(document.querySelector("#charts_widget_2_chart"), options);
        chart.render();
	
	
		var options = {
		  chart: {
			height: 180,
			type: "radialBar"
		  },

		  series: [77],
			colors: ['#3762EA'],
		  plotOptions: {
			radialBar: {
			  hollow: {
				margin: 15,
				size: "70%"
			  },
			  track: {
				background: '#F6B749',
			  },

			  dataLabels: {
				showOn: "always",
				name: {
				  offsetY: -10,
				  show: false,
				  color: "#888",
				  fontSize: "13px"
				},
				value: {
				  color: "#111",
				  fontSize: "30px",
				  show: true
				}
			  }
			}
		  },

		  stroke: {
			lineCap: "round",
		  },
		  labels: ["Progress"]
		};

		var chart = new ApexCharts(document.querySelector("#revenue5"), options);

		chart.render();

	
}); // End of use strict




