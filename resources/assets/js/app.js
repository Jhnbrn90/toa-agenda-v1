/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
var Chart = require('chart.js');

Vue.component('bargraph', {
    props: ['labels', 'values', 'color', 'xlabel', 'ylabel'],
    template: '<canvas width="200" height="75"></canvas>',
    mounted: function() {
        new Chart(this.$el, {
            type: 'bar',
            // The data for our dataset
            data: {
                labels: this.labels,
                datasets: [{
                    label: "Taken",
                    backgroundColor: this.color,
                    borderColor: this.color,
                    data: this.values,
                }]
            },
            options: {
              scales: {
                    yAxes: [{
                      ticks: {
                        stepSize: 1
                      },
                      scaleLabel: {
                        display: true,
                        labelString: this.ylabel
                      }
                    }],
                    xAxes: [{
                      scaleLabel: {
                        display: true,
                        labelString: this.xlabel
                      }
                    }]
                  },
              legend: {
                display: false
              }
            }
        });

    }
});

new Vue({
  el: '#day',
  data: {
    values: '',
    color: 'rgb(255, 99, 132)',
    labels: '',
    xlabel: '',
    ylabel: ''
  }
});

new Vue({
  el: '#week',
  data: {
    values: '',
    color: 'orange',
    labels: '',
    xlabel: '',
    ylabel: ''
  }
});
