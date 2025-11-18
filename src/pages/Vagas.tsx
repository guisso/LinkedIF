import { useState, useEffect } from "react";
import Navbar from "@/components/sem-tailwind/Navbar";
import Footer from "@/components/sem-tailwind/Footer";
import JobCard from "@/components/sem-tailwind/JobCard";
import { Search, Filter } from "lucide-react";
import { mockOpportunities, getMockData, type Opportunity } from "@/data/mockData";
import "./vagas.css";

const Vagas = () => {
  const [searchTerm, setSearchTerm] = useState("");
  const [filterType, setFilterType] = useState("all");
  const [filterLocation, setFilterLocation] = useState("all");
  const [loading, setLoading] = useState(true);
  const [opportunities, setOpportunities] = useState<Opportunity[]>([]);

  useEffect(() => {
    loadOpportunities();
  }, []);

  const loadOpportunities = async () => {
    try {
      const data = await getMockData(mockOpportunities);
      setOpportunities(data);
    } catch (error) {
      console.error("Erro ao carregar oportunidades");
    } finally {
      setLoading(false);
    }
  };

  const getTypeLabel = (type: string) => {
    const typeMap: Record<string, string> = {
      internship: "Estágio",
      job: "Emprego",
      research: "Pesquisa",
      extension: "Extensão",
      monitoring: "Monitoria",
    };
    return typeMap[type] || type;
  };

  const filteredOpportunities = opportunities.filter((opp) => {
    const matchesSearch =
      searchTerm === "" ||
      opp.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
      opp.description.toLowerCase().includes(searchTerm.toLowerCase());

    const matchesType = filterType === "all" || opp.opportunity_type === filterType;

    const matchesLocation =
      filterLocation === "all" ||
      (filterLocation === "remoto" && opp.is_remote) ||
      opp.location?.toLowerCase().includes(filterLocation.toLowerCase());

    return matchesSearch && matchesType && matchesLocation;
  });

  return (
    <div className="page-root">
      <Navbar />

      {/* Hero Section */}
      <section className="hero">
        <div className="container">
          <h1>Vagas Disponíveis</h1>
          <p>Explore oportunidades de emprego e estágio para estudantes e ex-alunos do IFNMG</p>
        </div>
      </section>

      {/* Filters Section */}
      <section className="filters">
        <div className="container">
          <div className="filters-inner">
            <div className="search-wrap">
              <Search className="search-icon" />
              <input
                className="input"
                placeholder="Buscar por cargo, empresa ou habilidade..."
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
              />
            </div>

            <label className="sr-only" htmlFor="filterType">Tipo de vaga</label>
            <select id="filterType" className="select" value={filterType} onChange={(e) => setFilterType(e.target.value)} aria-label="Tipo de vaga">
              <option value="all">Todos os tipos</option>
              <option value="internship">Estágio</option>
              <option value="job">Emprego</option>
              <option value="research">Pesquisa</option>
              <option value="monitoring">Monitoria</option>
            </select>

            <label className="sr-only" htmlFor="filterLocation">Localização</label>
            <select id="filterLocation" className="select" value={filterLocation} onChange={(e) => setFilterLocation(e.target.value)} aria-label="Localização">
              <option value="all">Todas as cidades</option>
              <option value="montes-claros">Montes Claros</option>
              <option value="remoto">Remoto</option>
            </select>

            <button className="btn btn-outline">
              <Filter style={{ marginRight: 8 }} />
              Mais Filtros
            </button>
          </div>
        </div>
      </section>

      {/* Jobs Grid */}
      <section className="grid-section">
        <div className="container">
          {loading ? (
            <div className="spinner-wrap">
              <div className="spinner" />
            </div>
          ) : (
            <>
              <div className="meta">
                Exibindo <strong>{filteredOpportunities.length}</strong> vagas disponíveis
              </div>

              {filteredOpportunities.length === 0 ? (
                <div className="empty-state">
                  <p className="muted">Nenhuma oportunidade encontrada com os filtros selecionados.</p>
                </div>
              ) : (
                <div className="card-grid">
                  {filteredOpportunities.map((opp) => (
                    <JobCard
                      key={opp.id}
                      id={opp.id}
                      title={opp.title}
                      company={opp.creator?.full_name || opp.creator?.company_name || "IFNMG"}
                      location={opp.location || (opp.is_remote ? "Remoto" : "Não especificado")}
                      type={getTypeLabel(opp.opportunity_type)}
                      workload={opp.workload || "A combinar"}
                      salary={opp.salary_range || "A combinar"}
                      description={opp.description}
                      skills={opp.required_skills || []}
                    />
                  ))}
                </div>
              )}
            </>
          )}
          <div className="load-more">
            <button className="btn btn-outline">Carregar Mais</button>
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="cta">
        <div className="container">
          <h2>Não encontrou a vaga ideal?</h2>
          <p className="muted">Crie seu perfil e seja encontrado por empresas que procuram profissionais com seu perfil</p>
          <button className="btn btn-primary">Criar Meu Perfil</button>
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default Vagas;
