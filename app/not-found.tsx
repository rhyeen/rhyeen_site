import Link from "next/link";

export default function NotFound() {
  return (
    <section className="hero compact-hero">
      <p className="eyebrow">404</p>
      <h1>That page has<br /><em>left the studio.</em></h1>
      <Link className="button" href="/">Return home</Link>
    </section>
  );
}
