import Link from "next/link";
import { PageIntro } from "../components";

export const metadata = { title: "Art & Design" };

const sections = [
  { href: "/art-design/graphic-design", index: "01", title: "Graphic design", detail: "Identity, posters, and apparel" },
  { href: "/art-design/art", index: "02", title: "Art", detail: "Painting, ink, and digital studies" },
  { href: "/art-design/photography", index: "03", title: "Photography", detail: "Portraits, travel, and landscapes" },
  { href: "/art-design/web-design", index: "04", title: "Web design", detail: "A collection of archived websites" },
] as const;

export default function ArtDesignPage() {
  return (
    <div className="content-page">
      <PageIntro eyebrow="Visual work" title="Art & design">
        <p>A collection of visual work across physical and digital media.</p>
      </PageIntro>
      <div className="discipline-list">
        {sections.map((section) => (
          <Link href={section.href} className="discipline" key={section.href}>
            <span>{section.index}</span><strong>{section.title}</strong><small>{section.detail}</small><b aria-hidden="true">→</b>
          </Link>
        ))}
      </div>
    </div>
  );
}
