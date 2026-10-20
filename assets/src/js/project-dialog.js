/**
 * Project details dialog for the front page project grid
 * (template-parts/front/projects.php).
 *
 * Cards are plain links to the live project; this module upgrades them to
 * open a native <dialog> (focus trap, Escape and inert page come for free)
 * filled from the #project-dialog-data JSON block. Modifier clicks still
 * follow the link so "open in new tab" keeps working.
 */

const CHIP_CLASS = "rounded-full border border-line-strong bg-ink px-3.5 py-1.5 text-sm";

const pad = (n) => String(n).padStart(2, "0");

function readProjects() {
    const source = document.getElementById("project-dialog-data");

    try {
        return source ? JSON.parse(source.textContent) : [];
    } catch {
        return [];
    }
}

export default function initProjectDialog(smoother) {
    const dialog = document.getElementById("project-dialog");
    const cards = [...document.querySelectorAll("[data-project]")];
    const projects = readProjects();

    if (!dialog || typeof dialog.showModal !== "function" || !cards.length || !projects.length) {
        return;
    }

    const scroller = dialog.querySelector("[data-project-scroll]") || dialog;
    const field = (name) => dialog.querySelector(`[data-project-field="${name}"]`);
    const fields = {
        image: field("image"),
        position: field("position"),
        meta: field("meta"),
        title: field("title"),
        description: field("description"),
        caseWrap: field("case"),
        stackWrap: field("stack-wrap"),
        stack: field("stack"),
        url: field("url"),
        github: field("github"),
        prev: field("prev"),
        next: field("next"),
    };
    let current = 0;

    function fill() {
        const project = projects[current];
        const total = projects.length;

        fields.image.src = project.image;
        fields.position.textContent = `${pad(current + 1)} / ${pad(total)}`;
        fields.meta.textContent = [project.type, project.year].filter(Boolean).join(" · ");
        fields.title.textContent = project.title;

        fields.description.textContent = project.description;
        fields.description.hidden = !project.description;

        // Case study entries (context, contribution...) are shown only when filled in.
        let hasCase = false;
        fields.caseWrap?.querySelectorAll("[data-project-case]").forEach((entry) => {
            const text = project.case?.[entry.dataset.projectCase] ?? "";
            entry.querySelector("dd").textContent = text;
            entry.hidden = !text;
            hasCase ||= Boolean(text);
        });
        if (fields.caseWrap) {
            fields.caseWrap.hidden = !hasCase;
        }

        fields.stack.replaceChildren(
            ...project.stack.map((name) => {
                const chip = document.createElement("li");
                chip.className = CHIP_CLASS;
                chip.textContent = name;
                return chip;
            })
        );
        fields.stackWrap.hidden = !project.stack.length;

        fields.url.href = project.url;
        fields.url.hidden = !project.url;
        fields.github.href = project.github || "#";
        fields.github.hidden = !project.github;

        fields.prev.textContent = projects[(current - 1 + total) % total].title;
        fields.next.textContent = projects[(current + 1) % total].title;

        scroller.scrollTop = 0;
    }

    function step(delta) {
        current = (current + delta + projects.length) % projects.length;
        fill();
    }

    function open(index) {
        current = index;
        fill();
        smoother?.paused(true);
        document.documentElement.classList.add("overflow-hidden");
        dialog.showModal();
    }

    cards.forEach((card) => {
        const index = Number(card.dataset.project);

        if (!projects[index]) {
            return;
        }

        card.setAttribute("aria-haspopup", "dialog");
        card.querySelector("[data-project-new-tab]")?.remove();

        card.addEventListener("click", (event) => {
            if (event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
                return;
            }

            event.preventDefault();
            open(index);
        });
    });

    // Native dialog returns focus to the opener on close.
    dialog.addEventListener("close", () => {
        document.documentElement.classList.remove("overflow-hidden");
        smoother?.paused(false);
    });

    dialog.addEventListener("click", (event) => {
        // A click on the <dialog> element itself lands on the backdrop.
        if (event.target === dialog) {
            dialog.close();
            return;
        }

        const stepButton = event.target.closest("[data-project-step]");
        if (stepButton) {
            step(Number(stepButton.dataset.projectStep));
        }
    });

    dialog.addEventListener("keydown", (event) => {
        if (event.key === "ArrowRight") {
            step(1);
        } else if (event.key === "ArrowLeft") {
            step(-1);
        }
    });
}
