<template>
  <div class="bg-white shadow rounded-lg">
    <div class="pt-4 pl-4 text-xs text-gray-600">{{ $t('dashboard.widgets.statistics') }}</div>
    <div v-if="chart">
      <apexchart type="area" height="350" :options="chart.options" :series="chart.series"/>
    </div>
    <div v-else class="p-6 db-height-m">
      <div v-for="n in 9" class="flex items-center mb-5.5">
        <div class="bone thin w-8 mr-6"></div>
        <div class="bone line flex-grow"></div>
      </div>
      <div class="flex justify-around pb-3">
        <div v-for="n in $screen.lg ? 16 : 6" class="bone thin w-7"></div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import VueApexCharts from 'vue-apexcharts'

export default {
  name: 'DashboardStatistics',

  data() {
    return {}
  },

  computed: {
    ...mapGetters('Dashboard', ['statistics']),

    chart: function () {
      if(_.isEmpty(this.statistics)) {
        return false
      } else {
        return {
          series: [
            {
              name: this.$t('dashboard.sessions'),
              data: _.map(this.statistics.series, 'sessions')
            },
            {
              name: this.$t('dashboard.page_views'),
              data: _.map(this.statistics.series, 'pageviews')
            }
          ],
          options: {
            chart: {
              toolbar: {
                show: false
              },
              zoom: {
                enabled: false
              },
              animations: {
                enabled: true,
                easing: 'easeout',
                speed: 400,
                animateGradually: {
                  enabled: false,
                },
                dynamicAnimation: {
                  enabled: true,
                  speed: 250
                }
              }
            },
            colors: ['#23D092', '#3283FD'],
            stroke: {
              curve: 'smooth',
              lineCap: 'round',
            },
            grid: {
              borderColor: '#EDF2F7',
              padding: {
                left: 15,
                right: 0
              }
            },
            xaxis: {
              categories: this.statistics.labels,
              tickAmount: 15,
              labels: {
                rotate: 0,
                style: {
                  colors: '#718096',
                  fontSize: '11px',
                  fontFamily: 'Muli',
                },
              },
              axisBorder: {
                show: false,
              },
              axisTicks: {
                show: false,
              },
              tooltip: {
                enabled: false,
              }
            },
            yaxis: {
              tickAmount: 8,
              labels: {
                style: {
                  colors: '#718096',
                  fontSize: '11px',
                  fontFamily: 'Muli',
                },
              },
            },
            dataLabels: {
              enabled: false
            },
            fill: {
              type: "gradient",
              gradient: {
                type: "vertical",
                shadeIntensity: 1,
                inverseColors: !1,
                opacityFrom: .45,
                opacityTo: .05,
                stops: [45, 100]
              }
            },
            tooltip: {
              style: {
                fontSize: '12px',
                fontFamily: 'Muli'
              },
              y: {
                formatter: function (value) {
                  return new Intl.NumberFormat().format(value)
                }
              },
            },
            legend: {
              position: 'top',
              horizontalAlign: 'right',
              floating: true,
              fontFamily: 'Muli',
              offsetY: -17,
              offsetX: 0,
              labels: {
                colors: '#718096',
              },
              itemMargin: {
                horizontal: 0,
                vertical: 0
              }
            },
            responsive: [
              {
                breakpoint: 1280,
                options: {
                  xaxis: {
                    tickAmount: 10,
                  },
                }
              },
              {
                breakpoint: 767,
                options: {
                  xaxis: {
                    tickAmount: 5,
                  },
                }
              },
              {
                breakpoint: 440,
                options: {
                  xaxis: {
                    tickAmount: 3,
                  },
                }
              },
            ]
          }
        }
      }
    }
  },

  methods: {
    ...mapActions('Dashboard', ['fetchStatistics']),
  },

  created() {
    if(_.isEmpty(this.statistics)) {
      this.fetchStatistics()
    }
  },

  components: {
    apexchart: VueApexCharts,
  }
}
</script>
