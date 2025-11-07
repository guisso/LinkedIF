export const JobType = {
  INTERNSHIP: 'INTERNSHIP',
  FULL_TIME: 'FULL_TIME',
  PART_TIME: 'PART_TIME',
  TEMPORARY: 'TEMPORARY',
  FREELANCE: 'FREELANCE'
} as const;

export type JobType = typeof JobType[keyof typeof JobType];

export const JobLocation = {
  REMOTE: 'REMOTE',
  ON_SITE: 'ON_SITE',
  HYBRID: 'HYBRID'
} as const;

export type JobLocation = typeof JobLocation[keyof typeof JobLocation];

export const JobStatus = {
  OPEN: 'OPEN',
  CLOSED: 'CLOSED',
  PAUSED: 'PAUSED'
} as const;

export type JobStatus = typeof JobStatus[keyof typeof JobStatus];

export interface Job {
  id: string;
  title: string;
  description: string;
  companyId: string;
  companyName: string;
  requirements: string[];
  responsibilities: string[];
  skills: string[];
  jobType: JobType;
  location: JobLocation;
  city?: string;
  state?: string;
  workload: string;
  salary?: {
    min?: number;
    max?: number;
    currency: string;
  };
  benefits?: string[];
  status: JobStatus;
  applicants: string[];
  createdAt: Date;
  updatedAt: Date;
  closedAt?: Date;
}

export const ApplicationStatus = {
  PENDING: 'PENDING',
  REVIEWING: 'REVIEWING',
  ACCEPTED: 'ACCEPTED',
  REJECTED: 'REJECTED',
  WITHDRAWN: 'WITHDRAWN'
} as const;

export type ApplicationStatus = typeof ApplicationStatus[keyof typeof ApplicationStatus];

export interface JobApplication {
  id: string;
  jobId: string;
  studentId: string;
  coverLetter?: string;
  status: ApplicationStatus;
  appliedAt: Date;
  updatedAt: Date;
}
