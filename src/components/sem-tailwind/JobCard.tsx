import { Building2, MapPin, Clock, Briefcase, Loader2 } from "lucide-react";
import { useAuth } from "@/hooks/useAuth";
import { toast } from "sonner";
import { useState, useEffect } from "react";
import "./jobcard.css";

interface JobCardProps {
  id: string;
  title: string;
  company: string;
  location: string;
  type: string;
  workload: string;
  salary?: string;
  description: string;
  skills: string[];
}

const JobCard = ({ id, title, company, location, type, workload, salary, description, skills }: JobCardProps) => {
  const { user } = useAuth();
  const [loading, setLoading] = useState(false);
  const [hasApplied, setHasApplied] = useState(false);

  useEffect(() => {
    if (user) {
      checkApplication();
    }
  }, [user, id]);

  const checkApplication = () => {
    const applications = JSON.parse(localStorage.getItem('applications') || '[]');
    const applied = applications.some((app: any) =>
      app.opportunity_id === id && app.applicant_id === user?.id
    );
    setHasApplied(applied);
  };

  const handleApply = async () => {
    if (!user) {
      toast.error("Você precisa estar logado para se candidatar");
      return;
    }

    setLoading(true);
    try {
      await new Promise(resolve => setTimeout(resolve, 1000));

      const applications = JSON.parse(localStorage.getItem('applications') || '[]');
      applications.push({
        id: Math.random().toString(36).substring(7),
        opportunity_id: id,
        applicant_id: user.id,
        status: "pending",
        created_at: new Date().toISOString(),
      });
      localStorage.setItem('applications', JSON.stringify(applications));

      toast.success("Candidatura enviada com sucesso!");
      setHasApplied(true);
    } catch (error: any) {
      toast.error("Erro ao enviar candidatura");
    } finally {
      setLoading(false);
    }
  };

  return (
    <article className="job-card" aria-labelledby={`job-${id}`}>
      <header className="job-card-header">
  <div className="job-card-main">
          <h3 id={`job-${id}`} className="job-card-title">{title}</h3>
          <div className="job-card-company">
            <Building2 className="icon" />
            <span>{company}</span>
          </div>
        </div>
        <div className={type === "Estágio" ? "badge badge-secondary" : "badge badge-outline"} aria-hidden>
          {type}
        </div>
      </header>

      <div className="job-card-content">
        <div className="job-card-meta">
          <div className="meta-item"><MapPin className="icon" />{location}</div>
          <div className="meta-item"><Clock className="icon" />{workload}</div>
          {salary && (<div className="meta-item"><Briefcase className="icon" />{salary}</div>)}
        </div>

        <p className="job-card-desc">{description}</p>

        <div className="badges" aria-hidden>
          {skills.map((skill, index) => (
            <span key={index} className="badge badge-outline">{skill}</span>
          ))}
        </div>
      </div>

      <footer className="job-card-footer">
        <button
          className={`btn btn-default ${loading || hasApplied ? 'btn-disabled' : ''}`}
          onClick={handleApply}
          disabled={loading || hasApplied}
          aria-disabled={loading || hasApplied ? 'true' : 'false'}
        >
          {loading ? (
            <>
              <Loader2 className="icon spin" /> Enviando...
            </>
          ) : hasApplied ? (
            'Já Candidatado'
          ) : (
            'Candidatar-se'
          )}
        </button>
      </footer>
    </article>
  );
};

export default JobCard;
