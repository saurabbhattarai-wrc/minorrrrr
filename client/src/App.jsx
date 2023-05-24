import React from "react";
import {BrowserRouter,Routes,Route} from 'react-router-dom'
import Contact from "./components/contact";
import Footer from "./components/footer";
import Landing from "./components/landing";
import Login from "./components/login";
import Signup from "./components/signup";
import Skill from "./components/skill";
import Faq from "./components/faq"; 
import Companysignup from "./components/companysignup";
import Postjob from "./components/postJob"; 
import Sitemap from "./components/sitemap";
import Companylogin from "./components/companylogin";
import Dashboard from "./components/dashboard"; 
import Companydashboard from "./components/companydashboard";
import Updateprofile from "./components/updateprofile";








const App = () => {
  return (
    <BrowserRouter>
    <Routes>
    <Route path="/" element={<Landing />}  />
    <Route path="/login" element={<Login />}  />
    <Route path="/signup" element={<Signup />}  />
    <Route path="/contact" element={<Contact />}  />
    <Route path="/" element={<Landing />}  />
    {/* <Skill /> */} 
    <Route path = "/faq" element = {<Faq />} />
    <Route path = "/companysignup" element = {<Companysignup />} /> 
    <Route path = "/postJob" element = {<Postjob />} />  
    <Route path = "/sitemap" element = {<Sitemap />} />
    <Route path = "/companylogin" element = {<Companylogin />} />
    <Route path = "/dashboard" element = {<Dashboard />} /> 
    <Route path = "/companydashboard" element = {<Companydashboard />} /> 
    <Route path = "/updateprofile" element = {<Updateprofile />} /> 



  


    


    
    </Routes>
    <Footer /> 
    </BrowserRouter>
  );
};

export default App;
