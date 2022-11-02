import  axios  from 'axios';
import React, { useState } from 'react'
import { useDispatch } from 'react-redux';
import { useHistory, useNavigate } from 'react-router-dom';
import exportDefault  from '../redux/actions/ThemeAction';
import { apiLogin } from '../service/loginApi';

import { ToastContainer, toast } from 'react-toast';
import jwt_decode from "jwt-decode";

import "./index.css";
export default function Login() {

    const [userName, setUserName] = useState('');
    const [password, setPassword] = useState('');

    let history = useNavigate();
    let dispatch = useDispatch();
    const handleLogin = (e) => {
        e.preventDefault();
        const newUser = {
            email: userName,
            password: password,
        }
        apiLogin(newUser)
        .then((response) => {
            console.log("res", response.data);
            if ( !response.data.error ) {
                dispatch(exportDefault.updateUser(response.data));
                const decoded = jwt_decode(response.data.idToken);
                localStorage.setItem('profile-mindx', JSON.stringify(decoded));
                localStorage.setItem('accessToken', JSON.stringify(response.data.idToken));
                toast.success("Đăng nhập thành công !!!!");
                setTimeout(() => {
                    history('/admin');
                }, 1000);
            } else {
                localStorage.removeItem('profile-mindx');
                toast.error("Mời bạn nhập đúng tài khoản")
            }
        })
        .catch (error => {
            toast.error("Mời bạn nhập đúng tài khoản")
        })
    }
    return (
        <>
            <div class="login-box">
                <h2>Login</h2>
                <form>
                    <div class="user-box">
                    <input type="text" name="" required="" onChange={ (e) => setUserName(e.target.value) } />
                    <label>Username</label>
                    </div>
                    <div class="user-box">
                    <input type="password" name="" required="" onChange={ (e) => setPassword(e.target.value) }/>
                    <label>Password</label>
                    </div>
                    <a href="#" onClick={ (e) => handleLogin(e) }>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        Submit
                    </a>
                </form>
            </div>
            <ToastContainer 
                position="top-right"
            />
        </>
    )
}
