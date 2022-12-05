import React from "react";
import "./index.css";

const Profile = () => {
    const getDataUser = JSON.parse(localStorage.getItem("profile-mindx"));
    const fullName = getDataUser.displayName;
    const srcImage = getDataUser.info.imageUrl;
    const email = getDataUser.email;
    const phone = getDataUser.info.phoneNumber;
    const code = getDataUser.info.code;
    const gender = getDataUser.info.gender;
    const isActive = getDataUser.info.isActive;
    const facebook = getDataUser.info.facebook;

    return (
        <div class="wrapper">
            <div class="left">
                <img src={srcImage} alt="user" width="100" />
                <h4>{fullName}</h4>
                <p>Teacher Teen</p>
            </div>
            <div class="right">
                <div class="info">
                    <h3>Information</h3>
                    <div class="info_data">
                        <div class="data">
                            <h4>Email</h4>
                            <p>{email}</p>
                        </div>
                        <div class="data">
                            <h4>Phone</h4>
                            <p>{phone}</p>
                        </div>
                    </div>
                </div>

                <div class="projects">
                    <h3>Projects</h3>
                    <div class="projects_data">
                        <div class="data">
                            <h4>Recent</h4>
                            <p>Lorem ipsum dolor sit amet.</p>
                        </div>
                        <div class="data">
                            <h4>Code Lms</h4>
                            <p>{code}</p>
                        </div>
                    </div>
                </div>

                <div class="projects">
                    <h3>Projects</h3>
                    <div class="projects_data">
                        <div class="data">
                            <h4>Gender</h4>
                            <p>{gender}</p>
                        </div>
                        <div class="data">
                            <h4>Active</h4>
                            <p>{isActive ? "On" : "Off"}</p>
                        </div>
                    </div>
                </div>

                <div class="social_media">
                    <ul>
                        <li>
                            <a href={facebook}>
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    );
};

export default Profile;
