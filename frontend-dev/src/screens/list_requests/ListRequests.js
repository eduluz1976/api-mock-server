// import { makeStyles } from '@mui/material';
import React, { Fragment, useState } from 'react';
import ItemRequests from './ItemRequest';
import './ListRequests.css';
import { makeStyles } from '@material-ui/core/styles';
import { Button, Grid } from '@mui/material';

const useStyles = makeStyles((theme) => ({

    root: {
        flexGrow: 1,
      },
      paper: {
        padding: theme.spacing(2),
        textAlign: 'center',
        color: theme.palette.text.primary,
      },

}));

export default function ListRequests(props) {


    const classes = useStyles();

    const [myList, setMyList] = useState([]);


    // const myList = [
    //     {
    //         request: {
    //             transactionId: "abc",
    //             status: "running",
    //             steps: [
    //                     {
    //                         request: {
    //                             method: "GET",
    //                             url: "/xpto"
    //                         },
    //                         response: {
    //                             httpStatusCode: 200
    //                         }
    //                     },
    //                     {
    //                         request: {
    //                             method: "GET",
    //                             url: "/xpto2"
    //                         },
    //                         response: {
    //                             httpStatusCode: 400
    //                         }
    //                     },
    //                 ]
    //         },
    //         transaction: {
    //             transactionId: "aaaaaa",
    //             createdAt: "2022-02-17 20:00:10",
    //             steps: [
    //                 {
    //                     request: {
    //                         method: "GET",
    //                         url: "/xpto"
    //                     },
    //                     response: {
    //                         httpStatusCode: 200
    //                     },
    //                     logs: {
    //                         input: {
    //                             method: "GET",
    //                             url: "/xpto",
    //                             contents: "abc"
    //                         }
    //                     }
    //                 },
    //                 {
    //                     request: {
    //                         method: "GET",
    //                         url: "/xpto2"
    //                     },
    //                     response: {
    //                         httpStatusCode: 400
    //                     },
    //                     logs: {
    //                         input: {
    //                             method: "GET",
    //                             url: "/xpto2",
    //                             contents: "xyz"
    //                         }
    //                     }
    //                 },
    //             ]
    //         }

    //     },
    //     {
    //         request: {
    //             transactionId: "abc2",
    //             status: "pending",
    //             steps: [
    //                     {
    //                         request: {
    //                             method: "GET",
    //                             url: "/xpto"
    //                         },
    //                         response: {
    //                             httpStatusCode: 200,
    //                             json: "{\"msg\":\"OK\"}"
    //                         }
    //                     }
    //                 ]
    //         }
    //     },
    //     {
    //         request: {
    //             transactionId: "edf",
    //             status: "running",
    //             steps: [
    //                     {
    //                         request: {
    //                             method: "GET",
    //                             url: "/edf/somethingVeryLarge/{:id}/anotherVeryLargeWordHere"
    //                         },
    //                         response: {
    //                             httpStatusCode: 200
    //                         }
    //                     },
    //                     {
    //                         request: {
    //                             method: "GET",
    //                             url: "/xpto2"
    //                         },
    //                         response: {
    //                             httpStatusCode: 400
    //                         }
    //                     },
    //                 ]
    //         },
    //         transaction: {
    //             transactionId: "aaaaaa",
    //             createdAt: "2022-02-17 20:00:10",
    //             steps: [
    //                 {
    //                     request: {
    //                         method: "GET",
    //                         url: "/xpto"
    //                     },
    //                     response: {
    //                         httpStatusCode: 200
    //                     },
    //                     logs: {
    //                         input: {
    //                             method: "GET",
    //                             url: "/xpto",
    //                             contents: "abc"
    //                         }
    //                     }
    //                 },
    //             ]
    //         }

    //     },        
        
    // ];


    const loadData = () => {
        const url = "http://localhost:21082/requests";
        const resp = fetch(url).then(
            (data) => {
                return  data.json();
            }).then(json => {
                console.log('loadData',json);
                setMyList(json);
            });
        ;
    };



    return (

        <Grid container spacing={3} className={classes.root}>
        <div style={{display:"block",clear:"both"}}>
        <Button variant='contained' color='primary' onClick={loadData}>Load</Button>
        </div>
        
            
        

            {myList.map((item) => {
                return (
                    <ItemRequests key={item.request.transactionId} item={item}/>
                );
            })
                }


        </Grid>
    );
}