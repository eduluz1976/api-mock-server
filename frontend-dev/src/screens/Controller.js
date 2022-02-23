import React from "react";
import Home from "../screens/home/Home";
import { BrowserRouter as Router, Route } from "react-router-dom";
// import LoadDoctorsService from "../common/services/LoadDoctorsService";
// import { useDispatch } from "react-redux";
// import AuthService from "../util/AuthService";


const Controller = (props) => {

  // const dispatch = useDispatch();

  // const serviceConfig = {
  //   baseUrl: props.config.baseUrl ,
  //   dispatch: dispatch
  // };


  // LoadDoctorsService(serviceConfig)



// const userProfile = AuthService.getInstance().getUserProfile();
// const accessToken = AuthService.getInstance().getAccessToken();

// if (userProfile) {
//   dispatch({type:"AUTH_LOGIN", payload: JSON.parse(userProfile)});
// }


  return (
    <Router>
      <div className="main-container">
        <Route
          exact
          path="/"
          render={(props) => <Home {...props}  />}
        />
      </div>
    </Router>
  );
};

export default Controller;
