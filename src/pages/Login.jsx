import  axios  from 'axios';
import React, { useState } from 'react'
import { useDispatch } from 'react-redux';
import { useFormik } from 'formik';
import * as Yup from 'yup';

import exportDefault  from '../redux/actions/ThemeAction';
import { apiLogin } from '../service/loginApi';

import { ToastContainer, toast } from 'react-toast';
import jwt_decode from "jwt-decode";

import "./index.css";
import { fetchProfile } from '../redux/reducers/profileSlide';
import { useNavigate } from 'react-router-dom';

export default function Login() {
    const dispatchAction = useDispatch();
    const history = useNavigate();
    const SignupSchema = Yup.object().shape({
        email: Yup.string().email('Nhap dung dinh dang email').required('Khong de trong'),
        password: Yup.string()
        .min(6, 'Mat khau phai lon hon 6 ky tu')
        .max(15, 'Mat khau khong dai qua 15 ky tu')
        .required('Khong de trong'),
    });

    const formik = useFormik({
        initialValues: {
            email: '',
            password: '',
        },
        validationSchema: SignupSchema,
        onSubmit: values => {
            dispatchAction(fetchProfile(values))
            setTimeout(() =>{
                history("/admin");
            }, 1000)
        },
    });

    return (
        <>
            <div className="login-box">
                <h2>Login</h2>
                <form  onSubmit={formik.handleSubmit}>
                    <div className="user-box">
                        <input type="email" name="email" required="" 
                        onChange={formik.handleChange}
                        value={formik.values.email}
                        />
                        <label htmlFor="Username">Username</label>
                        {formik.errors.email 
                        ? ( <div 
                            className="err__form"
                            style={{
                                marginBottom: "20px"
                            }}
                        >{formik.errors.email}</div>) : null}
                    </div>
                    <div className="user-box">
                        <input type="password" name="password" required="" 
                        onChange={formik.handleChange}
                        value={formik.values.password}
                        />
                        <label htmlFor="Password">Password</label>
                        {formik.errors.password ? ( <div className="err__form">{formik.errors.password}</div>) : null}
                    </div>
                    <button type="Submit" className="btn__submit">
                        <a>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            Submit
                        </a>
                    </button>
                </form>
            </div>
            <ToastContainer 
                position="top-right"
            />
        </>
    )
}
