import { Link } from "react-router-dom";
import { Menu, Users, Briefcase, GraduationCap, Building2, User } from "lucide-react";
import { useState, useRef, useEffect } from "react";
import { useAuth } from "@/hooks/useAuth";
import "./navbar.css";

const Navbar = () => {
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [isUserMenuOpen, setIsUserMenuOpen] = useState(false);
  const { user, signOut } = useAuth();
  const userMenuRef = useRef<HTMLDivElement | null>(null);

  useEffect(() => {
    const onDoc = (e: MouseEvent) => {
      if (userMenuRef.current && !userMenuRef.current.contains(e.target as Node)) {
        setIsUserMenuOpen(false);
      }
    };
    document.addEventListener('click', onDoc);
    return () => document.removeEventListener('click', onDoc);
  }, []);

  return (
  <nav className="site-nav">
      <div className="container">
        <div className="site-nav-inner">
          <Link to="/" className="brand">
            <GraduationCap />
            <span>Banco de Talentos IFNMG</span>
          </Link>

          {/* Desktop Navigation */}
          <div className="nav-links" role="navigation" aria-label="Main navigation">
            <Link to="/">Início</Link>
            <Link to="/vagas">Vagas</Link>
            <Link to="/perfis">Perfis</Link>
            <Link to="/sobre">Sobre</Link>
          </div>

          <div className="actions">
            {user ? (
              <div className="user-menu" ref={userMenuRef}>
                  <button
                    type="button"
                    className="btn-ghost user-btn"
                    onClick={() => setIsUserMenuOpen(!isUserMenuOpen)}
                    aria-haspopup="true"
                    aria-label="Abrir menu do usuário"
                    aria-expanded={isUserMenuOpen ? 'true' : 'false'}
                  >
                    <span className="avatar" aria-hidden="true"><User /></span>
                  </button>
                {isUserMenuOpen && (
                  <div className="user-menu-panel" aria-label="Opções do usuário">
                    <Link to="/editar-perfil">Editar Perfil</Link>
                    <Link to="/minhas-candidaturas">Minhas Candidaturas</Link>
                    <button onClick={signOut}>Sair</button>
                  </div>
                )}
              </div>
            ) : (
              <>
                <Link to="/entrar" className="btn-ghost">Entrar</Link>
                <Link to="/cadastro" className="btn-primary">Cadastrar</Link>
              </>
            )}
          </div>

          {/* Mobile Menu Button */}
          <button
            onClick={() => setIsMenuOpen(!isMenuOpen)}
            className="mobile-toggle"
            aria-label="Abrir menu"
          >
            <Menu />
          </button>
        </div>

        {/* Mobile Navigation */}
        {isMenuOpen && (
          <div className="mobile-menu" aria-label="Navegação móvel">
            <Link to="/">Início</Link>
            <Link to="/vagas">Vagas</Link>
            <Link to="/perfis">Perfis</Link>
            <Link to="/sobre">Sobre</Link>
            <div className="mobile-sep">
              <Link to="/entrar">Entrar</Link>
              <Link to="/cadastro">Cadastrar</Link>
            </div>
          </div>
        )}
      </div>
    </nav>
  );
};

export default Navbar;
