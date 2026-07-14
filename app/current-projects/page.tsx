import { PageIntro, ProjectList } from "../components";
import { currentProjects } from "../data";

export const metadata = { title: "Current Projects" };

export default function CurrentProjectsPage() {
  return (
    <div className="content-page">
      <PageIntro eyebrow="Selected work" title="Current projects">
        <p>Personal projects I’m actively exploring, building, and refining.</p>
      </PageIntro>
      <ProjectList projects={currentProjects} />
    </div>
  );
}
