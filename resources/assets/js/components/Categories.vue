<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <div class="row">
                            <div class="col-md-9">
                                <h5>Categories (Chart of Accounts)</h5>
                            </div>
                            <div class="col-md-3" style="text-align: right;">
                                <button class="btn btn-primary" href="#" @click.prevent="form.create">New Category</button>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row list-row" :class="form.deleteIndex == index ? ' list-row-delete' : ''" v-for="(collection, index) in form.collection">
                            <div class="col-md-2">
                                {{ collection.level1 }} . {{ collection.level2 }} . {{ collection.level3 }}
                            </div>
                            <div class="col-md-7">
                                {{ collection.name }}
                            </div>
                            <div class="col-md-3" style="text-align: right;">

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

                        <form action="#" v-show="form.editMode" @submit.prevent="form.save">
                            <div class="row edit-row">

                                <div class="form-group col-md-1" :class="form.errors.has('level1') ? 'has-error' : ''">
                                    <label class="control-label" for="name">Lev.1</label>
                                    <input id="level1" type="text" class="form-control" v-model="form.fields.level1">

                                    <span v-show="form.errors.has('level1')"
                                          class="alert-danger"
                                          v-text="form.errors.get('level1')">
                                    </span>

                                </div>

                                <div class="form-group col-md-1" :class="form.errors.has('level2') ? 'has-error' : ''">
                                    <label class="control-label" for="name">Lev.2</label>
                                    <input id="level2" type="text" class="form-control" v-model="form.fields.level2">

                                    <span v-show="form.errors.has('level2')"
                                          class="alert-danger"
                                          v-text="form.errors.get('level2')">
                                    </span>

                                </div>

                                <div class="form-group col-md-1" :class="form.errors.has('level3') ? 'has-error' : ''">
                                    <label class="control-label" for="name">Lev.3</label>
                                    <input id="level3" type="text" class="form-control" v-model="form.fields.level3">

                                    <span v-show="form.errors.has('level3')"
                                          class="alert-danger"
                                          v-text="form.errors.get('level3')">
                                    </span>

                                </div>


                                <div class="form-group col-md-9" :class="form.errors.has('name') ? 'has-error' : ''">
                                    <label class="control-label" for="name">Name</label>
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

            this.form.resource = "/api/v1/categories";
            this.form.key = 'id';
            this.form.fields = {
                id: null,
                level1: "",
                level2: "",
                level3: "",
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