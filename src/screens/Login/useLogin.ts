import { useState } from 'react';
import type { ChangeEvent, FormEvent } from 'react';
import { UserType } from '../../types';

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

  const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    setError('');

    if (!validateForm()) {
      return;
    }

    // TODO: Implementar lógica de autenticação/cadastro
    console.log('Form submitted:', { mode, userType, formData });

    // Simulação de sucesso
    if (mode === 'login') {
      console.log('Login realizado com sucesso');
      // Aqui você implementará a navegação para a tela principal
    } else {
      console.log('Cadastro realizado com sucesso');
      // Aqui você implementará a navegação ou mudança para login
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
    handleInputChange,
    handleUserTypeChange,
    handleSubmit,
    toggleMode,
    switchToLogin,
    switchToRegister,
  };
};
