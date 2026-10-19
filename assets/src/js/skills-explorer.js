/**
 * Skills explorer: search, category filter and view mode for the front page
 * skills section (template-parts/front/skills.php).
 *
 * The markup is fully rendered server-side; this module only toggles
 * hidden/aria-pressed/data-* state. All styling lives in Tailwind variants.
 */

const MARK_CLASS = "rounded-[3px] bg-(--cat) px-px text-ink";

function highlight(label, name, index, length) {
    if (index < 0) {
        label.textContent = name;
        return;
    }

    const mark = document.createElement("mark");
    mark.className = MARK_CLASS;
    mark.textContent = name.slice(index, index + length);
    label.replaceChildren(name.slice(0, index), mark, name.slice(index + length));
}

const isMatch = (chip) => chip.dataset.match !== "no";

export default function initSkillsExplorer(root) {
    const query = root.querySelector("[data-skills-query]");
    const toolbar = root.querySelector("[data-skills-toolbar]");
    const empty = root.querySelector("[data-skills-empty]");
    const emptyQuery = root.querySelector("[data-skills-empty-query]");
    const count = root.querySelector("[data-skills-count]");
    const total = root.querySelector("[data-skills-total]");
    const views = [...root.querySelectorAll("[data-skills-view]")];
    const cards = [...root.querySelectorAll("[data-skills-card]")];
    const pills = [...root.querySelectorAll("[data-skills-category]")];
    const modes = [...root.querySelectorAll("[data-skills-mode]")];
    const wallView = root.querySelector('[data-skills-view="wall"]');

    if (!query || !toolbar || !wallView) {
        return;
    }

    const chips = [...root.querySelectorAll("[data-skill]")];
    const wallChips = [...wallView.querySelectorAll("[data-skill]")];

    // Remember server-rendered defaults so they can be restored when the query is cleared.
    chips.forEach((chip, index) => {
        chip.dataset.index = index;
    });
    const cardDefaults = new Map(
        cards.map((card) => [
            card,
            {
                meta: card.querySelector("[data-skills-card-meta]").textContent.trim(),
                width: card.querySelector("[data-skills-bar]").style.width,
            },
        ])
    );

    const state = { query: "", category: "all", mode: "grouped" };

    function render() {
        const term = state.query.trim().toLowerCase();
        const inCategory = (category) => state.category === "all" || category === state.category;

        chips.forEach((chip) => {
            const name = chip.dataset.skill;
            const index = term ? name.toLowerCase().indexOf(term) : -1;

            if (term) {
                chip.dataset.match = index >= 0 ? "lit" : "no";
            } else {
                delete chip.dataset.match;
            }

            highlight(chip.querySelector("[data-skill-label]"), name, index, term.length);
        });

        wallChips.forEach((chip) => {
            chip.hidden = !inCategory(chip.dataset.category);
        });

        cards.forEach((card) => {
            const list = card.querySelector("[data-skills-list]");
            const cardChips = [...list.children];
            const matches = cardChips.filter(isMatch).length;
            const defaults = cardDefaults.get(card);

            card.hidden = !inCategory(card.dataset.category);
            card.dataset.state = term ? (matches ? "match" : "dim") : "";
            card.querySelector("[data-skills-card-meta]").textContent = term
                ? `${matches} / ${cardChips.length}`
                : defaults.meta;
            card.querySelector("[data-skills-bar]").style.width = term
                ? `${Math.round((matches / cardChips.length) * 100)}%`
                : defaults.width;

            // Matching chips first while searching, original order otherwise.
            cardChips
                .sort((a, b) => (term ? isMatch(b) - isMatch(a) : 0) || a.dataset.index - b.dataset.index)
                .forEach((chip) => list.append(chip));
        });

        const visible = wallChips.filter((chip) => !chip.hidden);
        const matchCount = visible.filter(isMatch).length;
        const isEmpty = Boolean(term) && matchCount === 0;

        views.forEach((view) => {
            view.hidden = isEmpty || view.dataset.skillsView !== state.mode;
        });
        empty.hidden = !isEmpty;
        emptyQuery.textContent = emptyQuery.dataset.template.replace("%s", state.query.trim());
        count.textContent = matchCount;
        total.textContent = visible.length;

        pills.forEach((pill) => {
            const category = pill.dataset.skillsCategory;
            const pillMatches = wallChips.filter(
                (chip) => (category === "all" || chip.dataset.category === category) && isMatch(chip)
            ).length;

            pill.setAttribute("aria-pressed", String(category === state.category));
            pill.querySelector("[data-skills-category-count]").textContent = pillMatches;
        });

        modes.forEach((mode) => {
            mode.setAttribute("aria-pressed", String(mode.dataset.skillsMode === state.mode));
        });
    }

    function setQuery(value) {
        state.query = value;
        query.value = value;
        render();
    }

    query.addEventListener("input", () => {
        state.query = query.value;
        render();
    });

    root.querySelector("[data-skills-clear]")?.addEventListener("click", (event) => {
        event.preventDefault();
        setQuery("");
        query.focus();
    });

    root.addEventListener("click", (event) => {
        const pill = event.target.closest("[data-skills-category]");
        const mode = event.target.closest("[data-skills-mode]");
        const suggestion = event.target.closest("[data-skills-suggest]");

        if (pill) {
            state.category = pill.dataset.skillsCategory;
            render();
        } else if (mode) {
            state.mode = mode.dataset.skillsMode;
            render();
        } else if (suggestion) {
            setQuery(suggestion.dataset.skillsSuggest);
        }
    });

    toolbar.hidden = false;
    render();
}
