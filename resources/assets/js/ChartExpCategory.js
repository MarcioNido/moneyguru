import { Pie } from 'vue-chartjs';

export default {

    extends: Pie,

    mounted() {

        axios.get('/api/v1/charts/expCategory')
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
                            'rgba(178, 153, 76, 0.5)',
                            'rgba(123, 43, 71, 0.5)',
                            'rgba(57, 101, 49, 0.5)',
                            'rgba(41, 155, 12, 0.5)',
                            'rgba(90, 13, 176, 0.5)',
                            'rgba(121, 153, 123, 0.5)',
                        ],
                        data: values
                    },

                ]
            });

        },

    }


}
