import FormError from './form-error';

class Form {

    constructor()
    {
        this.editMode = false;
        this.editIndex = null;
        this.deleteMode = false;
        this.deleteIndex = null;

        this.collection = null;
        this.fields = null;
        this.resource = null;
        this.key = null;

        this.page = 1;
        this.filter = {};
        this.lastPage = null;

        this.errors = new FormError();

        window.addEventListener('keyup', this.navigate);

        window.form = this;
    }

    /**
     * @todo check how will work pagination here
     * @param page
     */
    list()
    {
        var params = {};

        params.page = this.page;
        params.filter = this.filter;

        axios.get(this.resource, {params: params})
            .then(response => {
                this.collection = response.data.data;
                this.page = response.data.current_page;
                this.lastPage = response.data.last_page;
            })

    }

    navigate(event) {

        console.log('Key Pressed: ' + event.key);
        console.log('I am here ...');

        if (window.form.editMode == false) {
            if (event.key == 'PageDown') {
                window.form.nextPage();
            }

            if (event.key == 'PageUp') {
                window.form.prevPage();
            }
        } else {
            console.log('Edit mode is true? ' + window.form.editMode);
        }

    }

    nextPage()
    {
        if (this.page < this.lastPage) {

            this.page = this.page + 1;
            this.list();

        } else {
            window.alert('Last Page');
        }
    }

    prevPage()
    {
        if (this.page > 1) {

            this.page = this.page - 1;
            this.list();

        } else {
            window.alert('First Page');
        }
    }


    create()
    {

        this.cancel();

        this.editMode = true;
        this.editIndex = null;

        var _self = this;

        Object.keys(this.fields).map(function(key) {
            _self.fields[key] = "";
        });

    }

    edit(index)
    {
        this.cancel();

        this.editMode = true;
        this.editIndex = index;

        var _self = this;
        Object.keys(this.fields).map(function(key) {
            _self.fields[key] = _self.collection[index][key];
        })
    }

    cancel()
    {
        this.editMode = false;
        this.editIndex = null;
        this.deleteMode = false;
        this.deleteIndex = null;
        this.errors.clearAll();
    }

    save() {

        if (this.editIndex !== null) { // update

            axios.put(this.resource + '/' + this.fields[this.key], this.fields)
                .then(response => {
                    this.editMode = false;
                    this.collection[this.editIndex] = response.data;
                })
                .catch(error => {
                    this.errors.set(error.response.data);
                });

        } else { // create

            axios.post(this.resource, this.fields)
                .then(response => {
                    this.collection.push(response.data);
                    this.editMode = false;
                })
                .catch(error => {
                    this.errors.set(error.response.data);
                });

        }
    }

    deleteRow(index)
    {
        this.cancel();
        this.deleteMode = true;
        this.deleteIndex = index;

        var _self = this;
        Object.keys(this.fields).map(function(key) {
            _self.fields[key] = _self.collection[index][key];
        })

    }

    confirmDelete()
    {
        axios.delete(this.resource + '/' + this.fields[this.key])
            .then(response => {
                this.collection.splice(this.deleteIndex, 1);
                this.cancel();
            })
            .catch(error => {
                console.log(error.response.data);
            });
    }

}

export default Form;