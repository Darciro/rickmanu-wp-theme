/**
 * Inertia scrolling (GSAP ScrollSmoother) plus same-page anchor handling.
 *
 * Requires the #smooth-wrapper / #smooth-content markup opened in header.php
 * and closed in footer.php. Skipped entirely for prefers-reduced-motion, in
 * which case the page falls back to native scrolling.
 */

import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { ScrollSmoother } from "gsap/ScrollSmoother";

function getSamePageTarget(link) {
    if (!link.hash || link.origin !== location.origin || link.pathname !== location.pathname) {
        return null;
    }

    try {
        return document.querySelector(decodeURIComponent(link.hash));
    } catch {
        return null; // Hash is not a valid selector.
    }
}

// Move keyboard/screen reader focus along with the scroll position.
function focusTarget(target) {
    if (!target.matches("a[href], button, input, select, textarea, [tabindex]")) {
        target.setAttribute("tabindex", "-1");
    }
    target.focus({ preventScroll: true });
}

export default function initSmoothScroll() {
    const wrapper = document.getElementById("smooth-wrapper");
    const content = document.getElementById("smooth-content");

    if (!wrapper || !content || matchMedia("(prefers-reduced-motion: reduce)").matches) {
        return null;
    }

    gsap.registerPlugin(ScrollTrigger, ScrollSmoother);

    // Native smooth scrolling fights ScrollSmoother's scroll updates.
    document.documentElement.style.scrollBehavior = "auto";

    const smoother = ScrollSmoother.create({
        wrapper,
        content,
        smooth: 1.5,
    });

    document.addEventListener("click", (event) => {
        const link = event.target.closest("a[href*='#']");
        const target = link && getSamePageTarget(link);

        if (!target) {
            return;
        }

        event.preventDefault();
        smoother.scrollTo(target, true, "top top");
        history.pushState(null, "", link.hash);
        focusTarget(target);
    });

    // Honour a hash in the URL on load (e.g. /#projects from another page).
    const initialTarget = location.hash && getSamePageTarget(location);
    if (initialTarget) {
        smoother.scrollTo(initialTarget, false, "top top");
    }

    return smoother;
}
