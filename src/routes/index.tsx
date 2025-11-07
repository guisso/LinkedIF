import { createBrowserRouter } from 'react-router-dom';
import Login from '../screens/Login';

export const router = createBrowserRouter([
  {
    path: '/',
    element: <Login />,
  },
  {
    path: '/login',
    element: <Login />,
  },
  // TODO: Adicionar rotas protegidas aqui
  // {
  //   path: '/dashboard',
  //   element: <ProtectedRoute><Dashboard /></ProtectedRoute>,
  // },
]);
