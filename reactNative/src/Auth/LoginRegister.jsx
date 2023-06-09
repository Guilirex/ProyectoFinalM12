import { useState } from "react";
import React from "react";
import Register from "./Register";
import Login from "./Login";
import { View} from 'react-native';
import { useForm } from 'react-hook-form';




const LoginRegister = () => {

  let [login, setLogin] = useState(true);

  
  return (
      <View>
        {login ? 
            <Login setLogin={setLogin}/>
          : 
            <Register setLogin={setLogin}/>        
        }
        </View>
  );
}
export default LoginRegister;