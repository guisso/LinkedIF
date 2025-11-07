import React from 'react';
import { UserType } from '../../types';
import { useLogin } from './useLogin';
import './Login.css';

const Login: React.FC = () => {
  const {
    mode,
    userType,
    formData,
    error,
    handleInputChange,
    handleUserTypeChange,
    handleSubmit,
    switchToLogin,
    switchToRegister,
    toggleMode,
  } = useLogin();

  return (
    <div className="login-container">
      <div className="login-content">
        <div className="login-header">
          <div className="logo-section">
            <div className="logo-placeholder">IFNMG</div>
            <h1>LinkedIF</h1>
            <p className="tagline">Conectando talentos e oportunidades</p>
          </div>
        </div>

        <div className="login-card">
          <div className="tabs">
            <button
              className={`tab ${mode === 'login' ? 'active' : ''}`}
              onClick={switchToLogin}
              type="button"
            >
              Entrar
            </button>
            <button
              className={`tab ${mode === 'register' ? 'active' : ''}`}
              onClick={switchToRegister}
              type="button"
            >
              Cadastrar
            </button>
          </div>

          {error && (
            <div className="error-message">
              {error}
            </div>
          )}

          <form onSubmit={handleSubmit} className="login-form">
            {mode === 'register' && (
              <div className="form-group">
                <label htmlFor="userType">Tipo de usuário</label>
                <select
                  id="userType"
                  value={userType}
                  onChange={handleUserTypeChange}
                  className="form-select"
                >
                  <option value={UserType.STUDENT}>Aluno</option>
                  <option value={UserType.ALUMNI}>Ex-aluno</option>
                  <option value={UserType.TEACHER}>Professor</option>
                  <option value={UserType.COMPANY}>Empresa</option>
                </select>
              </div>
            )}

            {mode === 'register' && (
              <div className="form-group">
                <label htmlFor="name">Nome completo</label>
                <input
                  type="text"
                  id="name"
                  name="name"
                  value={formData.name}
                  onChange={handleInputChange}
                  placeholder="Digite seu nome completo"
                  required
                />
              </div>
            )}

            <div className="form-group">
              <label htmlFor="email">E-mail</label>
              <input
                type="email"
                id="email"
                name="email"
                value={formData.email}
                onChange={handleInputChange}
                placeholder="seu.email@exemplo.com"
                required
              />
            </div>

            <div className="form-group">
              <label htmlFor="password">Senha</label>
              <input
                type="password"
                id="password"
                name="password"
                value={formData.password}
                onChange={handleInputChange}
                placeholder="Digite sua senha"
                required
              />
            </div>

            {mode === 'register' && (
              <div className="form-group">
                <label htmlFor="confirmPassword">Confirmar senha</label>
                <input
                  type="password"
                  id="confirmPassword"
                  name="confirmPassword"
                  value={formData.confirmPassword}
                  onChange={handleInputChange}
                  placeholder="Digite sua senha novamente"
                  required
                />
              </div>
            )}

            {mode === 'register' && (userType === UserType.STUDENT || userType === UserType.ALUMNI) && (
              <>
                <div className="form-group">
                  <label htmlFor="campus">Campus</label>
                  <select
                    id="campus"
                    name="campus"
                    value={formData.campus}
                    onChange={handleInputChange}
                    required
                  >
                    <option value="">Selecione um campus</option>
                    <option value="Montes Claros">Montes Claros</option>
                    <option value="Almenara">Almenara</option>
                    <option value="Araçuaí">Araçuaí</option>
                    <option value="Arinos">Arinos</option>
                    <option value="Diamantina">Diamantina</option>
                    <option value="Januária">Januária</option>
                    <option value="Pirapora">Pirapora</option>
                    <option value="Porteirinha">Porteirinha</option>
                    <option value="Salinas">Salinas</option>
                  </select>
                </div>

                <div className="form-group">
                  <label htmlFor="course">Curso</label>
                  <input
                    type="text"
                    id="course"
                    name="course"
                    value={formData.course}
                    onChange={handleInputChange}
                    placeholder="Ex: Técnico em Informática"
                    required
                  />
                </div>
              </>
            )}

            {mode === 'register' && userType === UserType.TEACHER && (
              <>
                <div className="form-group">
                  <label htmlFor="campus">Campus</label>
                  <select
                    id="campus"
                    name="campus"
                    value={formData.campus}
                    onChange={handleInputChange}
                    required
                  >
                    <option value="">Selecione um campus</option>
                    <option value="Montes Claros">Montes Claros</option>
                    <option value="Almenara">Almenara</option>
                    <option value="Araçuaí">Araçuaí</option>
                    <option value="Arinos">Arinos</option>
                    <option value="Diamantina">Diamantina</option>
                    <option value="Januária">Januária</option>
                    <option value="Pirapora">Pirapora</option>
                    <option value="Porteirinha">Porteirinha</option>
                    <option value="Salinas">Salinas</option>
                  </select>
                </div>

                <div className="form-group">
                  <label htmlFor="department">Departamento</label>
                  <input
                    type="text"
                    id="department"
                    name="department"
                    value={formData.department}
                    onChange={handleInputChange}
                    placeholder="Ex: Informática"
                    required
                  />
                </div>
              </>
            )}

            {mode === 'register' && userType === UserType.COMPANY && (
              <div className="form-group">
                <label htmlFor="cnpj">CNPJ</label>
                <input
                  type="text"
                  id="cnpj"
                  name="cnpj"
                  value={formData.cnpj}
                  onChange={handleInputChange}
                  placeholder="00.000.000/0000-00"
                  required
                />
              </div>
            )}

            <button type="submit" className="btn-submit">
              {mode === 'login' ? 'Entrar' : 'Cadastrar'}
            </button>

            {mode === 'login' && (
              <div className="forgot-password">
                <a href="#">Esqueceu sua senha?</a>
              </div>
            )}
          </form>

          <div className="divider">
            <span>ou</span>
          </div>

          <div className="toggle-mode">
            <p>
              {mode === 'login'
                ? 'Não tem uma conta?'
                : 'Já tem uma conta?'}
              {' '}
              <button onClick={toggleMode} className="link-button" type="button">
                {mode === 'login' ? 'Cadastre-se' : 'Faça login'}
              </button>
            </p>
          </div>
        </div>

        <footer className="login-footer">
          <p>© 2025 IFNMG - Instituto Federal do Norte de Minas Gerais</p>
          <p>Campus Montes Claros</p>
        </footer>
      </div>
    </div>
  );
};

export default Login;
