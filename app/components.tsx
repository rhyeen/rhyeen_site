import Link from "next/link";
import type { Project } from "./data";

const navItems = [
  ["Current projects", "/current-projects"],
  ["Previous projects", "/previous-projects"],
  ["Art & design", "/art-design"],
] as const;

export function Header() {
  return (
    <header className="site-header">
      <Link className="wordmark" href="/">Ryan Saunders</Link>
      <nav aria-label="Primary navigation">
        <ul className="nav-list">
          {navItems.map(([label, href]) => <li key={href}><Link href={href}>{label}</Link></li>)}
          <li><a href="/resume.pdf">Résumé <span className="file-type">PDF</span></a></li>
        </ul>
      </nav>
    </header>
  );
}

export function PageIntro({ eyebrow, title, children }: { eyebrow?: string; title: string; children?: React.ReactNode }) {
  return (
    <header className="page-intro">
      {eyebrow && <p className="eyebrow">{eyebrow}</p>}
      <h1>{title}</h1>
      {children && <div className="lede">{children}</div>}
    </header>
  );
}

export function ProjectList({ projects }: { projects: Project[] }) {
  return (
    <div className="project-list">
      {projects.map((project) => (
        <article className="project" key={project.title}>
          <div className="project-heading">
            <h2>{project.title}</h2>
            {project.date && <span className="project-date">{project.date}</span>}
          </div>
          {project.tools && <p className="project-tools">{project.tools}</p>}
          {project.description.map((paragraph) => <p key={paragraph}>{paragraph}</p>)}
          {project.link && (
            <a className="text-link" href={project.link.href} target={project.link.href.startsWith("http") ? "_blank" : undefined} rel={project.link.href.startsWith("http") ? "noreferrer" : undefined}>
              {project.link.label}<span aria-hidden="true"> ↗</span>
            </a>
          )}
          {project.links && (
            <div className="project-links">
              {project.links.map((link) => (
                <a
                  className="text-link"
                  href={link.href}
                  target={link.href.startsWith("http") ? "_blank" : undefined}
                  rel={link.href.startsWith("http") ? "noreferrer" : undefined}
                  key={link.href}
                >
                  {link.label}<span aria-hidden="true"> ↗</span>
                </a>
              ))}
            </div>
          )}
        </article>
      ))}
    </div>
  );
}
