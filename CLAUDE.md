# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

LinkedIF is a talent bank platform for IFNMG (Instituto Federal do Norte de Minas Gerais) that connects students, alumni, teachers, and companies. The platform enables students to showcase their skills, companies to post job openings, and teachers to find students for research projects.

**Design System**: Professional, clean, LinkedIn-inspired interface using IFNMG institutional colors (green #006633, white, light gray).

## Development Commands

```bash
# Start development server with hot reload
npm run dev

# Build for production (runs TypeScript compiler then Vite build)
npm run build

# Run ESLint
npm run lint

# Preview production build locally
npm run preview
```

## Architecture

### Code Organization Pattern

This project follows a **strict separation of concerns** pattern for screens/pages:

```
src/screens/[ScreenName]/
├── [ScreenName].tsx      # UI component (presentation only)
├── [ScreenName].css      # Styles
├── use[ScreenName].ts    # Business logic (custom hook)
└── index.ts              # Export barrel
```

**Key principles:**
- **Presentation components** (.tsx): Only JSX, HTML structure, and UI rendering. No business logic.
- **Logic hooks** (.ts): All state management, handlers, validation, and business logic. Export a single hook.
- **Styles** (.css): All styling separated from components.

Example from `src/screens/Login/`:
- `Login.tsx` imports and uses `useLogin()` hook
- `useLogin.ts` contains all form state, validation, handlers
- `Login.css` contains all styles

### TypeScript Configuration

**Important**: The project uses strict TypeScript settings:
- `verbatimModuleSyntax: true` - Type imports must use `import type { ... }`
- `erasableSyntaxOnly: true` - Cannot use TypeScript enums

**Pattern for enum-like types:**
```typescript
// ❌ Don't use enum
export enum UserType { STUDENT = 'STUDENT' }

// ✅ Use const object with type
export const UserType = {
  STUDENT: 'STUDENT',
  ALUMNI: 'ALUMNI'
} as const;

export type UserType = typeof UserType[keyof typeof UserType];
```

**Type imports:**
```typescript
// ❌ Don't
import { useState, ChangeEvent } from 'react';

// ✅ Do
import { useState } from 'react';
import type { ChangeEvent } from 'react';
```

### Type System

Located in `src/types/`:

**User types** (`user.types.ts`):
- `UserType`: STUDENT, ALUMNI, TEACHER, COMPANY, ADMIN
- Interfaces: `Student`, `Teacher`, `Company`, `Admin` (all extend `BaseUser`)
- `Experience`, `Project`, `Address` supporting interfaces

**Job types** (`job.types.ts`):
- `JobType`: INTERNSHIP, FULL_TIME, PART_TIME, TEMPORARY, FREELANCE
- `JobLocation`: REMOTE, ON_SITE, HYBRID
- `JobStatus`: OPEN, CLOSED, PAUSED
- `ApplicationStatus`: PENDING, REVIEWING, ACCEPTED, REJECTED, WITHDRAWN
- Interfaces: `Job`, `JobApplication`

### Styling

**Global styles** (`src/index.css`):
- CSS variables for IFNMG colors, shadows, border-radius
- Global resets and base styles
- Utility classes (`.container`, `.card`, margin/padding helpers)
- Inter font from Google Fonts

**Color variables:**
```css
--primary-green: #006633
--primary-green-dark: #004d26
--primary-green-light: #00854d
--gray-light: #f5f5f5
--gray-medium: #e0e0e0
--error: #d32f2f
--success: #2e7d32
```

### Folder Structure

```
src/
├── components/     # Reusable UI components
├── screens/        # Page-level components (with hooks pattern)
├── hooks/          # Shared custom hooks
├── services/       # API calls and external services
├── types/          # TypeScript type definitions
├── context/        # React Context providers
├── utils/          # Utility functions
└── assets/         # Static assets (images, icons)
```

## Project Specifications

Full project requirements are documented in `docs/prompt_inicial.txt`, including:

**User types and features:**
1. **Students/Alumni**: Profile with skills, experiences, projects, resume upload
2. **Companies**: Post and manage job openings, view applicants
3. **Teachers**: Search students by skills and courses
4. **Admin**: View statistics, export reports

**IFNMG Campuses** (for dropdowns):
Montes Claros, Almenara, Araçuaí, Arinos, Diamantina, Januária, Pirapora, Porteirinha, Salinas

## Tech Stack

- **React 19** with TypeScript
- **Vite 7** for build tooling
- **CSS3** with CSS Variables (no CSS-in-JS or preprocessors)
- No routing library yet (to be added)
- No state management library yet (to be added)

## Important Notes

- Always run `npm run build` to verify TypeScript compilation before committing
- When creating new screens, follow the separation of concerns pattern (component + hook + css)
- Use `const` objects instead of `enum` for type-safe constants
- Import types using `import type` syntax
