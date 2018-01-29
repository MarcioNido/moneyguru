<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <div class="row">
                            <div class="col-md-9">
                                <h5>Finances</h5>
                            </div>
                            <div class="col-md-3" style="text-align: right;">
                                <button class="btn btn-primary"
                                        href="#" @click.prevent="form.create">
                                    New Entry
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row list-row"
                             :class="form.deleteIndex == index ? ' list-row-delete' : ''"
                             v-for="(collection, index) in form.collection">

                            <div class="col-md-2">
                                {{ collection.date }}
                            </div>
                            <div class="col-md-2">
                                {{ collection.category.name }}
                            </div>
                            <div class="col-md-3">
                                {{ collection.description }}
                            </div>
                            <div class="col-md-1">
                                {{ collection.dc }}
                            </div>
                            <div class="col-md-2">
                                {{ collection.amount }}
                            </div>
                            <div class="col-md-2" style="text-align: right;">

                                <button class="btn btn-primary"
                                        href="#" @click.prevent="form.edit(index)">
                                    Edit
                                </button>

                                <button class="btn btn-default"
                                        href="#" @click.prevent="form.deleteRow(index)">
                                    Delete
                                </button>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12" style="text-align: center">
                                <span>Page {{ form.currentPage }} / {{ form.lastPage }}</span>
                            </div>
                        </div>


                        <div class="row edit-row" v-show="form.editMode == false && form.deleteMode == false">
                            <div class="col-md-8">
                                <h5>Initial Balance on {{ this.startDate }}: </h5>
                                <h5>Final Balance on {{ this.endDate }}:</h5>
                            </div>
                            <div class="col-md-4">
                                <h5>{{ this.startBalance }}</h5>
                                <h5>{{ this.endBalance }}</h5>
                            </div>
                        </div>



                        <!-- edit form begin -->
                        <form action="#" v-show="form.editMode" @submit.prevent="save">
                            <div class="row edit-row">

                                <div class="form-group col-md-2" :class="form.errors.has('date') ? 'has-error' : ''">
                                    <label class="control-label" for="date">Date</label>
                                    <input id="date" type="text" class="form-control" v-model="form.fields.date">

                                    <span v-show="form.errors.has('date')"
                                          class="alert-danger"
                                          v-text="form.errors.get('date')">
                                    </span>

                                </div>

                                <div class="form-group col-md-3" :class="form.errors.has('category_id') ? 'has-error' : ''">
                                    <label class="control-label" for="category_id">Category</label>
                                    <input id="category_id" type="text" class="form-control" v-model="form.fields.category_id">

                                    <span v-show="form.errors.has('category_id')"
                                          class="alert-danger"
                                          v-text="form.errors.get('category_id')">
                                    </span>

                                </div>

                                <div class="form-group col-md-4" :class="form.errors.has('description') ? 'has-error' : ''">
                                    <label class="control-label" for="description">Description</label>
                                    <input id="description" type="text" class="form-control" v-model="form.fields.description">

                                    <span v-show="form.errors.has('description')"
                                          class="alert-danger"
                                          v-text="form.errors.get('description')">
                                    </span>

                                </div>

                                <div class="form-group col-md-1" :class="form.errors.has('dc') ? 'has-error' : ''">
                                    <label class="control-label" for="dc">D/C</label>
                                    <input id="dc" type="text" class="form-control" v-model="form.fields.dc">

                                    <span v-show="form.errors.has('dc')"
                                          class="alert-danger"
                                          v-text="form.errors.get('dc')">
                                    </span>

                                </div>

                                <div class="form-group col-md-2" :class="form.errors.has('amount') ? 'has-error' : ''">
                                    <label class="control-label" for="amount">Amount</label>
                                    <input id="amount" type="text" class="form-control" v-model="form.fields.amount">

                                    <span v-show="form.errors.has('amount')"
                                          class="alert-danger"
                                          v-text="form.errors.get('amount')">
                                    </span>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <button class="btn btn-primary" type="submit">Save</button>
                                    <button class="btn btn-default" @click.prevent="form.cancel">Cancel</button>
                                </div>
                            </div>
                        </form>
                        <!-- edit form end -->

                        <!-- delete form begin -->
<!--
                        <form action="#" v-show="form.deleteMode" @submit.prevent="form.confirmDelete">
                            <div class="row edit-row">
                                <div class="col-md-9">
                                    <h5 style="color: #bf5329;">
                                        Are you sure you want to delete the selected item?
                                    </h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <button class="btn btn-danger" type="submit">Confirm</button>
                                    <button class="btn btn-default" @click.prevent="form.cancel">Cancel</button>
                                </div>
                            </div>
                        </form>
                        <!-- delete form end -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import Form from '../form';

    export default {

        data() {
            return {
                form: new Form(),
                startDate: moment().startOf('month').format('YYYY-MM-DD'),
                startBalance: null,
                endDate: moment().endOf('month').format('YYYY-MM-DD'),
                endBalance: null,
            };
        },

        created() {

            this.form.resource = "/api/v1/finances";
            this.form.key = 'id';
            this.form.fields = {
                id: null,
                bank_account_id: 1,
                category_id: null,
                description: null,
                dc: null,
                date: null,
                amount: null,
            };

            this.bankAccountId = 1;

            this.form.list();

            this.balance();

            window.addEventListener('keyup', this.navigate);

        },

        methods: {

            navigate: function (event) {
                console.log('Key Pressed: ' + event.key);

                if (this.form.editMode == false) {
                    if (event.key == 'PageDown') {
                        if (this.form.currentPage < this.form.lastPage) {
                            this.form.nextPage();
                        } else {
                            window.alert('Last Page');
                        }
                    }

                    if (event.key == 'PageUp') {
                        if (this.form.currentPage > 1) {
                            this.form.prevPage();
                        } else {
                            window.alert('First Page');
                        }
                    }
                }

            },

            save() {

                if (this.form.editIndex !== null) { // update

                    axios.put(this.form.resource + '/' + this.form.fields[this.form.key], this.form.fields)
                        .then(response => {
                            this.form.editMode = false;
                            this.form.collection[this.form.editIndex] = response.data;
                        })
                        .catch(error => {
                            this.form.errors.set(error.response.data);
                        });

                } else { // create

                    axios.post(this.form.resource, this.form.fields)
                        .then(response => {
                            this.form.collection.push(response.data);
                            this.form.editMode = false;
                        })
                        .catch(error => {
                            this.form.errors.set(error.response.data);
                        });

                }
            },


            balance()
            {

                var self = this;
                axios.get('api/v1/balances', {
                    params: {
                        filter: {
                            bank_account_id: self.bankAccountId,
                            date: moment(self.startDate).subtract(1, 'days').format('YYYY-MM-DD'),
                        }
                    }
                }).then(response => {
                    console.log(response);
                });

            }

        }

    }
</script>

<style>
    div.list-row {
        padding: 5px;
    }
    div.edit-row {
        padding: 15px 5px 0;
        border-top: 1px solid #d3e0e9;
    }
    div.list-row:hover {
        background-color: #f7f7f7;
    }
    div.list-row.list-row-delete {
        color: #bf5329;
    }
</style>