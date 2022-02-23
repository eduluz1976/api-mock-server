import React, { Fragment } from 'react';
// import Header from '../../common/header/Header';

// import Dialog from '@mui/material/Dialog';
// import Tabs from '@mui/material/Tabs';
// import Tab from '@mui/material/Tab';

import Box from '@mui/material/Box';
// import Toolbar from '../tollbar/Toolbar';
import { Tab, Tabs } from '@mui/material';
import Requests from '../requests/Requests';
// import DoctorList from '../doctorList/DoctorList';

import Constants from '../../common/Constants';
import RestAPI from '../rest_api/RestAPI';


// import { DialogTitle } from '@mui/material';
// import Constants from '../../util/Constants';
// import Appointment from '../appointment/Appointment';

export default function Home(props) {

    const [tabState, setTabState] = React.useState({index: Constants.HOME_TAB_REQUESTS_REPORT});

    // const [state, setState] = React.useState({index: 0});


    const onChangeTab = () => {
        let newState = tabState;

        if (tabState.index === Constants.HOME_TAB_REQUESTS_REPORT) {
            newState = {index: Constants.HOME_TAB_API_EDITOR};
        } else {
            newState = {index: Constants.HOME_TAB_REQUESTS_REPORT};
        }

        const finalState = { ...tabState, ...newState };
        setTabState(finalState);
    };

    // const onChangePanel = () => {

    //     let newState = state;

    //     if (state.index == Constants.TAB_APPOINTMENTS_LIST) {
    //         newState = {index: Constants.TAB_DOCTORS_LIST};
    //     } else {
    //         newState = {index: Constants.TAB_APPOINTMENTS_LIST};
    //     }

    //     const finalState = { ...state, ...newState };
    //     setState(finalState);

    // };


    return (
        <Fragment>
            <h1>Welcome</h1>
            <Tabs value={tabState.index} onChange={onChangeTab} indicatorColor="secondary" variant="fullWidth">
                <Tab label="Requests"/>
                <Tab label="REST API"/>                        
            </Tabs>            
            <Box>
                <Requests tabState={tabState}></Requests>
                <RestAPI tabState={tabState}></RestAPI>
                
            </Box>
        </Fragment>
    );
}
