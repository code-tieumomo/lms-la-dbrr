import { Navigate, Outlet } from 'react-router-dom'

const PrivateRoutes = () => {
    const isAuth = JSON.parse(localStorage.getItem('profile-mindx'));
    return isAuth ? <Outlet /> : <Navigate to='/' />
}

export default PrivateRoutes