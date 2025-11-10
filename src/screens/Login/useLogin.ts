import { useState } from 'react';
import type { ChangeEvent, FormEvent } from 'react';
import { UserType } from '../../types';
import { useNavigate } from 'react-router-dom';
import { toast } from 'sonner';
import { useAuthContext } from '../../context/AuthContext';
import type { SignUpData } from '../../hooks/useAuth';

export type LoginMode = 'login' | 'register';

export interface LoginFormData {
  email: string;
  password: string;
  confirmPassword: string;
  name: string;
  campus: string;
  course: string;
  cnpj: string;
  department: string;
}

const initialFormData: LoginFormData = {
  email: '',
  password: '',
  confirmPassword: '',
  name: '',
  campus: '',
  course: '',
  cnpj: '',
  department: '',
};

export const useLogin = () => {
  const [mode, setMode] = useState<LoginMode>('login');
  const [userType, setUserType] = useState<UserType>(UserType.STUDENT);
  const [formData, setFormData] = useState<LoginFormData>(initialFormData);
  const [error, setError] = useState<string>('');
  const navigate = useNavigate();
  const { signIn, signUp } = useAuthContext();
  const [isLoading, setIsLoading] = useState<boolean>(false);

  const handleInputChange = (e: ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));
    // Limpa o erro quando o usuário começa a digitar
    if (error) setError('');
  };

  const handleUserTypeChange = (e: ChangeEvent<HTMLSelectElement>) => {
    setUserType(e.target.value as UserType);
  };

  const validateForm = (): boolean => {
    if (!formData.email || !formData.password) {
      setError('Por favor, preencha todos os campos obrigatórios');
      return false;
    }

    if (mode === 'register') {
      if (!formData.name) {
        setError('Nome completo é obrigatório');
        return false;
      }

      if (formData.password !== formData.confirmPassword) {
        setError('As senhas não coincidem');
        return false;
      }

      if (formData.password.length < 6) {
        setError('A senha deve ter no mínimo 6 caracteres');
        return false;
      }

      if ((userType === UserType.STUDENT || userType === UserType.ALUMNI) &&
          (!formData.campus || !formData.course)) {
        setError('Campus e curso são obrigatórios');
        return false;
      }

      if (userType === UserType.TEACHER &&
          (!formData.campus || !formData.department)) {
        setError('Campus e departamento são obrigatórios');
        return false;
      }

      if (userType === UserType.COMPANY && !formData.cnpj) {
        setError('CNPJ é obrigatório');
        return false;
      }
    }

    return true;
  };

  const handleSubmit = async (e: FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    setError('');

    if (!validateForm()) {
      return;
    }

    setIsLoading(true);

    try {
      if (mode === 'login') {
        // LOGIN
        const { data, error } = await signIn(formData.email, formData.password);

        if (error || !data) {
          setError('Email ou senha incorretos');
          toast.error('Erro ao fazer login. Verifique suas credenciais.');
          return;
        }

        toast.success(`Bem-vindo(a), ${data.name}!`);
        navigate('/');

      } else {
        // CADASTRO
        const signUpData: SignUpData = {
          email: formData.email,
          password: formData.password,
          name: formData.name,
          userType,
        };

        // Adiciona campos específicos por tipo
        if (userType === UserType.STUDENT || userType === UserType.ALUMNI) {
          signUpData.campus = formData.campus;
          signUpData.course = formData.course;
        } else if (userType === UserType.TEACHER) {
          signUpData.campus = formData.campus;
          signUpData.department = formData.department;
        } else if (userType === UserType.COMPANY) {
          signUpData.cnpj = formData.cnpj;
        }

        const { data, error } = await signUp(signUpData);

        if (error || !data) {
          setError('Erro ao criar conta. Tente novamente.');
          toast.error('Erro ao criar conta.');
          return;
        }

        toast.success('Conta criada com sucesso!');
        navigate('/');
      }
    } catch (err) {
      console.error('[useLogin] Erro:', err);
      setError('Ocorreu um erro inesperado.');
      toast.error('Erro inesperado.');
    } finally {
      setIsLoading(false);
    }
  };

  const toggleMode = () => {
    setMode(mode === 'login' ? 'register' : 'login');
    setFormData(initialFormData);
    setError('');
  };

  const switchToLogin = () => {
    setMode('login');
    setFormData(initialFormData);
    setError('');
  };

  const switchToRegister = () => {
    setMode('register');
    setFormData(initialFormData);
    setError('');
  };

  return {
    mode,
    userType,
    formData,
    error,
    isLoading,
    handleInputChange,
    handleUserTypeChange,
    handleSubmit,
    toggleMode,
    switchToLogin,
    switchToRegister,
  };
};
