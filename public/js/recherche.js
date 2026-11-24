const form = document.querySelector('.search-form');
const toggleAllBtn = document.getElementById('toggle-all-filters');

if (form && toggleAllBtn) {
    const checkboxes = Array.from(
        form.querySelectorAll('.filter-chip input[type="checkbox"]')
    );

    const areAllChecked = () =>
        checkboxes.length > 0 && checkboxes.every((cb) => cb.checked);

    const updateToggleButton = () => {
        const allChecked = areAllChecked();
        toggleAllBtn.classList.toggle('is-active', allChecked);
        toggleAllBtn.setAttribute('aria-pressed', String(allChecked));
    };

    // 1. Clic sur une pastille -> met à jour le bouton et lance la recherche immédiatement
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', () => {
            updateToggleButton();
            form.submit();
        });
    });

    // 2. Clic sur "Tout sélectionner" -> coche tout (ou décoche tout si déjà actif) puis lance la recherche
    toggleAllBtn.addEventListener('click', () => {
        const shouldCheckAll = !areAllChecked();
        checkboxes.forEach((checkbox) => {
            checkbox.checked = shouldCheckAll;
        });
        updateToggleButton();
        form.submit();
    });

    updateToggleButton();
}