import { existsSync, readFileSync, readdirSync, statSync } from "node:fs";
import { dirname, extname, join, normalize, resolve } from "node:path";

const publicRoot = resolve("public");
const siteRoot = join(publicRoot, "games-for-buck");
const files = [];

function walk(directory) {
  for (const name of readdirSync(directory)) {
    const file = join(directory, name);
    if (statSync(file).isDirectory()) walk(file);
    else files.push(file);
  }
}

function localTarget(file, reference) {
  const cleanReference = reference.split(/[?#]/, 1)[0];

  if (
    !cleanReference ||
    cleanReference === "/" ||
    cleanReference.startsWith("#") ||
    cleanReference.startsWith("//") ||
    /^[a-z][a-z\d+.-]*:/i.test(cleanReference)
  ) {
    return null;
  }

  if (cleanReference.startsWith("/")) {
    return join(publicRoot, cleanReference);
  }

  return normalize(join(dirname(file), cleanReference));
}

walk(siteRoot);

const problems = [];

for (const file of files.filter((candidate) => [".html", ".css"].includes(extname(candidate)))) {
  const source = readFileSync(file, "utf8").replace(/<!--[^]*?-->/g, "");
  const references = [];
  const attributePattern = /(?:href|src)\s*=\s*["']([^"']+)["']/gi;
  const cssPattern = /url\(\s*["']?([^)'"\s]+)["']?\s*\)/gi;

  for (const pattern of [attributePattern, cssPattern]) {
    for (const match of source.matchAll(pattern)) references.push(match[1]);
  }

  for (const reference of references) {
    const target = localTarget(file, reference);
    if (target && !existsSync(target) && !existsSync(join(target, "index.html"))) {
      problems.push(`${file.replace(publicRoot, "public")}: ${reference}`);
    }
  }

  if (extname(file) === ".html") {
    if (/<title>\s*<\/title>/i.test(source)) {
      problems.push(`${file.replace(publicRoot, "public")}: empty title`);
    }

    const navigation = source.match(/<nav\b[^>]*>[^]*?<\/nav>/i)?.[0];
    for (const label of ["Home", "Games", "Portfolio", "Other"]) {
      if (!navigation?.includes(`>${label}<`)) {
        problems.push(`${file.replace(publicRoot, "public")}: missing ${label} navigation`);
      }
    }
  }
}

if (problems.length) {
  console.error(`Games for a Buck audit found ${problems.length} problem(s):`);
  for (const problem of problems) console.error(`- ${problem}`);
  process.exitCode = 1;
} else {
  console.log(`Games for a Buck audit passed for ${files.length} files.`);
}
