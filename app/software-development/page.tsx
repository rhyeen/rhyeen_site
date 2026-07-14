import { PageIntro, ProjectList } from "../components";
import { softwareProjects } from "../data";

export const metadata = { title: "Software Development" };

export default function SoftwareDevelopmentPage() {
  return (
    <div className="content-page">
      <PageIntro eyebrow="Archive" title="Software development">
        <p>A selection of application, networking, research, and systems projects.</p>
      </PageIntro>
      <ProjectList projects={softwareProjects} />
    </div>
  );
}
