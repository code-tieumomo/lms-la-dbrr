import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';
import Profile from '../components/Infor/Profile';

const publicRoutes = [
    {
        path: '/admin',
        component: Dashboard
    },
    {
        path: '/Profile',
        component: Profile
    } 

]
export { publicRoutes }