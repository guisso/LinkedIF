import { GraduationCap, Mail, Phone, MapPin } from "lucide-react";
import { Link } from "react-router-dom";

const Footer = () => {
  return (
    <footer className="bg-primary text-primary-foreground mt-20">
      <div className="container mx-auto px-4 py-12">
        <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
          <div>
            <div className="flex items-center gap-2 mb-4">
              <GraduationCap className="h-8 w-8" />
              <span className="font-bold text-lg">Banco de Talentos</span>
            </div>
            <p className="text-sm text-primary-foreground/80">
              Conectando talentos do IFNMG com oportunidades de crescimento profissional.
            </p>
          </div>

          <div>
            <h3 className="font-semibold mb-4">Links Rápidos</h3>
            <ul className="space-y-2 text-sm">
              <li>
                <Link to="/" className="text-primary-foreground/80 hover:text-primary-foreground transition-smooth">
                  Início
                </Link>
              </li>
              <li>
                <Link to="/vagas" className="text-primary-foreground/80 hover:text-primary-foreground transition-smooth">
                  Vagas
                </Link>
              </li>
              <li>
                <Link to="/perfis" className="text-primary-foreground/80 hover:text-primary-foreground transition-smooth">
                  Perfis
                </Link>
              </li>
              <li>
                <Link to="/sobre" className="text-primary-foreground/80 hover:text-primary-foreground transition-smooth">
                  Sobre
                </Link>
              </li>
            </ul>
          </div>

          <div>
            <h3 className="font-semibold mb-4">Para Empresas</h3>
            <ul className="space-y-2 text-sm">
              <li>
                <Link to="/empresa/cadastro" className="text-primary-foreground/80 hover:text-primary-foreground transition-smooth">
                  Cadastrar Empresa
                </Link>
              </li>
              <li>
                <Link to="/empresa/vagas" className="text-primary-foreground/80 hover:text-primary-foreground transition-smooth">
                  Publicar Vaga
                </Link>
              </li>
            </ul>
          </div>

          <div>
            <h3 className="font-semibold mb-4">Contato</h3>
            <ul className="space-y-2 text-sm">
              <li className="flex items-start gap-2 text-primary-foreground/80">
                <MapPin className="h-4 w-4 mt-0.5 flex-shrink-0" />
                <span>IFNMG - Campus Montes Claros</span>
              </li>
              <li className="flex items-center gap-2 text-primary-foreground/80">
                <Phone className="h-4 w-4" />
                <span>(38) 3229-8100</span>
              </li>
              <li className="flex items-center gap-2 text-primary-foreground/80">
                <Mail className="h-4 w-4" />
                <span>contato@ifnmg.edu.br</span>
              </li>
            </ul>
          </div>
        </div>

        <div className="border-t border-primary-foreground/20 mt-8 pt-8 text-center text-sm text-primary-foreground/80">
          <p>© 2025 IFNMG - Campus Montes Claros. Todos os direitos reservados.</p>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
