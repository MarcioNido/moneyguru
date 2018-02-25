import { HorizontalBar } from 'vue-chartjs';

export default {

    extends: HorizontalBar,

    mounted() {

        axios.get('/api/v1/charts/revExp')
            .then(response => {
                this.renderIt(response.data.labels, response.data.rev, response.data.exp)
            })
            .catch(response => {
                console.log('there was a problem ...');
            })

    },

    methods: {

        renderIt(labels, rev, exp) {

            this.renderChart({
                labels: labels,
                datasets: [
                    {
                        label: 'Revenue',
                        backgroundColor: 'rgba(63, 127, 191, 0.5)',
                        data: rev
                    },

                    {
                        label: 'Expenses',
                        backgroundColor: 'rgba(193, 66, 66, 0.5)',
                        data: exp
                    }
                ]
            }, {
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            });

        }

    }


}
