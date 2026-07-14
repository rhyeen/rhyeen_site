import { PageIntro, ProjectList } from "../components";
import { webDesignProjects, webProjects } from "../data";

export const metadata = { title: "Web Development & Design" };

export default function WebDevelopmentPage() {
  return (
    <div className="content-page">
      <PageIntro eyebrow="Archive" title="Web development">
        <p>Selected web applications, experiments, and interface work.</p>
      </PageIntro>
      <ProjectList projects={webProjects} />
      <PageIntro eyebrow="Archive" title="Web design">
        <p>Experimental and client websites designed over the years.</p>
      </PageIntro>
      <ProjectList projects={webDesignProjects} />
    </div>
  );
}
