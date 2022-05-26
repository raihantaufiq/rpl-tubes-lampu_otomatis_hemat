/* globals Chart:false, feather:false */

(function () {
  'use strict'

  feather.replace({ 'aria-hidden': 'true' })

  // Graphs
  var ctx = document.getElementById('myChart')

  var arr_labels = []
  var arr_data = []

  var label= document.getElementsByName("chart_label")
  var nilai= document.getElementsByName("chart_value")
  for (let i = 0; i < label.length; i++) {
      arr_labels.push(label[i].textContent)
      arr_data.push(nilai[i].textContent)
  }
  document.getElementById("temp").remove();
  // eslint-disable-next-line no-unused-vars
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: arr_labels,
      datasets: [{
        data: arr_data,
        lineTension: 0,
        backgroundColor: '#7c3aed',
        // borderColor: '#007bff',
        borderWidth: 2,
        pointBackgroundColor: '#7c3aed'
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
          ,
          // scaleLabel: {
          //   display: true,
          //   labelString: 'Penggunaan Listrik (kWh)'
          // }
          // ,
        }]
        ,
        xAxes: [{
          // scaleLabel: {
          //   display: true,
          //   labelString: 'Waktu (jam)'
          // }
        }]
      },
      legend: {
        display: false
      }
    }
  })
})()
