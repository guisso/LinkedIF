import { Button } from "@/components/ui/button";
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import JobCard from "@/components/JobCard";
import ProfileCard from "@/components/ProfileCard";
import { Link } from "react-router-dom";
import { Users, Briefcase, Building2, Search, TrendingUp, Award } from "lucide-react";
import heroBanner from "@/assets/hero-banner.jpg";
import { type Profile } from "@/data/mockData";


const Index = () => {
  const recentJobs = [
    {
      title: "Desenvolvedor Web Full Stack",
      company: "Tech Solutions MG",
      location: "Montes Claros, MG",
      type: "Estágio",
      workload: "20h/semana",
      salary: "R$ 1.200,00",
      description: "Buscamos estudante de Informática para desenvolver aplicações web modernas utilizando React, Node.js e banco de dados PostgreSQL.",
      skills: ["React", "Node.js", "PostgreSQL", "JavaScript", "Git"],
    },
    {
      title: "Assistente de Engenharia Civil",
      company: "Construtora Norte",
      location: "Montes Claros, MG",
      type: "Emprego",
      workload: "40h/semana",
      salary: "R$ 2.500,00",
      description: "Oportunidade para ex-aluno de Engenharia Civil atuar em projetos de construção e infraestrutura urbana.",
      skills: ["AutoCAD", "Excel", "Gestão de Projetos", "Obras"],
    },
    {
      title: "Designer Gráfico",
      company: "Agência Criativa Digital",
      location: "Remoto",
      type: "Estágio",
      workload: "30h/semana",
      salary: "R$ 800,00",
      description: "Procuramos estudante criativo para criar peças visuais para redes sociais, websites e materiais impressos.",
      skills: ["Photoshop", "Illustrator", "Figma", "Design Gráfico"],
    },
  ];

  const featuredProfiles: Profile[] = [
    {
      id: 'mock-1',
      full_name: "Maria Silva Santos", 
      user_type: "student", 
      email: "maria.s@ifnmg.edu.br",
      visibility: 'public',
      course: "Técnico em Informática",
      campus: "IFNMG - Campus Montes Claros",
      bio: "Estudante apaixonada por desenvolvimento web e tecnologias inovadoras. Experiência em projetos de extensão e monitoria.",
      created_at: new Date().toISOString(),
    },
    {
      id: 'mock-2',
      full_name: "João Pedro Oliveira", 
      user_type: "student", 
      email: "joao.p@ifnmg.edu.br",
      visibility: 'public',
      course: "Engenharia Civil",
      campus: "IFNMG - Campus Montes Claros",
      bio: "Ex-aluno com 2 anos de experiência em construtoras. Especializado em projetos estruturais e orçamento de obras.",
      created_at: new Date().toISOString(),
    },
    {
      id: 'mock-3',
      full_name: "Prof. Ana Carolina",
      user_type: "teacher",
      email: "ana.carolina@ifnmg.edu.br",
      visibility: 'public',
      department: "Departamento de Design",
      research_areas: ["Photoshop", "Illustrator", "Figma", "UI/UX", "Branding", "Tipografia"],
      bio: "Designer e Professora criativa com portfólio diversificado. Premiada em competição nacional de design estudantil.",
      created_at: new Date().toISOString(),
    },
  ];

  return (
    <div className="min-h-screen flex flex-col">
      <Navbar />
      <section className="relative h-[600px] flex items-center justify-center overflow-hidden">
        <div
          className="absolute inset-0 bg-cover bg-center"
          style={{
            backgroundImage: `linear-gradient(135deg, rgba(0, 102, 51, 0.9), rgba(0, 102, 51, 0.7)), url(${heroBanner})`,
          }}
        />
        <div className="relative z-10 container mx-auto px-4 text-center text-primary-foreground">
          <h1 className="text-5xl md:text-6xl font-bold mb-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
            Conectando Talentos e Oportunidades
          </h1>
          <p className="text-xl md:text-2xl mb-8 max-w-3xl mx-auto animate-in fade-in slide-in-from-bottom-4 duration-700 delay-150">
            O Banco de Talentos do IFNMG une estudantes, ex-alunos, professores e empresas em uma plataforma de
            crescimento profissional
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center animate-in fade-in slide-in-from-bottom-4 duration-700 delay-300">
            <Button size="lg" variant="hero" asChild>
              <Link to="/cadastro">Cadastrar como Aluno</Link>
            </Button>
            <Button
              size="lg"
              variant="outline"
              asChild
              className="bg-background/10 backdrop-blur-sm border-primary-foreground text-primary-foreground hover:bg-background/20"
            >
              <Link to="/empresa/cadastro">Sou Empresa</Link>
            </Button>
          </div>
        </div>
      </section>

      <section className="py-12 bg-secondary">
        <div className="container mx-auto px-4">
          <div className="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            <div className="space-y-2">
              <Users className="h-12 w-12 mx-auto text-primary" />
              <p className="text-4xl font-bold text-primary">500+</p>
              <p className="text-muted-foreground">Alunos Cadastrados</p>
            </div>
            <div className="space-y-2">
              <Briefcase className="h-12 w-12 mx-auto text-primary" />
              <p className="text-4xl font-bold text-primary">120+</p>
              <p className="text-muted-foreground">Vagas Disponíveis</p>
            </div>
            <div className="space-y-2">
              <Building2 className="h-12 w-12 mx-auto text-primary" />
              <p className="text-4xl font-bold text-primary">80+</p>
              <p className="text-muted-foreground">Empresas Parceiras</p>
            </div>
            <div className="space-y-2">
              <Award className="h-12 w-12 mx-auto text-primary" />
              <p className="text-4xl font-bold text-primary">350+</p>
              <p className="text-muted-foreground">Contratações Realizadas</p>
            </div>
          </div>
        </div>
      </section>

      <section className="py-16 container mx-auto px-4">
        <h2 className="text-4xl font-bold text-center mb-4">Como Funciona</h2>
        <p className="text-center text-muted-foreground mb-12 max-w-2xl mx-auto">
          Uma plataforma simples e eficiente para conectar talentos do IFNMG com oportunidades
        </p>
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div className="text-center space-y-4">
            <div className="w-16 h-16 rounded-full bg-primary-light flex items-center justify-center mx-auto">
              <Users className="h-8 w-8 text-primary" />
            </div>
            <h3 className="text-xl font-semibold">Crie Seu Perfil</h3>
            <p className="text-muted-foreground">
              Cadastre-se e mostre suas habilidades, experiências e projetos para empresas e professores
            </p>
          </div>
          <div className="text-center space-y-4">
            <div className="w-16 h-16 rounded-full bg-primary-light flex items-center justify-center mx-auto">
              <Search className="h-8 w-8 text-primary" />
            </div>
            <h3 className="text-xl font-semibold">Encontre Oportunidades</h3>
            <p className="text-muted-foreground">
              Explore vagas de emprego, estágio e projetos de pesquisa alinhados ao seu perfil
            </p>
          </div>
          <div className="text-center space-y-4">
            <div className="w-16 h-16 rounded-full bg-primary-light flex items-center justify-center mx-auto">
              <TrendingUp className="h-8 w-8 text-primary" />
            </div>
            <h3 className="text-xl font-semibold">Cresça Profissionalmente</h3>
            <p className="text-muted-foreground">
              Conecte-se com empresas, desenvolva sua carreira e construa seu futuro profissional
            </p>
          </div>
        </div>
      </section>

      <section className="py-16 bg-muted">
        <div className="container mx-auto px-4">
          <div className="flex items-center justify-between mb-8">
            <div>
              <h2 className="text-4xl font-bold mb-2">Vagas Recentes</h2>
              <p className="text-muted-foreground">Oportunidades publicadas recentemente</p>
            </div>
            <Button variant="outline" asChild>
              <Link to="/vagas">Ver Todas as Vagas</Link>
            </Button>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {recentJobs.map((job, index) => (
              <JobCard key={index} id={`temp-${index}`} {...job} />
            ))}
          </div>
        </div>
      </section>

      <section className="py-16 container mx-auto px-4">
        <div className="flex items-center justify-between mb-8">
          <div>
            <h2 className="text-4xl font-bold mb-2">Perfis em Destaque</h2>
            <p className="text-muted-foreground">Conheça alguns dos nossos talentos</p>
          </div>
          <Button variant="outline" asChild>
            <Link to="/perfis">Ver Todos os Perfis</Link>
          </Button>
        </div>
        
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {featuredProfiles.map((profile, index) => (
            <ProfileCard key={index} profile={profile} /> 
          ))}
        </div>
      </section>

      <section className="py-20 gradient-hero text-primary-foreground">
        <div className="container mx-auto px-4 text-center">
          <h2 className="text-4xl font-bold mb-4">Pronto para Começar?</h2>
          <p className="text-xl mb-8 max-w-2xl mx-auto">
            Junte-se a centenas de estudantes e ex-alunos do IFNMG que já estão construindo suas carreiras
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button
              size="lg"
              variant="outline"
              asChild
              className="bg-background/10 backdrop-blur-sm border-primary-foreground text-primary-foreground hover:bg-background/20"
            >
              <Link to="/cadastro">Criar Minha Conta</Link>
            </Button>
            <Button
              size="lg"
              variant="outline"
              asChild
              className="bg-background/10 backdrop-blur-sm border-primary-foreground text-primary-foreground hover:bg-background/20"
            >
              <Link to="/sobre">Saiba Mais</Link>
            </Button>
          </div>
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default Index;