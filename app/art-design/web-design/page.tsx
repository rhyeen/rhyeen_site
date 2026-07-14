import { PageIntro, ProjectList } from "../../components";
import { webDesignProjects } from "../../data";

export const metadata = { title: "Web Design" };

export default function WebDesignPage() {
  return (
    <div className="content-page">
      <PageIntro eyebrow="Art & design" title="Web design">
        <p>Experimental and client websites designed over the years. Some are preserved as historical snapshots and may show their age.</p>
      </PageIntro>
      <ProjectList projects={webDesignProjects} />
    </div>
  );
}
