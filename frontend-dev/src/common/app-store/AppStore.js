// import { useDispatch } from "react-redux";
import { createStore } from "redux";

const initialState = {
    isAuthDialogOpen: false,
    loggedUser : {
        id: null,
        username: ''
    },
    doctorsList : [   ],
    appointmentList: [],
    appointmentsLoaded: false,
    availableTimeslots: ['None'],
};

function AppStore(state = initialState, action) {

    switch (action.type) {
        case 'OPEN_AUTH_DIALOG':
            return {...state, isAuthDialogOpen: true};
        case 'CLOSE_AUTH_DIALOG':
            return {...state, isAuthDialogOpen: false};
        case 'AUTH_LOGOUT':
            sessionStorage.removeItem('user-profile');
            sessionStorage.removeItem('access-token');
            return {...state, loggedUser: {id:null,username:null}};    
        case 'AUTH_LOGIN':
            console.log(action.payload);
            return {...state, loggedUser: action.payload};    
        case 'LOAD_DOCTORS':
            return {...state, doctorsList: action.payload}
        case 'LOAD_DOCTOR_TIMESLOTS':            
            const availableTimeslots = ['None',  ...action.payload.timeSlot];
            console.log('LOAD_DOCTOR_TIMESLOTS', availableTimeslots);
            return {...state, availableTimeslots: availableTimeslots}
        case 'LOAD_APPOINTMENTS':            
            return {...state, appointmentList: action.payload, appointmentsLoaded: true}
        default:
            return state;
    }

}


export default createStore(AppStore);