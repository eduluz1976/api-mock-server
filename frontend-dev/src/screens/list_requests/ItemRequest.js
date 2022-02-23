
import { Grid } from '@mui/material';
import React, { Fragment, useState } from 'react';
import ButtonHideShow from './components/ButtonHideShow';
import Steps from './Steps';
import StepsTransaction from './StepsTransaction';


export default function ItemRequests(props) {

    const record = props.item;
    const request = record.request;
    const transaction = record.transaction;

    const [recordState, setRecordState] = useState({hidden: true});


    const onToggleViewButton = (data) => {
        setRecordState(data);
    }

    const getItem = (rec) => {

        if (rec.transaction) {
            return (
                <Fragment>

                <div className='item-request-col'>
                    <span className=' item-label'>createdAt: </span> <br/>
                    <span className='item-value'>{transaction.createdAt}</span>
                </div>

                </Fragment>
            );
        }
    }


    // const getSteps = (rec) => {
    //     if (rec.transaction) {
    //         return (
    //             <StepsTransaction record={record}/>
    //         );
    //     } else {
    //         return (
    //             <Steps record={record}/>
    //         );

    //     }
    // }

// <div className='item-request-row' hidden={recordState.hidden}>

    return (
        <Fragment>
            <Grid item xs={12}>

                <div className='item-request-row'>

                    <div className='item-request-col'>
                        <span className=' item-label'>ID: </span> <br/>
                        <span className='item-id item-value'>{request.transactionId}</span>
                    </div>
                    <div className='item-request-col'>
                        <span className='item-label'>Status: </span> <br/>
                        <span className='item-value'>{request.status}</span>
                    </div>

                    {  getItem(record)  }

                    <div className='item-request-col'>
                        <ButtonHideShow onToggle={onToggleViewButton} />                
                    </div>


                </div>
            </Grid>
            <Grid item xs={12} hidden={recordState.hidden}>
                
                
                    <Steps record={record}/>

                

            </Grid>
        </Fragment>

    );
}