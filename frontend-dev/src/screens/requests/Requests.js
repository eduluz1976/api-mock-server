import React from 'react';
import Constants from '../../common/Constants';
import ListRequests from '../list_requests/ListRequests';

export default function Requests (props) {



    return (
        <div hidden={props.tabState.index !== Constants.HOME_TAB_REQUESTS_REPORT} >
            Requests 

            <ListRequests/>
        </div>
    );
}