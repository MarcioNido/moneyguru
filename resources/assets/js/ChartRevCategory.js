import { Pie } from 'vue-chartjs';

export default {

    extends: Pie,

    mounted() {

        axios.get('/api/v1/charts/revCategory')
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
                        backgroundColor: [
                            'rgba(63, 127, 191, 0.5)',
                            'rgba(193, 66, 66, 0.5)',
                            'rgba(93, 191, 63, 0.5)',
                            'rgba(93, 191, 63, 0.5)',
                        ],
                        data: values
                    },

                ]
            });

        }

    }


}
