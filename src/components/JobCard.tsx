import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Building2, MapPin, Clock, Briefcase, Loader2 } from "lucide-react";
import { useAuth } from "@/hooks/useAuth";
import { toast } from "sonner";
import { useState, useEffect } from "react";

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
    // Check localStorage for applications
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
      // Simulate API call delay
      await new Promise(resolve => setTimeout(resolve, 1000));
      
      // Save to localStorage
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
    <Card className="shadow-elegant hover:shadow-xl transition-smooth hover:border-primary">
      <CardHeader>
        <div className="flex items-start justify-between gap-2">
          <div className="flex-1">
            <CardTitle className="text-xl mb-1">{title}</CardTitle>
            <CardDescription className="flex items-center gap-2 text-base">
              <Building2 className="h-4 w-4" />
              {company}
            </CardDescription>
          </div>
          <Badge variant={type === "Estágio" ? "secondary" : "default"}>{type}</Badge>
        </div>
      </CardHeader>
      <CardContent className="space-y-4">
        <div className="flex flex-wrap gap-4 text-sm text-muted-foreground">
          <div className="flex items-center gap-1">
            <MapPin className="h-4 w-4" />
            {location}
          </div>
          <div className="flex items-center gap-1">
            <Clock className="h-4 w-4" />
            {workload}
          </div>
          {salary && (
            <div className="flex items-center gap-1">
              <Briefcase className="h-4 w-4" />
              {salary}
            </div>
          )}
        </div>
        <p className="text-sm text-foreground line-clamp-3">{description}</p>
        <div className="flex flex-wrap gap-2">
          {skills.map((skill, index) => (
            <Badge key={index} variant="outline" className="bg-primary-light">
              {skill}
            </Badge>
          ))}
        </div>
      </CardContent>
      <CardFooter>
        <Button
          className="w-full"
          onClick={handleApply}
          disabled={loading || hasApplied}
        >
          {loading ? (
            <>
              <Loader2 className="mr-2 h-4 w-4 animate-spin" />
              Enviando...
            </>
          ) : hasApplied ? (
            "Já Candidatado"
          ) : (
            "Candidatar-se"
          )}
        </Button>
      </CardFooter>
    </Card>
  );
};

export default JobCard;
