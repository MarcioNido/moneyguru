import { Line } from 'vue-chartjs';

export default {

    extends: Line,

    mounted() {

        axios.get('/api/v1/charts/patrimony')
            .then(response => {
                this.renderIt(response.data.labels, response.data.values)
            })
            .catch(response => {
                console.log('there was a problem ...');
            })

    },

    methods: {

        renderIt(labels, values) {

            this.renderChart({
                labels: labels,
                datasets: [
                    {
                        label: 'Patrimony',
                        backgroundColor: 'rgba(63, 127, 191, 0.5)',
                        data: values
                    },

                ]
            }, {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            });

        }

    }


}
