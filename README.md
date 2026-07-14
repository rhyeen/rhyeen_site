# Ryan Saunders portfolio

This site is a small [Next.js](https://nextjs.org/) application designed for deployment on [Vercel](https://vercel.com/). The primary portfolio pages use the App Router; older demos, images, and downloadable documents are served unchanged from `public/`.

## Local development

Use Node.js 20.9 or newer, then install dependencies and start the development server:

```bash
npm install
npm run dev
```

Open [http://localhost:3000](http://localhost:3000).

## Verification

```bash
npm run typecheck
npm run build
```

## Deploy to Vercel

Import this Git repository in Vercel. The framework preset is detected as **Next.js**, and the default build command (`npm run build`) and output settings are sufficient. No environment variables are required.

After the first deployment, add `rhyeen.com` and `www.rhyeen.com` under the Vercel project's domain settings. Choose one as the canonical domain and redirect the other to it there.
