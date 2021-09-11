<template>
  <div class="bg-white rounded-lg shadow">

    <!-- Heading -->
    <div class="pt-4 pl-4 text-xs text-gray-600">{{ $t('dashboard.widgets.statistics') }}</div>

    <!-- Chart -->
    <div v-if="chart">
      <apexchart type="area" height="350" :options="chart.options" :series="chart.series"/>
    </div>

    <!-- Skeleton -->
    <div v-else class="p-6 db-height-m">
      <div v-for="n in 9" :key="n" class="flex items-center mb-5.5">
        <div class="mr-6 w-8 bone thin"></div>
        <div class="flex-grow bone line"></div>
      </div>
      <div class="flex justify-around pb-3">
        <div v-for="n in $screen.lg ? 16 : 6" :key="n" class="w-7 bone thin"></div>
      </div>
    </div>

  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import VueApexCharts from 'vue-apexcharts';

export default {
  name: 'DashboardStatistics',

  data() {
    return {};
  },

  computed: {
    ...mapGetters('Dashboard', ['statistics']),

    chart() {
      if (Object.keys(this.statistics).length) {
        return {
          series: [
            {
              name: this.$t('dashboard.sessions'),
              data: _.map(this.statistics.series, 'sessions'),
            },
            {
              name: this.$t('dashboard.page_views'),
              data: _.map(this.statistics.series, 'pageviews'),
            },
          ],
          options: {
            chart: {
              toolbar: {
                show: false,
              },
              zoom: {
                enabled: false,
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
                  speed: 250,
                },
              },
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
                right: 0,
              },
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
              },
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
              enabled: false,
            },
            fill: {
              type: 'gradient',
              gradient: {
                type: 'vertical',
                shadeIntensity: 1,
                inverseColors: !1,
                opacityFrom: 0.45,
                opacityTo: 0.05,
                stops: [45, 100],
              },
            },
            tooltip: {
              style: {
                fontSize: '12px',
                fontFamily: 'Muli',
              },
              y: {
                formatter(value) {
                  return new Intl.NumberFormat().format(value);
                },
              },
            },
            legend: {
              position: 'top',
              horizontalAlign: 'right',
              floating: true,
              fontFamily: 'Muli',
              offsetY: 0,
              offsetX: 0,
              labels: {
                colors: '#718096',
              },
              itemMargin: {
                horizontal: 0,
                vertical: 0,
              },
            },
            responsive: [
              {
                breakpoint: 1280,
                options: {
                  xaxis: {
                    tickAmount: 10,
                  },
                },
              },
              {
                breakpoint: 767,
                options: {
                  xaxis: {
                    tickAmount: 5,
                  },
                },
              },
              {
                breakpoint: 440,
                options: {
                  xaxis: {
                    tickAmount: 3,
                  },
                },
              },
            ],
          },
        };
      }

      return false;
    },
  },

  methods: {
    ...mapActions('Dashboard', ['fetchStatistics']),
  },

  created() {
    if (!Object.keys(this.statistics).length) {
      this.fetchStatistics();
    }
  },

  components: {
    apexchart: VueApexCharts,
  },
};
</script>
