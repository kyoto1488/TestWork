import React, { Component } from 'react'
import { render } from 'react-dom'
import { info, error } from './../helpers/izitoast'
import * as http  from 'axios'


class FormCreateLink extends Component {
    /**
     *
     * @param props
     */
    constructor(props) {
        super(props);
        this.form = null;
        this.link = null;
        this.date = null;
        this.time = null;
        this.active = null;
        this.buttonSubmit = null;
    }

    /**
     *
     * @param event
     */
    onSubmit(event) {
        event.preventDefault();
        event.stopPropagation();
        this.buttonSubmit.setAttribute('disabled', 'disabled');

        http.post('/create', {
            link: this.link.value,
            date: this.date.value,
            time: this.time.value,
            active: this.active.checked
        })
            .then(response => {
                info('It\'s okey!', 'Link created... Your link: ' + response.data.link);
                this.buttonSubmit.removeAttribute('disabled');
                this.form.reset();
            })
            .catch(() => {
                error('Error!', 'Try again...');
                this.buttonSubmit.removeAttribute('disabled');
            })
    }

    /**
     *
     * @returns {*}
     */
    render() {
        return (
            <form id="form-create-link" ref={ form => this.form = form } onSubmit={ this.onSubmit.bind(this) } method="post">

                <div className="form-group">
                    <label htmlFor="link">Link</label>
                    <input type="text" ref={ input => this.link = input } required="required" className="form-control" />
                </div>

                <div className="form-group">
                    <label>Lifetime</label>
                    <div className="form-row">
                        <div className="col-7">
                            <input type="date" ref={ input => this.date = input } min={ new Date().toISOString().substring(0, 10) } className="form-control" />
                        </div>
                        <div className="col-5">
                            <input type="time" ref={ input => this.time = input } className="form-control" />
                        </div>
                    </div>
                </div>

                <div className="custom-control custom-checkbox form-group">
                    <input type="checkbox" ref={ input => this.active = input } className="custom-control-input" id="active" />
                    <label className="custom-control-label" htmlFor="active">Active</label>
                </div>

                <button ref={ button => this.buttonSubmit = button } type="submit" className="btn btn-primary">
                    Create link
                </button>

            </form>

        );
    }
}

if (document.querySelector('[data-component="form-create-link"]')) {
    render(<FormCreateLink/>, document.querySelector('[data-component="form-create-link"]'))
}