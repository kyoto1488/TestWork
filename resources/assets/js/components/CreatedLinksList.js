import React, { Component } from 'react'
import { render } from 'react-dom'
import * as http from 'axios'
import Link from './Link';


class CreatedLinksList extends Component {
    /**
     *
     * @param props
     */
    constructor(props) {
        super(props);
        this.state = {
            list: [],
            bootstrap: true
        };
        this.intervalId = null;
    }

    componentDidMount() {
        this.sendRequest();
        this.intervalId = setInterval(this.sendRequest.bind(this), 3000);
    }

    sendRequest() {
        http.get('/created')
            .then(response => {
                this.setState({
                    list: response.data,
                    bootstrap: false
                });
            })
            .catch(() => {
                clearInterval(this.intervalId);
                this.setState({
                    bootstrap: false
                })
            });
    }

    /**
     *
     * @returns {*}
     */
    render() {
        if (this.state.bootstrap) {
            return (
                <div className="text-center mt-5">
                    <i className="fas fa-spinner fa-spin fa-lg"/>
                </div>
            );
        }

        if (this.state.list.length > 0) {
            return this
                .state
                .list
                .reverse()
                .map((data, index) => <Link key={ data.short } data={ data }/>);
        }

        return (
            <div className="text-center mt-5">
                <h5 className="font-weight-light mb-0">
                    Nothing!
                </h5>
                <h6 className="font-weight-bold">
                    Create link in left block
                </h6>
            </div>
        )
    }
}

if (document.querySelector('[data-component="created-links-list"]')) {
    render(<CreatedLinksList/>, document.querySelector('[data-component="created-links-list"]'))
}