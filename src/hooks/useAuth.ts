/**
 * @file useAuth.ts
 * @description Hook de autenticação que gerencia o estado de login/logout do usuário
 *
 * RESPONSABILIDADES:
 * - Gerenciar estado de autenticação (usuário logado)
 * - Persistir sessão no localStorage
 * - Fornecer métodos de signIn, signUp e signOut
 * - Validar e recuperar sessão existente
 *
 * IMPORTANTE PARA A EQUIPE:
 * - Este hook é INDEPENDENTE e pode ser usado diretamente ou via AuthContext
 * - Para usar globalmente, prefira o AuthContext (src/context/AuthContext.tsx)
 * - As notificações (toast) devem ser configuradas no componente consumidor
 * - Atualmente usa mock data - substituir signIn/signUp quando API estiver pronta
 *
 * @author Migrado de ifnmgs-connect e adaptado para LinkedIF_frontend
 * @version 1.0.0
 */

import { useEffect, useState } from 'react';
import type { User, UserType } from '../types/user.types';

// ============================================================================
// TYPES & INTERFACES
// ============================================================================

/**
 * Dados necessários para cadastro de um novo usuário
 */
export interface SignUpData {
  email: string;
  password: string;
  name: string;
  userType: UserType;
  // Campos específicos por tipo de usuário
  campus?: string;           // Para STUDENT, ALUMNI, TEACHER
  course?: string;           // Para STUDENT, ALUMNI
  department?: string;       // Para TEACHER
  cnpj?: string;            // Para COMPANY
}

/**
 * Resposta padrão das operações de autenticação
 */
export interface AuthResponse<T = User> {
  data: T | null;
  error: Error | null;
}

/**
 * Estado e métodos retornados pelo hook useAuth
 */
export interface UseAuthReturn {
  /** Usuário atualmente autenticado (null se não logado) */
  user: User | null;
  /** Sessão ativa (compatibilidade com padrão Supabase) */
  session: { user: User } | null;
  /** Indica se está carregando dados de autenticação */
  loading: boolean;
  /** Função para fazer login */
  signIn: (email: string, password: string) => Promise<AuthResponse>;
  /** Função para criar nova conta */
  signUp: (data: SignUpData) => Promise<AuthResponse>;
  /** Função para fazer logout */
  signOut: () => Promise<void>;
}

// ============================================================================
// CONSTANTS
// ============================================================================

/** Chave usada para armazenar usuário no localStorage */
const STORAGE_KEY = 'linkedif_user';

// ============================================================================
// HOOK
// ============================================================================

/**
 * Hook customizado para gerenciar autenticação
 *
 * @example
 * ```tsx
 * function MyComponent() {
 *   const { user, loading, signIn, signOut } = useAuth();
 *
 *   if (loading) return <div>Carregando...</div>;
 *   if (!user) return <div>Não autenticado</div>;
 *
 *   return <div>Olá, {user.name}!</div>;
 * }
 * ```
 *
 * @returns {UseAuthReturn} Estado e métodos de autenticação
 */
export const useAuth = (): UseAuthReturn => {
  const [user, setUser] = useState<User | null>(null);
  const [loading, setLoading] = useState(true);

  // ==========================================================================
  // EFFECTS
  // ==========================================================================

  /**
   * Efeito: Recupera sessão existente do localStorage na inicialização
   * Executa apenas uma vez quando o componente é montado
   */
  useEffect(() => {
    const loadStoredUser = () => {
      try {
        const storedUser = localStorage.getItem(STORAGE_KEY);
        if (storedUser) {
          const parsedUser = JSON.parse(storedUser);
          setUser(parsedUser);
        }
      } catch (error) {
        console.error('[useAuth] Erro ao carregar usuário do localStorage:', error);
        // Se houver erro ao fazer parse, limpa o localStorage
        localStorage.removeItem(STORAGE_KEY);
      } finally {
        setLoading(false);
      }
    };

    loadStoredUser();
  }, []);

  // ==========================================================================
  // AUTHENTICATION METHODS
  // ==========================================================================

  /**
   * Realiza login do usuário
   *
   * TODO: Substituir lógica mock por chamada real à API quando backend estiver pronto
   * Endpoint esperado: POST /api/auth/login
   *
   * @param {string} email - Email do usuário
   * @param {string} password - Senha do usuário
   * @returns {Promise<AuthResponse>} Resposta com dados do usuário ou erro
   *
   * @example
   * ```tsx
   * const { data, error } = await signIn('user@example.com', 'password123');
   * if (error) {
   *   toast.error('Erro ao fazer login');
   * } else {
   *   toast.success('Login realizado!');
   * }
   * ```
   */
  const signIn = async (
    email: string,
    password: string
  ): Promise<AuthResponse> => {
    try {
      // -----------------------------------------------------------------------
      // MOCK IMPLEMENTATION - REMOVER QUANDO API ESTIVER PRONTA
      // -----------------------------------------------------------------------
      console.log('[useAuth] signIn - MOCK MODE', { email, password });

      // Simula delay de rede
      await new Promise(resolve => setTimeout(resolve, 500));

      // Cria usuário mock (em produção, viria da API)
      const mockUser: User = {
        id: `user_${Date.now()}`,
        email,
        name: 'Usuário Teste',
        userType: 'STUDENT',
        createdAt: new Date(),
        updatedAt: new Date(),
      } as User; // Type assertion para simplificar mock

      // Persiste no localStorage
      localStorage.setItem(STORAGE_KEY, JSON.stringify(mockUser));
      setUser(mockUser);

      return { data: mockUser, error: null };
      // -----------------------------------------------------------------------
      // FIM MOCK IMPLEMENTATION
      // -----------------------------------------------------------------------

      // -----------------------------------------------------------------------
      // IMPLEMENTAÇÃO REAL (descomentar quando API estiver pronta):
      // -----------------------------------------------------------------------
      // const response = await fetch('/api/auth/login', {
      //   method: 'POST',
      //   headers: { 'Content-Type': 'application/json' },
      //   body: JSON.stringify({ email, password })
      // });
      //
      // if (!response.ok) {
      //   throw new Error('Credenciais inválidas');
      // }
      //
      // const userData = await response.json();
      // localStorage.setItem(STORAGE_KEY, JSON.stringify(userData));
      // setUser(userData);
      //
      // return { data: userData, error: null };
      // -----------------------------------------------------------------------

    } catch (error) {
      console.error('[useAuth] Erro no signIn:', error);
      return {
        data: null,
        error: error instanceof Error ? error : new Error('Erro desconhecido ao fazer login')
      };
    }
  };

  /**
   * Registra novo usuário
   *
   * TODO: Substituir lógica mock por chamada real à API quando backend estiver pronto
   * Endpoint esperado: POST /api/auth/register
   *
   * @param {SignUpData} data - Dados do novo usuário
   * @returns {Promise<AuthResponse>} Resposta com dados do usuário ou erro
   *
   * @example
   * ```tsx
   * const { data, error } = await signUp({
   *   email: 'user@example.com',
   *   password: 'password123',
   *   name: 'João Silva',
   *   userType: 'STUDENT',
   *   campus: 'Bambuí',
   *   course: 'Engenharia de Software'
   * });
   * ```
   */
  const signUp = async (data: SignUpData): Promise<AuthResponse> => {
    try {
      // -----------------------------------------------------------------------
      // MOCK IMPLEMENTATION - REMOVER QUANDO API ESTIVER PRONTA
      // -----------------------------------------------------------------------
      console.log('[useAuth] signUp - MOCK MODE', { email: data.email, userType: data.userType });

      // Simula delay de rede
      await new Promise(resolve => setTimeout(resolve, 500));

      // Cria novo usuário baseado no tipo
      let newUser: User;

      switch (data.userType) {
        case 'STUDENT':
        case 'ALUMNI':
          newUser = {
            id: `user_${Date.now()}`,
            email: data.email,
            name: data.name,
            userType: data.userType,
            campus: data.campus || '',
            course: data.course || '',
            enrollmentYear: new Date().getFullYear(),
            skills: [],
            experiences: [],
            projects: [],
            isAlumni: data.userType === 'ALUMNI',
            createdAt: new Date(),
            updatedAt: new Date(),
          } as User;
          break;

        case 'TEACHER':
          newUser = {
            id: `user_${Date.now()}`,
            email: data.email,
            name: data.name,
            userType: data.userType,
            campus: data.campus || '',
            department: data.department || '',
            specialization: [],
            createdAt: new Date(),
            updatedAt: new Date(),
          } as User;
          break;

        case 'COMPANY':
          newUser = {
            id: `user_${Date.now()}`,
            email: data.email,
            name: data.name,
            userType: data.userType,
            cnpj: data.cnpj || '',
            description: '',
            createdAt: new Date(),
            updatedAt: new Date(),
          } as User;
          break;

        case 'ADMIN':
          newUser = {
            id: `user_${Date.now()}`,
            email: data.email,
            name: data.name,
            userType: data.userType,
            role: 'admin',
            createdAt: new Date(),
            updatedAt: new Date(),
          } as User;
          break;

        default:
          throw new Error('Tipo de usuário inválido');
      }

      // Persiste no localStorage
      localStorage.setItem(STORAGE_KEY, JSON.stringify(newUser));
      setUser(newUser);

      return { data: newUser, error: null };
      // -----------------------------------------------------------------------
      // FIM MOCK IMPLEMENTATION
      // -----------------------------------------------------------------------

      // -----------------------------------------------------------------------
      // IMPLEMENTAÇÃO REAL (descomentar quando API estiver pronta):
      // -----------------------------------------------------------------------
      // const response = await fetch('/api/auth/register', {
      //   method: 'POST',
      //   headers: { 'Content-Type': 'application/json' },
      //   body: JSON.stringify(data)
      // });
      //
      // if (!response.ok) {
      //   const errorData = await response.json();
      //   throw new Error(errorData.message || 'Erro ao criar conta');
      // }
      //
      // const userData = await response.json();
      // localStorage.setItem(STORAGE_KEY, JSON.stringify(userData));
      // setUser(userData);
      //
      // return { data: userData, error: null };
      // -----------------------------------------------------------------------

    } catch (error) {
      console.error('[useAuth] Erro no signUp:', error);
      return {
        data: null,
        error: error instanceof Error ? error : new Error('Erro desconhecido ao criar conta')
      };
    }
  };

  /**
   * Realiza logout do usuário
   * Remove dados da sessão e limpa localStorage
   *
   * @returns {Promise<void>}
   *
   * @example
   * ```tsx
   * await signOut();
   * toast.success('Logout realizado!');
   * navigate('/login');
   * ```
   */
  const signOut = async (): Promise<void> => {
    try {
      console.log('[useAuth] signOut');

      // Remove do localStorage
      localStorage.removeItem(STORAGE_KEY);

      // Limpa estado
      setUser(null);

      // TODO: Se houver token JWT, invalidar no backend
      // await fetch('/api/auth/logout', { method: 'POST' });

    } catch (error) {
      console.error('[useAuth] Erro no signOut:', error);
      // Mesmo com erro, limpa o estado local
      localStorage.removeItem(STORAGE_KEY);
      setUser(null);
      throw error;
    }
  };

  // ==========================================================================
  // RETURN
  // ==========================================================================

  return {
    user,
    session: user ? { user } : null,
    loading,
    signIn,
    signUp,
    signOut,
  };
};
