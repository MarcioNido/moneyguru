import { Bar } from 'vue-chartjs'

export default {
    extends: Bar,

    mounted () {
        this.renderChart({
            labels: ['Jan', 'Feb'],
            datasets: [
                {
                    label: 'Test',
                    data: [1000, 2000]
                }
            ]
        })
    }
}