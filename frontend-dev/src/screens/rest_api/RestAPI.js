import React from "react";

import Constants from "../../common/Constants";

export default function RestAPI(props) {




    return (
        <div hidden={props.tabState.index !== Constants.HOME_TAB_API_EDITOR} >
            Rest API
        </div>
    );

}
