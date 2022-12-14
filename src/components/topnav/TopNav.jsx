import React from 'react'

import './topnav.css'

import { Link, useNavigate } from 'react-router-dom'

import Dropdown from '../dropdown/Dropdown'

import ThemeMenu from '../thememenu/ThemeMenu'

import notifications from '../../assets/JsonData/notification.json'

import user_image from '../../assets/images/tuat.png'

import user_menu from '../../assets/JsonData/user_menus.json'
import { useSelector } from 'react-redux'

const curr_user = {
    // display_name: 'Tuat Tran',
    image: user_image
}

const renderNotificationItem = (item, index) => (
    <div className="notification-item" key={index}>
        <i className={item.icon}></i>
        <span>{item.content}</span>
    </div>
)


const Topnav = () => {
    const navigate  = useNavigate();
    const accountState = useSelector(state => state.profile);
    const displayName = accountState.profile.info.fullName;

    const renderUserToggle = (user) => (
        <div className="topnav__right-user">
            <div className="topnav__right-user__image">
                <img src={user.info.imageUrl} alt="" />
            </div>
            <div className="topnav__right-user__name">
                {displayName || user.displayName}
            </div>
        </div>
    )
    // const accountState = useSelector(state => state.ThemeReducer);
    // const {profile} = accountState;

    const handleLogout = (content) => {
        switch (content) {
            case "Logout":
                navigate('/', { replace: true });
                localStorage.removeItem('profile-mindx');
                break;
            case "Profile":
                navigate('/Profile', { replace: true });
                break;
            default:
                return;
        }    
    }

    const renderUserMenu =(item, index) => (
        // <Link to='/admin' key={index}>
        <div className="notification-item">
            <i className={item.icon}></i>
            <span onClick={ () => handleLogout(item.content) } >{item.content}</span>
        </div>
        // </Link>
    )

    const curr_user = localStorage.getItem('profile-mindx') ? JSON.parse(localStorage.getItem('profile-mindx')) : '';
    return (
        <div className='topnav'>
            <div className="topnav__search">
                <input type="text" placeholder='Search here...' />
                <i className='bx bx-search'></i>
            </div>
            <div className="topnav__right">
                <div className="topnav__right-item">
                    {/* dropdown here */}
                    <Dropdown
                        customToggle={() => renderUserToggle(curr_user)}
                        contentData={user_menu}
                        renderItems={(item, index) => renderUserMenu(item, index)}
                    />
                </div>
                <div className="topnav__right-item">
                    <Dropdown
                        icon='bx bx-bell'
                        badge='12'
                        contentData={notifications}
                        renderItems={(item, index) => renderNotificationItem(item, index)}
                        renderFooter={() => <Link to='/'>View All</Link>}
                    />
                    {/* dropdown here */}
                </div>
                <div className="topnav__right-item">
                    <ThemeMenu/>
                </div>
            </div>
        </div>
    )
}

export default Topnav
