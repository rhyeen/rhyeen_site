import { PageIntro, ProjectList } from "../components";
import { previousProjects } from "../data";

export const metadata = { title: "Previous Projects" };

export default function PreviousProjectsPage() {
  return (
    <div className="content-page">
      <PageIntro eyebrow="Selected archive" title="Previous projects">
        <p>A selection of software, research, games, and experiments from over the years.</p>
      </PageIntro>
      <ProjectList projects={previousProjects} />
    </div>
  );
}
