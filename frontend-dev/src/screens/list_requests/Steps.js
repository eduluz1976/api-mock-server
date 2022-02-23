import { Grid, Paper } from '@mui/material';
import React from 'react';
import { Fragment } from 'react/cjs/react.production.min';

import './Steps.css'

export default function Steps(props) {

    const record = props.record;

    const getAdditionalData = (index) => {

        if (!record.transaction) {
            return;
        }

        if (record.transaction.steps[index]) {

            const matches = {
                method: false,
                url: false,
                // payload: false,
                // requiredHeaders: false,
                all: false
            };

            const item = record.transaction.steps[index];
            const request = record.request.steps[index].request;

            if (item && item.logs && item.logs.input) {


                const itemHttpStatusCode = item.logs.output.httpCode ? item.logs.output.httpCode : '';
                const itemContents = item.logs.input.contents ? item.logs.input.contents : '';
                const itemMethod = item.logs.input.method || '';
                const itemUrl = item.logs.input.url || '';

                const matchStyles = {
                    url: 'item-not-match',
                    method: 'item-not-match',
                 };



                if (itemUrl === request.url) {
                    matches.url = true;
                    matchStyles.url = 'item-match';
                } else {
                    console.log(" itemUrl === request.url ? ", {
                        itemUrl: itemUrl,
                        requestUrl: request.url
                    })
                }

                if (itemMethod === request.method) {
                    matches.method = true;
                    matchStyles.method = 'item-match';
                }

                
                
        

                return (
                    <Grid xs={5} className='request-step-block request-as-is'>
                    <div className='request-step-block-header'>Performed</div>

                    <div className='request-step-label'>Request :</div>
                    <div className='request-step-pre'> 
                                <span className={matchStyles.method}> {itemMethod}  </span>
                                <span className={matchStyles.url}> {itemUrl}   </span>
                        </div> 
                        <br/>
                        <div className='request-step-pre'>
                        {itemContents}
                        </div>
    
                        <hr/>
                        <div >
                    Response: <span className='request-step-pre'>{itemHttpStatusCode}</span>
                    </div>


                    </Grid>
                );
    
    
            }
        }
    }

    const getMainData = (step, index) => {

        console.log ('getMainData', index, step);
        const method = step.request.method || '';
        const url = step.request.url || '';
        const itemContents = (step.request.json) ? step.request.json : '';
        const payload = (step.response.json) ? step.response.json : '';

        return (
            <Fragment>
                <div className='request-step-block-header'>Expected</div>
                Request : <span className='request-step-pre'> {method} {url} </span> <br/>

                
                <div className='request-step-pre'>
                    {itemContents} 
                </div>            
                <hr/>
                Response: <span className='request-step-pre'>{step.response.httpStatusCode} </span>
                <div className='request-step-pre'>
                    {payload} 
                </div>            

            </Fragment>
        );


    }


    return (
        <Fragment>
            {record.request.steps.map((step, index) => {
                return (
                    <Fragment>
                    
                    <Grid xs={12} className='request-step-wrapper' key={index}>
                        
                        <div  className='request-step-index'>
                            <span>
                                {index}
                            </span>
                            
                        </div>
                        
                        <Grid xs={5} className='request-step-block request-to-be'>
                            {getMainData(step, index)}
                        </Grid>
                        {getAdditionalData (index) }

                        
                    </Grid>
                    &nbsp;
                    </Fragment>
                );
            }) }
        </Fragment>
    );
}
