document.addEventListener('click', e => {
    let target = e.target;

    if (target.closest('.classToggle')) {
        let toggle = target.closest('.classToggle'),
            parent = toggle.dataset.parent ? toggle.closest(toggle.dataset.parent) : toggle.parentNode,
            cssClass = toggle.dataset.class || 'active';
        parent.classList.toggle(cssClass);
    }
    if (target.closest('.stateToggle')) {
        let toggle = target.closest('.stateToggle'),
            parent = toggle.dataset.parent ? toggle.closest(toggle.dataset.parent) : toggle.parentNode,
            parentClass = parent.className.split(' ')[0],
            type = toggle.dataset.type,
            state = toggle.dataset.state || 'active',
            parentOldClass = parentClass + (type ? '_' + type : '') + '_' + parent.dataset[type],
            parentNewClass = parentClass + (type ? '_' + type : '') + '_' + state;
        parent.classList.remove(parentOldClass);
        parent.classList.add(parentNewClass);
        parent.dataset[type] = state;
    }

});

document.addEventListener('submit', e => {
    let target = e.target;

    if (target.closest('.confirmDelete')) {
        let form = target.closest('.confirmDelete');
        if (!confirm(form.dataset.message || 'Точно удалить?')) {
            e.preventDefault();
            return false;
        }
    }

});