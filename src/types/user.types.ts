export const UserType = {
  STUDENT: 'STUDENT',
  ALUMNI: 'ALUMNI',
  TEACHER: 'TEACHER',
  COMPANY: 'COMPANY',
  ADMIN: 'ADMIN'
} as const;

export type UserType = typeof UserType[keyof typeof UserType];

export interface BaseUser {
  id: string;
  email: string;
  name: string;
  userType: UserType;
  createdAt: Date;
  updatedAt: Date;
}

export interface Student extends BaseUser {
  userType: typeof UserType.STUDENT | typeof UserType.ALUMNI;
  campus: string;
  course: string;
  enrollmentYear: number;
  photo?: string;
  about?: string;
  skills: string[];
  experiences: Experience[];
  projects: Project[];
  resumeUrl?: string;
  isAlumni: boolean;
  graduationYear?: number;
}

export interface Teacher extends BaseUser {
  userType: typeof UserType.TEACHER;
  campus: string;
  department: string;
  specialization: string[];
  photo?: string;
}

export interface Company extends BaseUser {
  userType: typeof UserType.COMPANY;
  cnpj: string;
  description: string;
  website?: string;
  logo?: string;
  address?: Address;
  contactPhone?: string;
}

export interface Admin extends BaseUser {
  userType: typeof UserType.ADMIN;
  campus?: string;
  role: string;
}

export interface Experience {
  id: string;
  title: string;
  company: string;
  description: string;
  startDate: Date;
  endDate?: Date;
  current: boolean;
}

export interface Project {
  id: string;
  name: string;
  description: string;
  technologies: string[];
  link?: string;
  date: Date;
}

export interface Address {
  street: string;
  number: string;
  complement?: string;
  neighborhood: string;
  city: string;
  state: string;
  zipCode: string;
}

export type User = Student | Teacher | Company | Admin;
