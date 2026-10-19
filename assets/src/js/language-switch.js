/**
 * Animated transition for the header language switch (inc/language.php).
 *
 * The switch links lead to the Polylang URL of each language; this slides the thumb and
 * covers the page with the wipe before leaving, then uncovers it once the
 * translated page loads. Skipped for prefers-reduced-motion.
 */

const STORAGE_KEY = "rickmanu-language-wipe";
const COVER_DURATION = 400;

function readFlag() {
    try {
        const flag = sessionStorage.getItem(STORAGE_KEY);
        sessionStorage.removeItem(STORAGE_KEY);
        return flag;
    } catch {
        return null;
    }
}

function writeFlag() {
    try {
        sessionStorage.setItem(STORAGE_KEY, "1");
    } catch {
        // Storage unavailable: the next page simply loads without the reveal.
    }
}

function fillWipe(wipe, link) {
    wipe.querySelector("[data-language-wipe-code]").textContent = `document.lang = "${link.hreflang}"`;
    wipe.querySelector("[data-language-wipe-word]").textContent = link.dataset.greeting ?? "";
}

export default function initLanguageSwitch(root) {
    const wipe = document.querySelector("[data-language-wipe]");

    if (!wipe || matchMedia("(prefers-reduced-motion: reduce)").matches) {
        return;
    }

    const current = root.querySelector('[aria-current="true"]');

    if (readFlag() && current) {
        fillWipe(wipe, current);
        wipe.classList.add("is-leaving");
        wipe.addEventListener("animationend", () => wipe.classList.remove("is-leaving"), { once: true });
    }

    const thumb = root.querySelector("[data-language-thumb]");

    root.querySelectorAll("a[data-language-index]").forEach((link) => {
        link.addEventListener("click", (event) => {
            if (link === current || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
                return;
            }

            event.preventDefault();
            if (thumb) {
                thumb.style.transform = `translateX(${Number(link.dataset.languageIndex) * 100}%)`;
            }
            fillWipe(wipe, link);
            wipe.classList.add("is-entering");
            writeFlag();
            setTimeout(() => location.assign(link.href), COVER_DURATION);
        });
    });
}
