document.addEventListener('click', e => {
    let target = e.target;

    if (target.closest('.timeline__event')) {
        target.closest('.timeline__event').classList.toggle('timeline__event_expanded');
    }
    if (target.closest('.timeline__typeToggle')) {
        target.closest('.timeline').dataset.type = target.closest('.timeline__typeToggle').dataset.type;
    }

});