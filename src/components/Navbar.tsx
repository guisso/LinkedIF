import { Button } from "@/components/ui/button";
import { Link } from "react-router-dom";
import { Menu, Users, Briefcase, GraduationCap, Building2, User } from "lucide-react";
import { useState } from "react";
import { useAuth } from "@/hooks/useAuth";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";

const Navbar = () => {
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const { user, signOut } = useAuth();

  return (
    <nav className="sticky top-0 z-50 bg-background/95 backdrop-blur-sm border-b border-border shadow-sm">
      <div className="container mx-auto px-4">
        <div className="flex items-center justify-between h-16">
          <Link to="/" className="flex items-center gap-2 font-bold text-xl text-primary">
            <GraduationCap className="h-8 w-8" />
            <span>Banco de Talentos IFNMG</span>
          </Link>

          {/* Desktop Navigation */}
          <div className="hidden md:flex items-center gap-6">
            <Link to="/" className="text-foreground hover:text-primary transition-smooth">
              Início
            </Link>
            <Link to="/vagas" className="text-foreground hover:text-primary transition-smooth">
              Vagas
            </Link>
            <Link to="/perfis" className="text-foreground hover:text-primary transition-smooth">
              Perfis
            </Link>
            <Link to="/sobre" className="text-foreground hover:text-primary transition-smooth">
              Sobre
            </Link>
          </div>

          <div className="hidden md:flex items-center gap-3">
            {user ? (
              <DropdownMenu>
                <DropdownMenuTrigger asChild>
                  <Button variant="ghost" className="gap-2">
                    <User className="h-4 w-4" />
                    Minha Conta
                  </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end">
                  <DropdownMenuItem asChild>
                    <Link to="/editar-perfil">Editar Perfil</Link>
                  </DropdownMenuItem>
                  <DropdownMenuItem asChild>
                    <Link to="/minhas-candidaturas">Minhas Candidaturas</Link>
                  </DropdownMenuItem>
                  <DropdownMenuSeparator />
                  <DropdownMenuItem onClick={signOut}>Sair</DropdownMenuItem>
                </DropdownMenuContent>
              </DropdownMenu>
            ) : (
              <>
                <Button variant="ghost" asChild>
                  <Link to="/entrar">Entrar</Link>
                </Button>
                <Button asChild>
                  <Link to="/cadastro">Cadastrar</Link>
                </Button>
              </>
            )}
          </div>

          {/* Mobile Menu Button */}
          <button
            onClick={() => setIsMenuOpen(!isMenuOpen)}
            className="md:hidden p-2 hover:bg-secondary rounded-md transition-smooth"
          >
            <Menu className="h-6 w-6" />
          </button>
        </div>

        {/* Mobile Navigation */}
        {isMenuOpen && (
          <div className="md:hidden py-4 border-t border-border">
            <div className="flex flex-col gap-3">
              <Link to="/" className="px-4 py-2 hover:bg-secondary rounded-md transition-smooth">
                Início
              </Link>
              <Link to="/vagas" className="px-4 py-2 hover:bg-secondary rounded-md transition-smooth">
                Vagas
              </Link>
              <Link to="/perfis" className="px-4 py-2 hover:bg-secondary rounded-md transition-smooth">
                Perfis
              </Link>
              <Link to="/sobre" className="px-4 py-2 hover:bg-secondary rounded-md transition-smooth">
                Sobre
              </Link>
              <div className="flex flex-col gap-2 px-4 pt-3 border-t border-border mt-3">
                <Button variant="ghost" asChild className="w-full">
                  <Link to="/entrar">Entrar</Link>
                </Button>
                <Button asChild className="w-full">
                  <Link to="/cadastro">Cadastrar</Link>
                </Button>
              </div>
            </div>
          </div>
        )}
      </div>
    </nav>
  );
};

export default Navbar;
