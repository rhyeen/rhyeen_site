import type { Metadata } from "next";
import { Header } from "./components";
import "./globals.css";

export const metadata: Metadata = {
  title: { default: "Ryan Saunders — Software Engineer", template: "%s — Ryan Saunders" },
  description: "The software engineering, web development, art, and design portfolio of Ryan Saunders.",
  authors: [{ name: "Ryan Saunders" }],
};

export default function RootLayout({ children }: Readonly<{ children: React.ReactNode }>) {
  return (
    <html lang="en">
      <body>
        <Header />
        <main>{children}</main>
        <footer className="site-footer"><p>Ryan Saunders · Software, web, art, and design</p></footer>
      </body>
    </html>
  );
}
