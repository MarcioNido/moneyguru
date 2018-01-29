<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <div class="row">
                            <div class="col-md-9">
                                <h5>Bank Accounts</h5>
                            </div>
                            <div class="col-md-3" style="text-align: right;">
                                <button class="btn btn-primary" href="#" @click.prevent="form.create">New Account</button>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row list-row" :class="form.deleteIndex == index ? ' list-row-delete' : ''" v-for="(collection, index) in form.collection">
                            <div class="col-md-9">
                                {{ collection.name }}
                            </div>
                            <div class="col-md-3" style="text-align: right;">
                                <button class="btn btn-primary" href="#" @click.prevent="form.edit(index)">Edit</button>
                                <button class="btn btn-default" href="#" @click.prevent="form.deleteRow(index)">Delete</button>
                            </div>
                        </div>

                        <form action="#" v-show="form.editMode" @submit.prevent="form.save">
                            <div class="row edit-row">
                                <div class="form-group col-md-9" :class="form.errors.has('name') ? 'has-error' : ''">
                                    <label class="control-label" for="name">Bank Account Name</label>
                                    <input id="name" type="text" class="form-control" v-model="form.fields.name">

                                    <span v-show="form.errors.has('name')"
                                          class="alert-danger"
                                          v-text="form.errors.get('name')">
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

                        <!-- delete form begin -->
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
            };
        },

        created() {

            this.form.resource = "/api/v1/bank-accounts";
            this.form.key = 'id';
            this.form.fields = {
                id: null,
                name: "",
            };

            this.form.list();

        },

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
    div.list-row.list-row-delete {
        color: #bf5329;
    }
</style>