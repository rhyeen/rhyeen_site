export type Project = {
  title: string;
  date?: string;
  tools?: string;
  description: string[];
  link?: { label: string; href: string };
  links?: { label: string; href: string }[];
};

export const currentProjects: Project[] = [
  {
    title: "PocketRN",
    date: "Present",
    tools: "Virtual healthcare · Marketing site and care application",
    description: [
      "A virtual-care platform that brings nurse-led clinical guidance, education, and ongoing support into the home. PocketRN supports people living with dementia and their caregivers through GUIDE, as well as people managing anxiety and depression through ACCESS.",
    ],
    links: [
      { label: "Visit PocketRN", href: "https://pocketrn.com/" },
      { label: "Open the care application", href: "https://app.pocketrn.com/" },
    ],
  },
  {
    title: "Kernel",
    date: "Present",
    tools: "Tabletop RPG design · Core rulebook",
    description: [
      "A story-focused, setting-agnostic tabletop role-playing system that strips mechanics down to the essentials of collaborative narration and dice-driven play. Players freely define their characters through lightweight skills and custom “epics,” while the system stays flexible enough for almost any imagined setting.",
    ],
    link: {
      label: "Read the Kernel core rulebook",
      href: "https://docs.google.com/document/d/1xm7JR3cjeW2Bs7YpxWc1fZA0P3Jt_1Ymm4zh3Ik8mM0/edit?tab=t.0",
    },
  },
  {
    title: "Relicry",
    date: "Present",
    tools: "Collectible card game · Events and web platform",
    description: [
      "A free-to-play collectible card game built around local events. Players receive starter decks, open booster packs, complete quests, team up against challenging foes, earn vendor rewards, and carry their growing collections from one event to the next.",
    ],
    link: { label: "Visit Relicry", href: "https://relicry.com/" },
  },
  {
    title: "Blabber Scribe",
    date: "Present",
    tools: "Zoom · AI-assisted transcription · Markdown",
    description: [
      "A private tool for transcribing long-form dictation captured through Zoom meetings and Zoom phone calls. It chunks lengthy transcripts into manageable sections, passes them through a specialized GPT prompt for cleanup, and produces structured Markdown designed for further processing by other AI systems.",
    ],
    link: { label: "Open the private application", href: "https://blabber-scribe.web.app/" },
  },
  {
    title: "TimeShare",
    date: "Present",
    tools: "Social-deduction game · Print and play",
    description: [
      "A printer-friendly reimagining of the out-of-print Two Rooms and a Boom. Two teams secretly maneuver Money Bags and the Rainmaker between rooms to either prevent or complete a questionable timeshare sale, while independent characters pursue their own goals. The cards support low-ink color or black-and-white printing and carry their rules directly on the card.",
    ],
    link: {
      label: "Read the rules and print-and-play document",
      href: "https://docs.google.com/document/d/1WkA7fHYa2k6byxAjsc23esdGsrn62XLL_gx3JRKUO1k/edit?usp=sharing",
    },
  },
];

export const previousProjects: Project[] = [
  {
    title: "Sharded Cards",
    date: "Previous",
    tools: "TypeScript, Web Components, Node.js, and Firebase",
    description: [
      "A mobile-friendly, browser-based trading card game built for modern browsers and phones.",
    ],
    link: { label: "View app repository", href: "https://github.com/rhyeen/sc-app" },
  },
  {
    title: "Project Spiderweb",
    date: "Previous",
    tools: "Go, Web Components, and MySQL",
    description: [
      "A web application for managing the intricate relationships between different aspects of world building and story writing.",
    ],
    link: {
      label: "View service repository",
      href: "https://github.com/Pergamene/project-spiderweb-service",
    },
  },
  {
    title: "Microfront Reference",
    date: "2018",
    tools: "React, Web Components, and vanilla JavaScript",
    description: [
      "A proof of concept for connecting several modern JavaScript frameworks with Redux and Web Components as an API layer.",
    ],
    link: { label: "View repository", href: "https://github.com/rhyeen/microfront_reference" },
  },
  {
    title: "mDOT — Video Approving Web Application",
    date: "2017",
    tools: "AngularJS, Node.js, and MySQL",
    description: [
      "A web application for approving videos of patients taking daily tuberculosis medication. The project integrates with an Android app and custom pill-dispensing hardware.",
    ],
  },
  {
    title: "Shardnova — An Experimental SMS MMORPG",
    date: "2018",
    tools: "Python 3 and Docker",
    description: [
      "A prototype game played entirely through SMS messages relayed between a server and the player, much like an old-school text adventure.",
    ],
    link: { label: "View repository", href: "https://github.com/rhyeen/shardnova_engine" },
  },
  {
    title: "Card Rogue — A Tabletop Roguelike",
    date: "2017",
    tools: "Designed, manufactured, and shipped board game",
    description: ["A successful Kickstarter campaign for a board game that sold more than 1,500 copies."],
    links: [
      { label: "Visit the Card Rogue website", href: "https://cardrogue.netlify.app/" },
      {
        label: "View Kickstarter campaign",
        href: "https://www.kickstarter.com/projects/rhyeen/card-rogue-a-tabletop-roguelike",
      },
    ],
  },
  {
    title: "Card & Board Games for a Buck",
    date: "2016",
    tools: "Printable board-game rules",
    description: [
      "A successful Kickstarter campaign for printable rules to three games designed for a standard 52-card deck.",
    ],
    links: [
      { label: "Explore Card Games for a Buck", href: "/games-for-buck" },
      {
        label: "View Kickstarter campaign",
        href: "https://www.kickstarter.com/projects/rhyeen/card-and-board-games-for-a-buck",
      },
    ],
  },
  {
    title: "P2P Offloading on Mobile Networks",
    date: "2016",
    tools: "Python and OpenFlow",
    description: [
      "Research with the University of Utah's Flux Research Group to reduce the latency of peer-to-peer services on an emulated 4G/LTE network. Testing on separate smartphones showed a significant reduction in latency.",
    ],
    link: { label: "View paper", href: "https://dl.acm.org/authorize?N16299" },
  },
  {
    title: "Health-Related Habits Visualized",
    date: "2015",
    tools: "D3.js and JavaScript",
    description: [
      "An interactive visualization built from the Centers for Disease Control and Prevention's annual questionnaire data, with filtering tools for exploring correlations among data sets.",
    ],
    link: { label: "View archived website", href: "/other/datavisfinal/index.html" },
  },
  {
    title: "Cosmonautics — A Multiplayer 2D Space Shooter",
    date: "2014",
    tools: "C#, OpenGL, TCP, and UDP",
    description: [
      "A networked space game with custom collision detection, particle simulation, and vector artwork manipulated under simulated physics.",
    ],
    link: { label: "View repository", href: "https://github.com/rhyeen/Cosmonautics" },
  },
];

function previousProject(title: string) {
  const project = previousProjects.find((item) => item.title === title);

  if (!project) {
    throw new Error(`Unknown previous project: ${title}`);
  }

  return project;
}

export const softwareProjects: Project[] = [
  previousProject("P2P Offloading on Mobile Networks"),
  {
    title: "Android App of a Virtual Board Game",
    date: "2015",
    tools: "Java and Android",
    description: [
      "A virtual version of a Kickstarter board game, built around the MVC pattern with native Android views and layouts.",
    ],
    link: { label: "View repository", href: "https://github.com/rhyeen/CardRogueAndroid" },
  },
  previousProject("Cosmonautics — A Multiplayer 2D Space Shooter"),
  {
    title: "Concurrent Spreadsheet",
    date: "2014",
    tools: "C# and C++",
    description: [
      "A collaborative spreadsheet application that allowed simultaneous users to edit server-hosted spreadsheets.",
    ],
    link: { label: "Read design document", href: "/other/spreadsheet_design_document.pdf" },
  },
  {
    title: "Secure Text Transfer",
    date: "2014",
    tools: "Java, RSA, 3DES, and SHA-1",
    description: [
      "A client-server protocol demonstrating authentication, encryption, and message-integrity verification.",
    ],
  },
  {
    title: "Ball Animation for FFmpeg",
    date: "2014",
    tools: "C and C++",
    description: [
      "An FFmpeg-based program for compositing animated image sequences into video and adding animation to a chosen background.",
    ],
    link: { label: "Read design document", href: "/other/bouncer_design_document.pdf" },
  },
  {
    title: "HTTP Web Proxy",
    date: "2014",
    tools: "Java",
    description: ["A web proxy for observing and optionally blocking HTTP requests and responses."],
  },
  {
    title: "Boggle Game with Server",
    date: "2013",
    tools: "C#, HTML, and SQL",
    description: [
      "A multiplayer Boggle game with player matching, randomized boards, and server-backed game statistics.",
    ],
    link: { label: "View example statistics", href: "/other/boggle/game.html" },
  },
];

export const webProjects: Project[] = [
  previousProject("mDOT — Video Approving Web Application"),
  previousProject("Health-Related Habits Visualized"),
  {
    title: "Web Form Generator",
    date: "2015",
    tools: "PHP, jQuery, and MySQL",
    description: [
      "A generator for quickly producing sophisticated multi-stage forms with front-end and back-end validation.",
    ],
    link: { label: "View repository", href: "https://github.com/rhyeen/WebFormGenerator" },
  },
  {
    title: "Group Play Checkers",
    date: "2015",
    tools: "PHP, jQuery, MySQL, and PixiJS",
    description: [
      "A checkers web app designed for play against a friend, an AI opponent, or as part of a global team.",
    ],
    link: { label: "View repository", href: "https://github.com/rhyeen/ChessGroupPlay" },
  },
  {
    title: "Teacher Assistant Application",
    date: "2015",
    tools: "PHP, jQuery, and MySQL",
    description: [
      "A role-based application system for teaching-assistant candidates, instructors, and administrators.",
    ],
  },
];

export const webDesignProjects: Project[] = [
  {
    title: "Card Rogue",
    description: [
      "A responsive website and interactive rulebook for a Kickstarter board game, designed to work well on phones, tablets, and in print.",
    ],
    link: { label: "View website", href: "https://cardrogue.netlify.app/" },
  },
  {
    title: "The HUB",
    description: ["A responsive portfolio template for artists and designers."],
    link: { label: "View archived website", href: "/other/the-hub/index.html" },
  },
  {
    title: "Color of Artists",
    description: [
      "A simple, gallery-like site created for a large art project presented at the University of Utah in 2013.",
    ],
    link: { label: "View archived website", href: "/other/color-of-artists/index.html" },
  },
  {
    title: "Our Solar System",
    description: ["A one-day visual-narrative experiment designed to encourage exploration."],
    link: { label: "View archived website", href: "/other/solar-system/index.html" },
  },
  {
    title: "Service Auction",
    description: ["An approved home-page concept for an online community service auction."],
    link: { label: "View archived website", href: "/other/service-auction/index.html" },
  },
];

export const galleries = {
  art: [
    ["45_second_mountain.png", "A quick painting of the Teton mountain range at sunset"],
    ["bamboo.png", "A traditional ink painting of bamboo"],
    ["cinderella.png", "A chalk portrait depicting Cinderella"],
    ["cherry_blossoms.png", "A traditional ink painting of cherry blossoms"],
    ["jared_watercolor.png", "A watercolor portrait"],
    ["light_object.png", "A digital collage combining night and day"],
    ["light_of_the_mountain.png", "A digital collage of mountain light"],
    ["lion.png", "An ink drawing of a lion"],
    ["mona_lisa.png", "A color-composition study of the Mona Lisa", "mona_lisa_lines.png"],
    ["study_of_a_figure_outdoors.png", "A color-composition figure study", "study_of_a_figure_outdoors_lines.png"],
  ],
  "graphic-design": [
    ["advantage_lending_services_redesign.png", "A client logo redesign"],
    ["into_the_woods_poster.png", "A poster for a theatrical performance"],
    ["love_at_first_byte2.png", "A geek-culture T-shirt design", "love_at_first_byte.png"],
    ["reality_pd_logo.png", "A small-business logo design"],
    ["see_how_they_run_poster.png", "A poster for a theatrical performance"],
    ["internet_trolls2.png", "A geek-culture T-shirt design", "internet_trolls.png"],
    ["reality_bytes_logo.png", "A personal-business logo design"],
    ["lift_off_base2.png", "A geek-culture T-shirt design", "lift_off_base.png"],
  ],
  photography: [
    ["ally.png", "Studio portrait"], ["art_seller_szentendre.png", "An art seller in Szentendre"],
    ["emily.png", "Outdoor portrait"], ["farmland1.png", "Farmland landscape"],
    ["farmland2.png", "Farmland landscape"], ["frozen_grass.png", "Frozen grass"],
    ["jackson_lake_and_coltar_bay.png", "Jackson Lake and Colter Bay"], ["jamie.png", "Studio portrait"],
    ["lauren.png", "Studio portrait"], ["lauren3.png", "Studio portrait"],
    ["lunch_in_austria.png", "Lunch in Austria"], ["moses.png", "Outdoor portrait"],
    ["people_in_cave.png", "People exploring a cave"], ["red_fish_lake.png", "Redfish Lake"],
    ["rembrandt_and_man.png", "A museum visitor and a Rembrandt"], ["wookiee.png", "Indoor portrait"],
  ],
} as const;
