import { StatusBar } from 'expo-status-bar';
import { useState } from 'react';
import { StyleSheet, Text, View } from 'react-native';
import LoginRegister from './src/Auth/LoginRegister';
import { UserContext } from './src/userContext';
import { MainPage } from './src/MainPage';
import { Header } from './src/Layout/Header';
import {Footer} from './src/Layout/Footer';


export default function App() {
  let [authToken, setAuthToken] = useState("")
  let [usuariId, setUsuariId] = useState("")
  return (

    <UserContext.Provider value={{ authToken, setAuthToken, usuariId, setUsuariId }}>
      <View style={styles.container}>
        {authToken ?
          <>

            <Header/>
            <MainPage />
            <Footer/>

          </> :
          <LoginRegister />}
        {/* <StatusBar style="auto" /> */}
      </View>
    </UserContext.Provider>


  );
}


const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
    alignItems: 'center',
    justifyContent: 'center',
  },
});
