
<script>
import { Line } from 'vue-chartjs'

export default {
  extends: Line,
  props: {
    chartdata: {
      type: Object,
      default: null
    },
     chartLabels: {
   type: Array,
   required: true
 },

  },
  mounted () {
    this.renderChart(this.chartdata, this.options)
  }
}
</script>


