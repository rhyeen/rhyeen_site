import Link from "next/link";
import { PageIntro } from "../components";

type GalleryImage = readonly [file: string, alt: string, overlay?: string];

export function GalleryPage({ title, folder, images }: { title: string; folder: string; images: readonly GalleryImage[] }) {
  return (
    <div className="content-page gallery-page">
      <PageIntro eyebrow="Art & design" title={title} />
      <div className="gallery">
        {images.map(([file, alt, overlay], index) => (
          <figure key={file}>
            <div
              className={`gallery-artwork${overlay ? " gallery-artwork-reveal" : ""}`}
              tabIndex={overlay ? 0 : undefined}
              aria-label={overlay ? `${alt}. Focus or hover to reveal the underlying image.` : undefined}
            >
              <img src={`/images/${folder}/${file}`} alt={alt} loading={index > 2 ? "lazy" : "eager"} />
              {overlay && (
                <img
                  className="gallery-image-overlay"
                  src={`/images/${folder}/${overlay}`}
                  alt=""
                  aria-hidden="true"
                  loading={index > 2 ? "lazy" : "eager"}
                />
              )}
            </div>
            <figcaption>{alt}</figcaption>
          </figure>
        ))}
      </div>
      <Link className="text-link back-link" href="/art-design">← Back to art & design</Link>
    </div>
  );
}
