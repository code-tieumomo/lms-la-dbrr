import React from 'react'
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import DefaultLayout from './components/layout/Layout';
import Login from './pages/Login';
import PrivateRoutes from './pages/PrivateRoutes';
import { publicRoutes } from './routes';
const App = () => {
	return (
		<Router>
			<Routes>
				<Route path='/' element={<Login />} />
				<Route element={<PrivateRoutes />}>
					{
						publicRoutes.map( (item,index) => {
							const Layout = item.layout || DefaultLayout;
							const ListPage = item.component
							return <Route key={index} path={item.path} element = {
								<Layout>
									<ListPage/>
								</Layout>
							} />
						} )
					}
				</Route>
				
			</Routes>
		</Router>
	)
}

export default App