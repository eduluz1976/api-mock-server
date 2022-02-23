import { Button } from '@mui/material';
import React, { useState } from 'react';




export default function ButtonHideShow (props)  {

    const [buttonState, setButtonState] = useState({hidden: false, text: "View"});

    const eventOnClick = (event) => {

        const currState = buttonState;


        if (buttonState.hidden === true) {
            setButtonState({hidden: false, text: 'View'});
        } else {
            setButtonState({hidden: true, text: 'Hide'});
        }

        if (props.onToggle) {
            props.onToggle(currState);
        }
        
    }


    return (
        <Button variant='contained' color='primary' onClick={eventOnClick} > {buttonState.text} </Button>
    );

}


