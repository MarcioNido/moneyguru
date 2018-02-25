<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Monthly Revenue X Expenses</div>

                    <div class="panel-body">
                        <chart-rev-exp></chart-rev-exp>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Revenue by Category Last Month</div>

                    <div class="panel-body">
                        <chart-rev-category></chart-rev-category>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Expenses by Category Last Month</div>

                    <div class="panel-body">
                        <chart-exp-category></chart-exp-category>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Monthly Patrimony</div>

                    <div class="panel-body">
                        <chart-patrimony></chart-patrimony>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import ChartRevExp from '../ChartRevExp';
    import ChartRevCategory from '../ChartRevCategory';
    import ChartExpCategory from '../ChartExpCategory';
    import ChartPatrimony from '../ChartPatrimony';

    export default {

        components: { ChartRevExp, ChartRevCategory, ChartExpCategory, ChartPatrimony },

        mounted() {
            console.log('Home Component alright  .');
        }
    }
</script>