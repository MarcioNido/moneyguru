<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <form action="#" @submit.prevent="filter">

                            <div class="row">

                                <div class="form-group col-md-3">
                                    <label class="control-label" for="date">Bank Account</label>

                                    <select v-model="filterBankAccountId" class="form-control" @change="filterChange">
                                       <option v-for="(bankAccount, index) in bankAccountsList" v-bind:value="bankAccount.id">
                                            {{ bankAccount.name }}
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="control-label" for="filterMonth">Month</label>

                                    <select v-model="filterMonth" id="filterMonth" class="form-control" @change="filterChange">
                                        <option v-for="(month, index) in monthList" v-bind:value="index">
                                            {{ month }}
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="control-label" for="filterYear">Year</label>

                                    <select v-model="filterYear" id="filterYear" class="form-control" @change="filterChange">
                                        <option v-for="(year, index) in yearList" v-bind:value="index">
                                            {{ year }}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-5" style="text-align: right;">
                                    <div style="margin-bottom: 5px;">Page {{ form.page }} / {{ form.lastPage }}</div>
                                    <button class="btn btn-primary"
                                            href="#" @click.prevent="form.create">
                                        New Entry
                                    </button>
                                </div>

                            </div>

                        </form>

                    </div>

                    <div class="panel-body">
                        <div class="row list-row"
                             :class="form.deleteIndex == index ? ' list-row-delete' : ''"
                             v-for="(collection, index) in form.collection">

                            <div class="col-md-1">
                                {{ collection.date | day }}
                            </div>
                            <div class="col-md-3">
                                {{ collection.category.name }}
                            </div>
                            <div class="col-md-3">
                                {{ collection.description }}
                            </div>
                            <div class="col-md-1">
                                {{ collection.dc }}
                            </div>
                            <div class="col-md-2" style="text-align: right;">
                                {{ collection.amount | currency }}
                            </div>
                            <div class="col-md-2" style="text-align: right;">

                                <button class="btn btn-primary"
                                        href="#" @click.prevent="edit(index)">
                                    Edit
                                </button>

                                <button class="btn btn-default"
                                        href="#" @click.prevent="form.deleteRow(index)">
                                    Delete
                                </button>

                            </div>
                        </div>

                        <div class="row edit-row" v-show="form.editMode == false && form.deleteMode == false">
                            <div class="col-md-8" style="text-align: right;">
                                <h5>Initial Balance</h5>
                                <h5>Final Balance</h5>
                            </div>
                            <div class="col-md-2" style="text-align: right">
                                <h5>{{ startBalance | currency }}</h5>
                                <h5>{{ endBalance | currency }}</h5>
                            </div>
                        </div>



                        <!-- edit form begin -->
                        <form action="#" v-show="form.editMode" @submit.prevent="save">
                            <div class="row edit-row">

                                <div class="form-group col-md-2" :class="form.errors.has('date') ? 'has-error' : ''">
                                    <label class="control-label" for="day">Day</label>
                                    <input id="day" type="text" class="form-control" v-model="form.fields.day">

                                    <span v-show="form.errors.has('date')"
                                          class="alert-danger"
                                          v-text="form.errors.get('date')">
                                    </span>

                                </div>

                                <div class="form-group col-md-3" :class="form.errors.has('category_id') ? 'has-error' : ''">
                                    <label class="control-label" for="category_id">Category</label>

                                    <select v-model="form.fields.category_id" class="form-control" id="category_id">
                                        <optgroup v-for="(group, groupKey) in categoriesList" :label="groupKey">
                                            <option v-for="(category, key) in group" :value="key">{{ category }}</option>
                                        </optgroup>
                                    </select>

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
                        <form action="#" v-show="form.deleteMode" @submit.prevent="confirmDelete">
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
                form:           new Form(),
                startDate:      moment().startOf('month').format('YYYY-MM-DD'),
                endDate:        moment().endOf('month').format('YYYY-MM-DD'),
                startBalance:   null,
                endBalance:     null,

                bankAccountsList: null,
                categoriesList: null,
                monthList:      null,
                yearList:       null,

                filterBankAccountId: 1,
                filterMonth:    moment().format('MM'),
                filterYear:     moment().format('YYYY'),
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
                day:null,
            };

            this.bankAccountId = 1;
            this.filterChange();
            this.initialBalance();
            this.finalBalance();

//            window.addEventListener('keyup', this.navigate);

            this.loadBankAccountsList();
            this.loadCategoriesList();
            this.loadMonthList();
            this.loadYearList();

        },

        methods: {
//
//            navigate: function (event) {
//                console.log('Key Pressed: ' + event.key);
//
//                if (this.form.editMode == false) {
//                    if (event.key == 'PageDown') {
//                        this.form.nextPage();
//                    }
//
//                    if (event.key == 'PageUp') {
//                        this.form.prevPage();
//                    }
//                }
//
//            },

            edit(index)
            {
                this.form.cancel();

                this.form.editMode = true;
                this.form.editIndex = index;

                var _self = this;
                Object.keys(this.form.fields).map(function(key) {
                    _self.form.fields[key] = _self.form.collection[index][key];
                })

                this.form.fields.day = moment(this.form.fields.date).format('DD');

            },


            save() {

                // append month and year to the date
                this.form.fields.date = this.filterYear + '-' + this.filterMonth + '-' + this.form.fields.day;
                this.form.fields.bank_account_id = this.filterBankAccountId;

                if (this.form.editIndex !== null) { // update

                    axios.put(this.form.resource + '/' + this.form.fields[this.form.key], this.form.fields)
                        .then(response => {
                            this.form.editMode = false;
                            this.form.collection[this.form.editIndex] = response.data;
                            this.finalBalance();
                        })
                        .catch(error => {
                            this.form.errors.set(error.response.data);
                        });

                } else { // create

                    axios.post(this.form.resource, this.form.fields)
                        .then(response => {
                            this.form.collection.push(response.data);
                            this.form.editMode = false;
                            this.finalBalance();
                        })
                        .catch(error => {
                            this.form.errors.set(error.response.data);
                        });

                }


            },

            initialBalance()
            {
                console.log('initial balance: ' + this.startDate);

                var date = moment(this.startDate).subtract(1, 'days').format('YYYY-MM-DD');
                console.log('balance initial date: ' + date);
                this.balance(date)
                    .then(data => {
                        console.log(data);
                        this.startBalance = data[0].balance;
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },

            finalBalance()
            {
                console.log('final balance: ' + this.endDate);
                this.balance(this.endDate)
                    .then(data => {
                        this.endBalance = data[0].balance;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },

            balance(date)
            {
                return new Promise((resolve, reject) => {
                    axios.get('api/v1/balances', {
                        params: {
                            filter: {
                                bank_account_id: this.filterBankAccountId,
                                date: date,
                            }
                        }
                    }).then(response => {
                        resolve(response.data);
                    }).catch(error => {
                        reject(error.response.data);
                    });
                });
            },


            loadBankAccountsList()
            {
                axios.get('api/v1/bank-accounts')
                    .then(response => {
                        this.bankAccountsList = response.data.data
                    })
                    .catch(error => {
                        console.log(error.response.data);
                    });
            },

            loadCategoriesList()
            {
                axios.get('api/v1/categories/dropdown')
                    .then(response => {
                        this.categoriesList = response.data.data;
                    })
                    .catch(error => {
                        console.log(error.response.data);
                    });
            },

            loadMonthList()
            {
                this.monthList = {
                    '01': 'January',
                    '02': 'February',
                    '03': 'March',
                    '04': 'April',
                    '05': 'May',
                    '06': 'June',
                    '07': 'July',
                    '08': 'August',
                    '09': 'September',
                    '10': 'October',
                    '11': 'November',
                    '12': 'December',
                }
            },

            loadYearList()
            {
                this.yearList = {
                    2017: 2017,
                    2018: 2018,
                    2019: 2019,
                    2020: 2020,
                    2021: 2021,
                    2022: 2022,
                }
            },

            filterChange()
            {
                this.form.filter = {
                    'bank_account_id': this.filterBankAccountId,
                    'start_date': moment(this.filterYear + '-' + this.filterMonth).startOf('month').format('YYYY-MM-DD'),
                    'end_date': moment(this.filterYear + '-' + this.filterMonth).endOf('month').format('YYYY-MM-DD'),
                };
                this.form.page = 1;
                this.form.list();
                this.initialBalance();
                this.finalBalance();
            },



            confirmDelete()
            {
                axios.delete(this.form.resource + '/' + this.form.fields[this.form.key])
                    .then(response => {
                        this.form.collection.splice(this.form.deleteIndex, 1);
                        this.form.cancel();
                        this.finalBalance();
                    })
                    .catch(error => {
                        console.log(error.response.data);
                    });
            }



        },

        filters: {

            day: function(value) {
                return moment(value).format('DD');
            },

            currency: function(value) {
                return new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(value);
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
    .btn {
        padding: 1px 12px;
    }
</style>