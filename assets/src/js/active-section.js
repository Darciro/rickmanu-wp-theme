/**
 * Highlight the main menu and mobile dock links whose section is in view.
 *
 * Works with any menu item pointing at a same-page anchor (e.g. /#projects):
 * the matching link gets a data-active attribute, styled via Tailwind's
 * data-active: variant (see inc/navigation.php).
 */

function getSamePageSection(link) {
    if (!link.hash || link.origin !== location.origin || link.pathname !== location.pathname) {
        return null;
    }

    return document.getElementById(decodeURIComponent(link.hash.slice(1)));
}

export default function initActiveSection(links) {
    if (!("IntersectionObserver" in window)) {
        return;
    }

    const linksBySection = new Map();

    links.forEach((link) => {
        const section = getSamePageSection(link);

        if (section) {
            linksBySection.set(section, [...(linksBySection.get(section) ?? []), link]);
        }
    });

    if (!linksBySection.size) {
        return;
    }

    const allLinks = [...linksBySection.values()].flat();

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                const activeLinks = linksBySection.get(entry.target);
                allLinks.forEach((link) => link.toggleAttribute("data-active", activeLinks.includes(link)));
            });
        },
        // A thin band around the middle of the viewport decides the active section.
        { rootMargin: "-45% 0px -50% 0px" }
    );

    linksBySection.forEach((_, section) => observer.observe(section));
}
