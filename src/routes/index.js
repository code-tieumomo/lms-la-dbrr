import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';
import Profile from '../components/Infor/Profile';
import Customers from '../pages/Dashboard';

const publicRoutes = [
    {
        path: '/admin',
        component: Dashboard
    },
    {
        path: '/profile',
        component: Profile
    },
    {
        path:'/class',
        component: Customers
    }


]
export { publicRoutes }