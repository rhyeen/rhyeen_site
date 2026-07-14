import type { NextConfig } from "next";

const nextConfig: NextConfig = {
  poweredByHeader: false,
  async redirects() {
    return [
      { source: "/index.html", destination: "/", permanent: true },
      { source: "/current-projects/index.html", destination: "/current-projects", permanent: true },
      { source: "/previous-projects/index.html", destination: "/previous-projects", permanent: true },
      { source: "/software-development/index.html", destination: "/software-development", permanent: true },
      { source: "/web-development/index.html", destination: "/web-development", permanent: true },
      { source: "/art-design/index.html", destination: "/art-design", permanent: true },
      { source: "/art-design/art/index.html", destination: "/art-design/art", permanent: true },
      { source: "/art-design/graphic-design/index.html", destination: "/art-design/graphic-design", permanent: true },
      { source: "/art-design/photography/index.html", destination: "/art-design/photography", permanent: true },
      { source: "/art-design/web-design/index.html", destination: "/art-design/web-design", permanent: true },
    ];
  },
  async rewrites() {
    return [
      { source: "/games-for-buck", destination: "/games-for-buck/index.html" },
    ];
  },
};

export default nextConfig;
