import Link from "next/link";

export default function HomePage() {
  return (
    <section className="hero">
      <p className="eyebrow">Software engineer · Creative technologist</p>
      <h1>Full-stack thinking,<br /><em>from systems to pixels.</em></h1>
      <p className="hero-copy">
        I’m a software engineer with experience across full-stack web development,
        networked systems, and product design. I care about clean code, useful
        documentation, thoughtful interfaces, and technology that serves people well.
      </p>
      <div className="hero-actions">
        <Link className="button" href="/current-projects">Explore my work</Link>
        <a className="text-link" href="/resume.pdf">Read my résumé <span aria-hidden="true">↗</span></a>
      </div>
    </section>
  );
}
