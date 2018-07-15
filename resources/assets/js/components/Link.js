import React, { Component } from 'react'
import * as http from 'axios'
import { info, error } from './../helpers/izitoast';


export default class Link extends Component {
    /**
     *
     * @param props
     */
    constructor(props) {
        super(props);
        this.state = {
            visibility: true
        };

        this.isActive = false;
        this.isDead = false;
        this.isSetLifetime = false;

        if (props.data.lifetime) {
            this.isSetLifetime = true;

           if (props.data.is_dead) {
               this.isActive = false;
               this.isDead = true;
           } else {
               this.isActive = Boolean(props.data.active);
               this.isDead = false;
           }
        } else {
            this.isDead = false;
            this.isActive = Boolean(props.data.active);
        }
    }

    /**
     *
     * @param event
     */
    handlerOnRemove(event) {
        event.preventDefault();
        event.stopPropagation();
        this.setState({
            visibility: false
        })

        http.post('/remove', { short_key: this.props.data.short })
            .then(() => {
                info('It\'s okey!', 'Link removed');
            })
            .catch(() => {
                error('Error remove link!', 'Try agait...');
                this.setState({
                    visibility: true
                })
            });
    }

    /**
     *
     * @param event
     */
    handlerOnEdit(event) {
        location.href = '/' + this.props.data.short + '/edit'
    }

    /**
     *
     * @param event
     */
    handlerOnStat(event) {
        location.href = '/' + this.props.data.short + '/stat'
    }

    /**
     *
     * @returns {*}
     */
    render() {
        return (
            <div hidden={ !this.state.visibility } className="link-item mb-3">
                <p className="text-dark mb-0 small">
                    <a target="_blank" rel="noopener" href={ this.props.data.short_link } className="text-dark">
                        { this.props.data.short_link }
                    </a>
                </p>
                <p className="text-muted small mb-1">
                    <a target="_blank" rel="noopener" href={ this.props.data.original } className="text-muted">
                        { this.props.data.original }
                    </a>
                </p>
                { this.isSetLifetime && <small className="d-block ml-auto text-muted align-self-center">
                    { this.isDead ? <span>Link is dead</span> : <span>{ this.props.data.lifetime }</span> }
                </small> }
                <div className="actions d-flex">
                    <button onClick={ this.handlerOnRemove.bind(this) } className="d-block btn btn-sm btn-link align-self-center">
                        <i className="fas fa-trash text-danger fa-sm" />
                    </button>
                    <button onClick={ this.handlerOnEdit.bind(this) } className="d-block btn btn-sm btn-link align-self-center">
                        <i className="fas fa-edit text-muted fa-sm" />
                    </button>
                    <button onClick={ this.handlerOnStat.bind(this) } className="d-block btn btn-sm btn-link align-self-center">
                        <i className="fas fa-grin-stars text-muted fa-sm" />
                    </button>
                    { this.isActive && <button className="d-block btn btn-sm btn-link ml-auto align-self-center">
                        <i className="fas fa-check-circle text-primary fa-sm"/>
                    </button> }
                </div>
            </div>
        );
    }
}