// Mock data for the application

export interface Profile {
  id: string;
  full_name: string;
  email: string;
  user_type: 'student' | 'teacher' | 'company' | 'admin';
  bio?: string;
  avatar_url?: string;
  phone?: string;
  visibility: 'public' | 'private';
  // Student specific
  student_id?: string;
  course?: string;
  campus?: string;
  // Company specific
  company_name?: string;
  cnpj?: string;
  // Teacher specific
  department?: string;
  research_areas?: string[];
  created_at: string;
}

export interface Opportunity {
  id: string;
  creator_id: string;
  title: string;
  description: string;
  opportunity_type: 'internship' | 'job' | 'research' | 'extension' | 'monitoring';
  location: string;
  is_remote: boolean;
  workload?: string;
  salary_range?: string;
  required_skills: string[];
  deadline?: string;
  created_at: string;
  creator?: Profile;
}

export interface Application {
  id: string;
  opportunity_id: string;
  applicant_id: string;
  status: 'pending' | 'under_review' | 'approved' | 'rejected';
  cover_letter?: string;
  created_at: string;
  opportunity?: Opportunity;
}

export interface Experience {
  id: string;
  profile_id: string;
  title: string;
  company: string;
  location: string;
  start_date: string;
  end_date?: string;
  description: string;
  is_current: boolean;
}

export interface Project {
  id: string;
  profile_id: string;
  title: string;
  description: string;
  technologies: string[];
  url?: string;
  start_date: string;
  end_date?: string;
}

// Mock Profiles
export const mockProfiles: Profile[] = [
  {
    id: '1',
    full_name: 'João Silva',
    email: 'joao.silva@ifnmg.edu.br',
    user_type: 'student',
    bio: 'Estudante de Sistemas de Informação, apaixonado por desenvolvimento web.',
    avatar_url: 'https://api.dicebear.com/7.x/avataaars/svg?seed=joao',
    phone: '(38) 99999-1111',
    visibility: 'public',
    student_id: '202101234',
    course: 'Sistemas de Informação',
    campus: 'Campus Montes Claros',
    created_at: '2024-01-15T00:00:00Z',
  },
  {
    id: '2',
    full_name: 'Maria Santos',
    email: 'maria.santos@ifnmg.edu.br',
    user_type: 'student',
    bio: 'Estudante de Análise e Desenvolvimento de Sistemas. Entusiasta de UX/UI Design.',
    avatar_url: 'https://api.dicebear.com/7.x/avataaars/svg?seed=maria',
    phone: '(38) 99999-2222',
    visibility: 'public',
    student_id: '202101235',
    course: 'Análise e Desenvolvimento de Sistemas',
    campus: 'Campus Montes Claros',
    created_at: '2024-01-20T00:00:00Z',
  },
  {
    id: '3',
    full_name: 'Prof. Carlos Mendes',
    email: 'carlos.mendes@ifnmg.edu.br',
    user_type: 'teacher',
    bio: 'Professor de Engenharia de Software e Banco de Dados.',
    avatar_url: 'https://api.dicebear.com/7.x/avataaars/svg?seed=carlos',
    phone: '(38) 99999-3333',
    visibility: 'public',
    department: 'Departamento de Informática',
    research_areas: ['Engenharia de Software', 'Banco de Dados', 'IA'],
    created_at: '2023-08-10T00:00:00Z',
  },
  {
    id: '4',
    full_name: 'Tech Solutions Ltda',
    email: 'contato@techsolutions.com.br',
    user_type: 'company',
    bio: 'Empresa de desenvolvimento de software focada em soluções web e mobile.',
    avatar_url: 'https://api.dicebear.com/7.x/initials/svg?seed=TS',
    phone: '(38) 3221-4444',
    visibility: 'public',
    company_name: 'Tech Solutions Ltda',
    cnpj: '12.345.678/0001-99',
    created_at: '2023-05-01T00:00:00Z',
  },
];

// Mock Opportunities
export const mockOpportunities: Opportunity[] = [
  {
    id: '1',
    creator_id: '4',
    title: 'Estágio em Desenvolvimento Web',
    description: 'Buscamos estudante de TI para estágio em desenvolvimento web com React e Node.js. Oportunidade de aprender e crescer em um ambiente dinâmico.',
    opportunity_type: 'internship',
    location: 'Montes Claros - MG',
    is_remote: false,
    workload: '20h semanais',
    salary_range: 'R$ 800 - R$ 1.200',
    required_skills: ['React', 'JavaScript', 'HTML', 'CSS'],
    deadline: '2025-12-31',
    created_at: '2024-11-01T00:00:00Z',
    creator: mockProfiles[3],
  },
  {
    id: '2',
    creator_id: '3',
    title: 'Bolsa de Iniciação Científica - IA',
    description: 'Projeto de pesquisa em Inteligência Artificial aplicada à saúde. Bolsa FAPEMIG disponível.',
    opportunity_type: 'research',
    location: 'IFNMG Campus Montes Claros',
    is_remote: false,
    workload: '20h semanais',
    salary_range: 'R$ 400',
    required_skills: ['Python', 'Machine Learning', 'Estatística'],
    deadline: '2025-11-30',
    created_at: '2024-10-15T00:00:00Z',
    creator: mockProfiles[2],
  },
  {
    id: '3',
    creator_id: '4',
    title: 'Desenvolvedor Full Stack Júnior',
    description: 'Vaga para desenvolvedor full stack com conhecimentos em React, Node.js e PostgreSQL. Regime CLT com benefícios.',
    opportunity_type: 'job',
    location: 'Montes Claros - MG',
    is_remote: true,
    workload: '40h semanais',
    salary_range: 'R$ 3.000 - R$ 4.500',
    required_skills: ['React', 'Node.js', 'PostgreSQL', 'Git'],
    deadline: '2025-12-15',
    created_at: '2024-10-25T00:00:00Z',
    creator: mockProfiles[3],
  },
  {
    id: '4',
    creator_id: '3',
    title: 'Monitoria de Programação Web',
    description: 'Vaga de monitoria para auxiliar nas disciplinas de programação web. Estudantes a partir do 3º período.',
    opportunity_type: 'monitoring',
    location: 'IFNMG Campus Montes Claros',
    is_remote: false,
    workload: '12h semanais',
    salary_range: 'R$ 400',
    required_skills: ['HTML', 'CSS', 'JavaScript', 'Didática'],
    deadline: '2025-11-20',
    created_at: '2024-11-05T00:00:00Z',
    creator: mockProfiles[2],
  },
];

// Mock Applications
export const mockApplications: Application[] = [
  {
    id: '1',
    opportunity_id: '1',
    applicant_id: '1',
    status: 'pending',
    cover_letter: 'Tenho grande interesse na área de desenvolvimento web e gostaria de aprender mais sobre React.',
    created_at: '2024-11-02T10:30:00Z',
    opportunity: mockOpportunities[0],
  },
  {
    id: '2',
    opportunity_id: '2',
    applicant_id: '1',
    status: 'under_review',
    cover_letter: 'Tenho interesse em IA e Python. Já fiz alguns projetos pessoais na área.',
    created_at: '2024-10-20T14:15:00Z',
    opportunity: mockOpportunities[1],
  },
  {
    id: '3',
    opportunity_id: '4',
    applicant_id: '2',
    status: 'approved',
    cover_letter: 'Adoro ensinar e ajudar colegas. Tenho boas notas em programação web.',
    created_at: '2024-11-06T09:00:00Z',
    opportunity: mockOpportunities[3],
  },
];

// Mock Experiences
export const mockExperiences: Experience[] = [
  {
    id: '1',
    profile_id: '1',
    title: 'Desenvolvedor Web Freelancer',
    company: 'Autônomo',
    location: 'Montes Claros - MG',
    start_date: '2023-06-01',
    description: 'Desenvolvimento de sites institucionais e landing pages usando React e WordPress.',
    is_current: true,
  },
  {
    id: '2',
    profile_id: '2',
    title: 'Estagiária de Design',
    company: 'Agência Digital XYZ',
    location: 'Montes Claros - MG',
    start_date: '2023-03-01',
    end_date: '2024-02-28',
    description: 'Criação de interfaces e prototipagem no Figma para projetos web.',
    is_current: false,
  },
];

// Mock Projects
export const mockProjects: Project[] = [
  {
    id: '1',
    profile_id: '1',
    title: 'Sistema de Gestão Escolar',
    description: 'Sistema web para gestão de alunos, professores e notas desenvolvido como projeto da faculdade.',
    technologies: ['React', 'Node.js', 'PostgreSQL', 'Express'],
    url: 'https://github.com/joaosilva/sistema-escolar',
    start_date: '2024-03-01',
    end_date: '2024-06-30',
  },
  {
    id: '2',
    profile_id: '1',
    title: 'App de Lista de Tarefas',
    description: 'Aplicativo mobile de lista de tarefas com sincronização em nuvem.',
    technologies: ['React Native', 'Firebase', 'TypeScript'],
    url: 'https://github.com/joaosilva/todo-app',
    start_date: '2024-08-01',
  },
  {
    id: '3',
    profile_id: '2',
    title: 'Portfolio Pessoal',
    description: 'Portfolio pessoal para mostrar projetos de design e desenvolvimento.',
    technologies: ['Next.js', 'Tailwind CSS', 'Framer Motion'],
    url: 'https://mariasantos.dev',
    start_date: '2024-01-15',
    end_date: '2024-02-28',
  },
];

// Helper functions to simulate API calls
export const getMockData = <T>(data: T[], delay = 500): Promise<T[]> => {
  return new Promise((resolve) => {
    setTimeout(() => resolve(data), delay);
  });
};

export const getMockDataById = <T extends { id: string }>(
  data: T[],
  id: string,
  delay = 500
): Promise<T | undefined> => {
  return new Promise((resolve) => {
    setTimeout(() => resolve(data.find((item) => item.id === id)), delay);
  });
};

export const filterMockData = <T>(
  data: T[],
  filterFn: (item: T) => boolean,
  delay = 500
): Promise<T[]> => {
  return new Promise((resolve) => {
    setTimeout(() => resolve(data.filter(filterFn)), delay);
  });
};
