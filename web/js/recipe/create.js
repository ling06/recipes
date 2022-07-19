document.addEventListener('click', e => {
    let target;

    // добавление ингредиента
    if (target = e.target.closest('.recipeForm__ingredientsButton_add')) {
        let form = target.closest('.recipeForm');

        let clone = document.querySelector('.template[data-template="ingredient"]').cloneNode(true);
        clone.classList.remove('template');

        form.querySelector('.recipeForm__ingredientsContent').appendChild(clone);

        e.preventDefault();
        return false;
    }

    // добавление временной шкалы
    if (target = e.target.closest('.recipeForm__timelinesButton_add')) {
        let form = target.closest('.recipeForm');
        let lastTimeline = form.querySelector('.recipeForm__timeline:last-child');
        let n = lastTimeline ? +lastTimeline.dataset.n + 1 : 1;

        let clone = document.querySelector('.template[data-template="timeline"]').cloneNode(true);
        clone.querySelectorAll('input, select, textarea').forEach(input => {
            input.name = input.name.replace(/\{n\}/g, n);
        });
        clone.dataset.n = n;
        clone.classList.remove('template');

        form.querySelector('.recipeForm__timelinesContent').appendChild(clone);

        e.preventDefault();
        return false;
    }

    // добавление события
    if (target = e.target.closest('.recipeForm__timelineEventsButton_add')) {
        let timeline = target.closest('.recipeForm__timeline');
        let n = +timeline.dataset.n;

        let clone = document.querySelector('.template[data-template="timelineEvent"]').cloneNode(true);
        clone.querySelectorAll('input, select, textarea').forEach(input => {
            input.name = input.name.replace(/\{n\}/g, n);
        });
        clone.classList.remove('template');

        timeline.querySelector('.recipeForm__timelineEventsContent').appendChild(clone);

        e.preventDefault();
        return false;
    }

    if (target = e.target.closest('.btnDelete')) {
        if (!confirm('Точно удалить?')) {
            e.preventDefault();
            return false;
        }
        let parent = e.target.dataset.parent ?
            target.closest(e.target.dataset.parent) :
            target.parentNode;
        parent.parentNode.removeChild(parent);
        e.preventDefault();
        return false;
    }

    if (target = e.target.closest('.btnMoveUp')) {
        let parent = e.target.dataset.parent ?
            target.closest(e.target.dataset.parent) :
            target.parentNode;
        if (parent.previousSibling) {
            parent.parentNode.insertBefore(parent, parent.previousSibling);
        }
        e.preventDefault();
        return false;
    }
    if (target = e.target.closest('.btnMoveDown')) {
        let parent = e.target.dataset.parent ?
            target.closest(e.target.dataset.parent) :
            target.parentNode;
        if (parent.nextSibling) {
            parent.parentNode.insertBefore(parent.nextSibling, parent);
        }
        e.preventDefault();
        return false;
    }

});