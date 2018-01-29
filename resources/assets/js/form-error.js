/**
 * FormError class
 * Form validation errors
 */
class FormError {

    constructor()
    {
         this.errors = {};
         this.message = "";
    }


    set(data)
    {
        this.errors  = data.errors;
        this.message = data.message;
    }

    has(field)
    {
        return this.errors.hasOwnProperty(field);
    }

    get(field)
    {
        return this.errors[field] ? this.errors[field][0] : '';
    }

    getMessage()
    {
        return this.message;
    }

    clear(field)
    {
        delete this.errors[field];
    }

    clearAll()
    {
        this.errors = {};
    }

}

export default FormError;