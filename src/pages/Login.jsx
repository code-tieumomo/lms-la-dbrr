import  axios  from 'axios';
import React, { useState } from 'react'
import { useDispatch } from 'react-redux';
import { useHistory, useNavigate } from 'react-router-dom';
import { useFormik } from 'formik';
import * as Yup from 'yup';

import exportDefault  from '../redux/actions/ThemeAction';
import { apiLogin } from '../service/loginApi';

import { ToastContainer, toast } from 'react-toast';
import jwt_decode from "jwt-decode";

import "./index.css";

export default function Login() {
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
            apiLogin(values)
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
        },
    });

    let history = useNavigate();
    let dispatch = useDispatch();
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
