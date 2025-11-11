import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import { toast } from "sonner";

interface User {
  id: string;
  email: string;
  full_name?: string;
  user_type?: string;
}

export const useAuth = () => {
  const [user, setUser] = useState<User | null>(null);
  const [loading, setLoading] = useState(true);
  const navigate = useNavigate();

  useEffect(() => {
    // Check for existing session in localStorage
    const storedUser = localStorage.getItem('user');
    if (storedUser) {
      try {
        setUser(JSON.parse(storedUser));
      } catch (e) {
        localStorage.removeItem('user');
      }
    }
    setLoading(false);
  }, []);

  const signUp = async (email: string, password: string, fullName: string, userType: string) => {
    try {
      // Mock signup - in a real app, this would call an API
      const newUser: User = {
        id: Math.random().toString(36).substring(7),
        email,
        full_name: fullName,
        user_type: userType,
      };
      
      localStorage.setItem('user', JSON.stringify(newUser));
      setUser(newUser);
      
      toast.success("Cadastro realizado com sucesso!");
      navigate("/");
      return { data: newUser, error: null };
    } catch (error: any) {
      toast.error(error.message || "Erro ao criar conta");
      return { data: null, error };
    }
  };

  const signIn = async (email: string, password: string) => {
    try {
      // Mock signin - in a real app, this would call an API
      const mockUser: User = {
        id: Math.random().toString(36).substring(7),
        email,
        full_name: "Usuário Teste",
        user_type: "student",
      };
      
      localStorage.setItem('user', JSON.stringify(mockUser));
      setUser(mockUser);
      
      toast.success("Login realizado com sucesso!");
      navigate("/");
      return { data: mockUser, error: null };
    } catch (error: any) {
      toast.error(error.message || "Erro ao fazer login");
      return { data: null, error };
    }
  };

  const signOut = async () => {
    try {
      localStorage.removeItem('user');
      setUser(null);
      
      toast.success("Logout realizado com sucesso!");
      navigate("/entrar");
    } catch (error: any) {
      toast.error(error.message || "Erro ao sair");
    }
  };

  return {
    user,
    session: user ? { user } : null,
    loading,
    signUp,
    signIn,
    signOut,
  };
};
