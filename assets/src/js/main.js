import { Fancybox } from "@fancyapps/ui";
import initSkillsExplorer from "./skills-explorer";
import initSmoothScroll from "./smooth-scroll";
import initRoleTypewriter from "./role-typewriter";
import initProjectDialog from "./project-dialog";
import initActiveSection from "./active-section";
import initLanguageSwitch from "./language-switch";

const smoother = initSmoothScroll();

const role = document.getElementById("role");
if (role) {
    initRoleTypewriter(role);
}

// Gallery lightbox — works on every page that has a rickmanu gallery.
Fancybox.bind('[data-fancybox^="rickmanu-gallery-"]', {
    animated: true,
    showClass: "fancybox-zoomInUp",
    hideClass: "fancybox-fadeOut",
    Thumbs: { type: "modern" },
    caption: function (fancybox, slide) {
        return slide.el?.dataset?.caption ?? "";
    },
});

document.querySelectorAll("[data-skills-explorer]").forEach(initSkillsExplorer);

document.querySelectorAll("[data-language-switch]").forEach(initLanguageSwitch);

initProjectDialog(smoother);
initActiveSection(document.querySelectorAll("header nav a[href*='#'], nav[data-dock] a"));
