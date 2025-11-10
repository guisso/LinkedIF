/**
 * @file ProtectedRoute.tsx
 * @description Componente para proteger rotas que requerem autenticação
 *
 * RESPONSABILIDADES:
 * - Verificar se o usuário está autenticado antes de renderizar conteúdo
 * - Redirecionar para login caso não esteja autenticado
 * - Mostrar loading enquanto verifica autenticação
 * - Opcionalmente, verificar tipos de usuário permitidos na rota
 *
 * IMPORTANTE PARA A EQUIPE:
 * - Use este componente para TODAS as rotas que precisam de autenticação
 * - Não crie lógica de proteção manual em cada página
 * - Este componente centraliza a lógica de proteção em um único lugar
 * - Suporta filtro por tipo de usuário (ex: apenas COMPANY, apenas STUDENT)
 *
 * COMO USAR:
 * 1. No arquivo de rotas (routes/index.tsx)
 * 2. Wrappear o elemento da rota com <ProtectedRoute>
 * 3. Opcional: especificar allowedUserTypes
 *
 * @example
 * ```tsx
 * // Rota simples protegida
 * {
 *   path: '/profile',
 *   element: <ProtectedRoute><ProfilePage /></ProtectedRoute>
 * }
 *
 * // Rota protegida apenas para empresas
 * {
 *   path: '/post-job',
 *   element: (
 *     <ProtectedRoute allowedUserTypes={['COMPANY']}>
 *       <PostJobPage />
 *     </ProtectedRoute>
 *   )
 * }
 *
 * // Rota protegida para estudantes e ex-alunos
 * {
 *   path: '/apply',
 *   element: (
 *     <ProtectedRoute allowedUserTypes={['STUDENT', 'ALUMNI']}>
 *       <ApplyPage />
 *     </ProtectedRoute>
 *   )
 * }
 * ```
 *
 * @author Criado para LinkedIF_frontend
 * @version 1.0.0
 */

import React from 'react';
import { Navigate, useLocation } from 'react-router-dom';
import { useAuthContext } from '../context/AuthContext';
import type { UserType } from '../types/user.types';

// ============================================================================
// TYPES & INTERFACES
// ============================================================================

/**
 * Props do componente ProtectedRoute
 */
interface ProtectedRouteProps {
  /** Conteúdo que será renderizado se usuário tiver permissão */
  children: React.ReactNode;

  /**
   * Tipos de usuário permitidos nesta rota
   * Se não especificado, qualquer usuário autenticado pode acessar
   *
   * @example ['COMPANY'] - apenas empresas
   * @example ['STUDENT', 'ALUMNI'] - estudantes e ex-alunos
   */
  allowedUserTypes?: UserType[];

  /**
   * Rota para redirecionar caso não autenticado
   * @default '/login'
   */
  redirectTo?: string;

  /**
   * Componente de loading customizado (opcional)
   * Se não fornecido, usa um loading padrão
   */
  loadingComponent?: React.ReactNode;
}

// ============================================================================
// COMPONENT
// ============================================================================

/**
 * Componente para proteger rotas que requerem autenticação
 *
 * Este componente:
 * 1. Verifica se o usuário está autenticado
 * 2. Se não estiver, redireciona para login (preservando a URL tentada)
 * 3. Se estiver, verifica se o tipo de usuário é permitido
 * 4. Se permitido, renderiza o conteúdo
 * 5. Se não permitido, redireciona para uma página de acesso negado
 *
 * @param {ProtectedRouteProps} props - Props do componente
 * @returns {React.ReactElement} Conteúdo protegido ou redirecionamento
 */
export const ProtectedRoute: React.FC<ProtectedRouteProps> = ({
  children,
  allowedUserTypes,
  redirectTo = '/login',
  loadingComponent,
}) => {
  const { user, loading } = useAuthContext();
  const location = useLocation();

  // ==========================================================================
  // LOADING STATE
  // ==========================================================================

  /**
   * Enquanto estiver carregando dados de autenticação, mostra loading
   * Isso evita flash de redirecionamento
   */
  if (loading) {
    return (
      <>
        {loadingComponent || (
          <div
            style={{
              display: 'flex',
              justifyContent: 'center',
              alignItems: 'center',
              minHeight: '100vh',
              fontFamily: 'Inter, system-ui, sans-serif',
            }}
          >
            <div>
              <div
                style={{
                  width: '40px',
                  height: '40px',
                  border: '3px solid #f3f3f3',
                  borderTop: '3px solid #006633',
                  borderRadius: '50%',
                  animation: 'spin 1s linear infinite',
                  margin: '0 auto',
                }}
              />
              <p style={{ marginTop: '1rem', color: '#666' }}>
                Carregando...
              </p>
            </div>
            <style>{`
              @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
              }
            `}</style>
          </div>
        )}
      </>
    );
  }

  // ==========================================================================
  // NOT AUTHENTICATED
  // ==========================================================================

  /**
   * Se não houver usuário autenticado, redireciona para login
   * Salva a URL atual no state para redirecionar de volta após login
   */
  if (!user) {
    console.log(
      '[ProtectedRoute] Usuário não autenticado, redirecionando para:',
      redirectTo
    );

    return (
      <Navigate
        to={redirectTo}
        // Preserva a URL que o usuário tentou acessar
        // Pode ser usada na página de login para redirecionar após login bem-sucedido
        state={{ from: location }}
        replace
      />
    );
  }

  // ==========================================================================
  // USER TYPE VALIDATION
  // ==========================================================================

  /**
   * Se allowedUserTypes foi especificado, verifica se o tipo do usuário
   * atual está na lista de tipos permitidos
   */
  if (allowedUserTypes && allowedUserTypes.length > 0) {
    const isAllowed = allowedUserTypes.includes(user.userType);

    if (!isAllowed) {
      console.warn(
        '[ProtectedRoute] Acesso negado. Tipo de usuário não permitido.',
        {
          userType: user.userType,
          allowedTypes: allowedUserTypes,
          route: location.pathname,
        }
      );

      // TODO: Criar uma página de acesso negado (Unauthorized)
      // Por enquanto, redireciona para home
      return (
        <Navigate
          to="/"
          state={{
            error: 'Você não tem permissão para acessar esta página.',
            from: location,
          }}
          replace
        />
      );
    }
  }

  // ==========================================================================
  // AUTHORIZED - RENDER CHILDREN
  // ==========================================================================

  /**
   * Usuário está autenticado e tem permissão para acessar
   * Renderiza o conteúdo protegido
   */
  console.log('[ProtectedRoute] Acesso autorizado', {
    user: user.name,
    userType: user.userType,
    route: location.pathname,
  });

  return <>{children}</>;
};

// ============================================================================
// HELPER COMPONENTS (Opcionais)
// ============================================================================

/**
 * Componente helper para rotas acessíveis apenas por empresas
 *
 * @example
 * ```tsx
 * {
 *   path: '/post-job',
 *   element: <CompanyRoute><PostJobPage /></CompanyRoute>
 * }
 * ```
 */
export const CompanyRoute: React.FC<{ children: React.ReactNode }> = ({
  children,
}) => {
  return (
    <ProtectedRoute allowedUserTypes={['COMPANY']}>
      {children}
    </ProtectedRoute>
  );
};

/**
 * Componente helper para rotas acessíveis por estudantes e ex-alunos
 *
 * @example
 * ```tsx
 * {
 *   path: '/my-applications',
 *   element: <StudentRoute><ApplicationsPage /></StudentRoute>
 * }
 * ```
 */
export const StudentRoute: React.FC<{ children: React.ReactNode }> = ({
  children,
}) => {
  return (
    <ProtectedRoute allowedUserTypes={['STUDENT', 'ALUMNI']}>
      {children}
    </ProtectedRoute>
  );
};

/**
 * Componente helper para rotas acessíveis apenas por professores
 *
 * @example
 * ```tsx
 * {
 *   path: '/manage-students',
 *   element: <TeacherRoute><ManageStudentsPage /></TeacherRoute>
 * }
 * ```
 */
export const TeacherRoute: React.FC<{ children: React.ReactNode }> = ({
  children,
}) => {
  return (
    <ProtectedRoute allowedUserTypes={['TEACHER']}>
      {children}
    </ProtectedRoute>
  );
};

/**
 * Componente helper para rotas acessíveis apenas por administradores
 *
 * @example
 * ```tsx
 * {
 *   path: '/admin',
 *   element: <AdminRoute><AdminDashboard /></AdminRoute>
 * }
 * ```
 */
export const AdminRoute: React.FC<{ children: React.ReactNode }> = ({
  children,
}) => {
  return (
    <ProtectedRoute allowedUserTypes={['ADMIN']}>
      {children}
    </ProtectedRoute>
  );
};

// ============================================================================
// EXPORTS
// ============================================================================

export default ProtectedRoute;
