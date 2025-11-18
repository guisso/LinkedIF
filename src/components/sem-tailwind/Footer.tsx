import { GraduationCap, Mail, Phone, MapPin } from "lucide-react";
import { Link } from "react-router-dom";
import "./footer.css";

const Footer = () => {
  return (
    <footer className="site-footer">
      <div className="container">
        <div className="footer-inner">
          <div className="footer">
            <div className="brand-row">
              <GraduationCap />
              <span className="title">Banco de Talentos</span>
            </div>
            <p>Conectando talentos do IFNMG com oportunidades de crescimento profissional.</p>
          </div>

          <div className="footer">
            <h3>Links Rápidos</h3>
            <ul>
              <li><Link to="/">Início</Link></li>
              <li><Link to="/vagas">Vagas</Link></li>
              <li><Link to="/perfis">Perfis</Link></li>
              <li><Link to="/sobre">Sobre</Link></li>
            </ul>
          </div>

          <div className="footer">
            <h3>Para Empresas</h3>
            <ul>
              <li><Link to="/empresa/cadastro">Cadastrar Empresa</Link></li>
              <li><Link to="/empresa/vagas">Publicar Vaga</Link></li>
            </ul>
          </div>

          <div className="footer">
            <h3>Contato</h3>
            <ul className="contact">
              <li><MapPin /> <span>IFNMG - Campus Montes Claros</span></li>
              <li><Phone /> <span>(38) 3229-8100</span></li>
              <li><Mail /> <span>contato@ifnmg.edu.br</span></li>
            </ul>
          </div>
        </div>

        <div className="footer-bottom">
          <p>© 2025 IFNMG - Campus Montes Claros. Todos os direitos reservados.</p>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
