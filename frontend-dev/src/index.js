import React from "react";
import ReactDOM from "react-dom";
import "./index.css";
// import reportWebVitals from "./reportWebVitals";
import Controller from "./screens/Controller";
import store from './common/app-store/AppStore';
import config from './config';
import { Provider } from 'react-redux';
window.appConfig = config;


ReactDOM.render(
    <Provider store={store}><Controller config={config}/></Provider>, 
    document.getElementById("root"));

// // If you want to start measuring performance in your app, pass a function
// // to log results (for example: reportWebVitals(console.log))
// // or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
// reportWebVitals(console.log);
