/**
 * Typewriter rotation of job titles in the hero (template-parts/front/hero.php).
 *
 * The element keeps its server-rendered text when JS is unavailable or the
 * visitor prefers reduced motion. The element is aria-hidden in the markup;
 * screen readers get a static label instead of a constantly changing one.
 */

import theaterJS from "theaterjs";

// Only the word is typed; the surrounding "<" and "/>" are static markup,
// since theaterJS would parse them as HTML tags.
const ROLES = [
    "developer",
    "full stack developer",
    "php developer",
    "software engineer",
    "back-end developer",
    "front-end developer",
    "web developer",
    "wordpress developer",
    "cms developer",
    "e-commerce developer",
    "api integration developer",
    "technical lead",
    "tech leader",
    "team lead",
    "scrum master",
    "agile practitioner",
    "project manager",
    "consultant",
    "international consultant",
];

// Fisher–Yates; sort(() => Math.random() - 0.5) produces a biased order.
function shuffle(items) {
    const result = [...items];
    for (let i = result.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [result[i], result[j]] = [result[j], result[i]];
    }
    return result;
}

export default function initRoleTypewriter(element) {
    if (matchMedia("(prefers-reduced-motion: reduce)").matches) {
        return;
    }

    const theater = theaterJS();
    // theaterJS only accepts a selector or a callback here; any other value
    // (e.g. an Element) silently falls back to console.log.
    theater.addActor("role", { speed: 0.8, accuracy: 0.6 }, (value) => {
        element.textContent = value;
    });

    // Each "role:<text>" scene erases the previous text before typing, so no
    // explicit erase scene is needed.
    shuffle(ROLES).forEach((role) => theater.addScene(`role:${role}`, 1500));
    theater.addScene(theater.replay.bind(theater));
}
