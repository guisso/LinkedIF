/**
 * @file AuthContext.tsx
 * @description Contexto React para gerenciar autenticação globalmente na aplicação
 *
 * RESPONSABILIDADES:
 * - Prover estado de autenticação para toda a árvore de componentes
 * - Centralizar lógica de autenticação em um único lugar
 * - Evitar prop drilling de dados de autenticação
 * - Fornecer interface consistente para acesso à autenticação
 *
 * IMPORTANTE PARA A EQUIPE:
 * - Este contexto DEVE ser adicionado no topo da aplicação (main.tsx ou App.tsx)
 * - Use o hook useAuthContext() para acessar autenticação em qualquer componente
 * - NÃO use useAuth() diretamente nos componentes, use sempre useAuthContext()
 * - Este contexto wrappeia o useAuth hook para centralizar a lógica
 *
 * COMO USAR:
 * 1. No main.tsx: <AuthProvider><App /></AuthProvider>
 * 2. Nos componentes: const { user, signIn, signOut } = useAuthContext();
 *
 * @example
 * ```tsx
 * // No main.tsx
 * <AuthProvider>
 *   <App />
 * </AuthProvider>
 *
 * // Em qualquer componente
 * function MyComponent() {
 *   const { user, loading } = useAuthContext();
 *   if (loading) return <div>Carregando...</div>;
 *   return <div>{user ? user.name : 'Não logado'}</div>;
 * }
 * ```
 *
 * @author Criado para LinkedIF_frontend
 * @version 1.0.0
 */

import React, { createContext, useContext, type ReactNode } from 'react';
import { useAuth, type UseAuthReturn } from '../hooks/useAuth';

// ============================================================================
// TYPES & INTERFACES
// ============================================================================

/**
 * Tipo do valor do contexto (igual ao retorno do useAuth)
 */
type AuthContextValue = UseAuthReturn;

/**
 * Props do AuthProvider
 */
interface AuthProviderProps {
  /** Componentes filhos que terão acesso ao contexto */
  children: ReactNode;
}

// ============================================================================
// CONTEXT
// ============================================================================

/**
 * Contexto de autenticação
 * Inicializado como undefined para forçar uso dentro do Provider
 */
const AuthContext = createContext<AuthContextValue | undefined>(undefined);

// Para debug no React DevTools
AuthContext.displayName = 'AuthContext';

// ============================================================================
// PROVIDER
// ============================================================================

/**
 * Provider do contexto de autenticação
 * Deve ser colocado no topo da árvore de componentes
 *
 * @example
 * ```tsx
 * // No main.tsx ou App.tsx
 * import { AuthProvider } from './context/AuthContext';
 *
 * function App() {
 *   return (
 *     <AuthProvider>
 *       <YourRoutes />
 *     </AuthProvider>
 *   );
 * }
 * ```
 */
export const AuthProvider: React.FC<AuthProviderProps> = ({ children }) => {
  // Utiliza o hook useAuth internamente
  const auth = useAuth();

  return (
    <AuthContext.Provider value={auth}>
      {children}
    </AuthContext.Provider>
  );
};

// ============================================================================
// HOOK
// ============================================================================

/**
 * Hook para acessar o contexto de autenticação
 *
 * ⚠️ IMPORTANTE: Este hook DEVE ser usado dentro de um componente que está
 * dentro do AuthProvider, caso contrário irá lançar um erro.
 *
 * @throws {Error} Se usado fora do AuthProvider
 * @returns {AuthContextValue} Estado e métodos de autenticação
 *
 * @example
 * ```tsx
 * function ProfilePage() {
 *   const { user, loading, signOut } = useAuthContext();
 *
 *   if (loading) {
 *     return <LoadingSpinner />;
 *   }
 *
 *   if (!user) {
 *     return <Navigate to="/login" />;
 *   }
 *
 *   return (
 *     <div>
 *       <h1>Olá, {user.name}!</h1>
 *       <button onClick={signOut}>Sair</button>
 *     </div>
 *   );
 * }
 * ```
 *
 * @example
 * // Exemplo de uso para proteger uma página
 * ```tsx
 * function ProtectedPage() {
 *   const { user, loading } = useAuthContext();
 *   const navigate = useNavigate();
 *
 *   useEffect(() => {
 *     if (!loading && !user) {
 *       navigate('/login');
 *     }
 *   }, [user, loading, navigate]);
 *
 *   if (loading) return <LoadingSpinner />;
 *   if (!user) return null; // ou redirect
 *
 *   return <div>Conteúdo protegido</div>;
 * }
 * ```
 */
export const useAuthContext = (): AuthContextValue => {
  const context = useContext(AuthContext);

  if (context === undefined) {
    throw new Error(
      '❌ useAuthContext deve ser usado dentro de um AuthProvider.\n\n' +
      'Certifique-se de que seu componente está dentro de <AuthProvider>:\n\n' +
      '<AuthProvider>\n' +
      '  <SeuComponente />\n' +
      '</AuthProvider>\n\n' +
      'Verifique o arquivo main.tsx ou App.tsx'
    );
  }

  return context;
};

// ============================================================================
// UTILITY HOOKS (Opcionais - para casos específicos)
// ============================================================================

/**
 * Hook utilitário para obter apenas o usuário atual
 * Útil quando você só precisa dos dados do usuário
 *
 * @returns {AuthContextValue['user']} Usuário atual ou null
 *
 * @example
 * ```tsx
 * function UserAvatar() {
 *   const user = useCurrentUser();
 *   if (!user) return <GuestAvatar />;
 *   return <Avatar src={user.photo} name={user.name} />;
 * }
 * ```
 */
export const useCurrentUser = () => {
  const { user } = useAuthContext();
  return user;
};

/**
 * Hook utilitário para verificar se usuário está autenticado
 * Retorna boolean de forma mais semântica
 *
 * @returns {boolean} true se usuário está autenticado, false caso contrário
 *
 * @example
 * ```tsx
 * function NavBar() {
 *   const isAuthenticated = useIsAuthenticated();
 *   return (
 *     <nav>
 *       {isAuthenticated ? <UserMenu /> : <LoginButton />}
 *     </nav>
 *   );
 * }
 * ```
 */
export const useIsAuthenticated = (): boolean => {
  const { user, loading } = useAuthContext();
  return !loading && user !== null;
};

// ============================================================================
// EXPORTS
// ============================================================================

/**
 * Exportação nomeada do contexto (para casos avançados)
 * Na maioria dos casos, use useAuthContext() ao invés de acessar diretamente
 */
export { AuthContext };

/**
 * Type exports para uso em outros arquivos
 */
export type { AuthContextValue, AuthProviderProps };
