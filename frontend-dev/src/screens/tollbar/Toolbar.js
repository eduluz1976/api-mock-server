import { FormControl, ListItem, MenuItem, Select, TextField } from "@mui/material";
import React from "react";




export default function Toolbar(props) {

    




    return (
        <div className='tollbar-container'>
            
        <FormControl >


        <Select label="Method">
            <MenuItem>GET</MenuItem>
            <MenuItem>POST</MenuItem>
            <MenuItem>PUT</MenuItem>
            <MenuItem>PATCH</MenuItem>
            <MenuItem>DELETE</MenuItem>
        </Select>



        <TextField label="URL" className='rate-appointment-textarea-field' 
        variant="standard"
        
        >
        </TextField>


        </FormControl>




        </div>
    );
}

