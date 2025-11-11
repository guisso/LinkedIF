import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Button } from "@/components/ui/button";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { MapPin, GraduationCap, Star, Building2, Briefcase } from "lucide-react";
import { type Profile } from "@/data/mockData";

interface ProfileCardProps {
  profile: Profile;
}

const ProfileCard = ({ profile }: ProfileCardProps) => {
  if (!profile) {
    return null;
  }
  
  const initials = profile?.full_name
    .split(" ")
    .map((n) => n[0])
    .join("")
    .toUpperCase()
    .slice(0, 2);

  const getUserTypeLabel = (type: string) => {
    const typeMap: Record<string, string> = {
      student: "Estudante",
      teacher: "Professor",
      company: "Empresa",
      admin: "Administrador",
    };
    return typeMap[type] || type;
  };

  return (
    <Card className="shadow-elegant hover:shadow-xl transition-smooth hover:border-primary">
      <CardHeader>
        <div className="flex items-start gap-4">
          <Avatar className="h-16 w-16 border-2 border-primary">
            <AvatarImage src={profile?.avatar_url} alt={profile?.full_name} />
            <AvatarFallback className="bg-primary text-primary-foreground text-lg">{initials}</AvatarFallback>
          </Avatar>
          <div className="flex-1">
            <CardTitle className="text-xl mb-1">{profile?.full_name}</CardTitle>
            <CardDescription className="space-y-1">
              <div className="flex items-center gap-1 text-sm">
                <Badge variant="outline">{getUserTypeLabel(profile?.user_type)}</Badge>
              </div>
              {profile?.user_type === 'student' && profile.course && (
                <div className="flex items-center gap-1 text-sm">
                  <GraduationCap className="h-4 w-4" />
                  {profile.course}
                </div>
              )}
              {profile?.user_type === 'student' && profile.campus && (
                <div className="flex items-center gap-1 text-sm">
                  <MapPin className="h-4 w-4" />
                  {profile.campus}
                </div>
              )}
              {profile?.user_type === 'teacher' && profile.department && (
                <div className="flex items-center gap-1 text-sm">
                  <Briefcase className="h-4 w-4" />
                  {profile.department}
                </div>
              )}
              {profile?.user_type === 'company' && profile.company_name && (
                <div className="flex items-center gap-1 text-sm">
                  <Building2 className="h-4 w-4" />
                  {profile.company_name}
                </div>
              )}
            </CardDescription>
          </div>
        </div>
      </CardHeader>
      <CardContent className="space-y-4">
        <p className="text-sm text-foreground line-clamp-2">{profile?.bio || "Sem descrição"}</p>
        {profile?.user_type === 'teacher' && profile.research_areas && profile.research_areas.length > 0 && (
          <div>
            <h4 className="text-sm font-semibold mb-2 flex items-center gap-1">
              <Star className="h-4 w-4 text-accent" />
              Áreas de Pesquisa
            </h4>
            <div className="flex flex-wrap gap-2">
              {profile.research_areas.slice(0, 5).map((area, index) => (
                <Badge key={index} variant="secondary" className="bg-primary-light">
                  {area}
                </Badge>
              ))}
              {profile.research_areas.length > 5 && (
                <Badge variant="outline" className="text-muted-foreground">
                  +{profile.research_areas.length - 5}
                </Badge>
              )}
            </div>
          </div>
        )}
        <Button variant="outline" className="w-full">
          Ver Perfil Completo
        </Button>
      </CardContent>
    </Card>
  );
};

export default ProfileCard;
