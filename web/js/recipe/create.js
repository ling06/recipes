document.addEventListener('click', e => {
    let target;

    // добавление ингредиента
    if (target = e.target.closest('.recipeForm__ingredientsButton_add')) {
        createTemplateItem(target.closest('.recipeForm'), '.recipeForm__ingredientsContent', 'ingredient');
        e.preventDefault();
        return false;
    }

    // добавление временной шкалы
    if (target = e.target.closest('.recipeForm__timelinesButton_add')) {
        let form = target.closest('.recipeForm');
        let timeline = createTemplateItem(form, '.recipeForm__timelinesContent', 'timeline');
        setTimelineN(form, timeline);
        e.preventDefault();
        return false;
    }

    // добавление события
    if (target = e.target.closest('.recipeForm__timelineEventsButton_add')) {
        let timeline = target.closest('.recipeForm__timeline');
        let timelineEvent = createTemplateItem(timeline, '.recipeForm__timelineEventsContent', 'timelineEvent');
        setTimelineEventN(timeline, timelineEvent);
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


function getInputDataName(input) {
    let match = [
        input.name.match(/\[([^\]]*)\]\[\]$/),
        input.name.match(/\[([^\]]*)\]$/),
        input.name
    ];
    let name = match.filter(n => n)[0];
    return typeof name === 'string' ? name : name[1];
}

function setInputValue(input, data) {
    data = data || {};
    let name = getInputDataName(input);
    if (typeof data[name] !== 'undefined') {
        if (input.nodeName.toLowerCase() === 'select' && input.multiple) {
            data[name].forEach(value => {
                let option = input.querySelector(`option[value="${value}"]`);
                if(option) option.selected = true;
            });
        } else {
            input.value = data[name];
        }
    }
}

function setInputsValues(parent, data) {
    data = data || {};
    parent.querySelectorAll('input, select, textarea').forEach(input => setInputValue(input, data));
}

function createClone(name, data) {
    data = data || {};
    let clone = document.querySelector(`.template[data-template="${name}"]`).cloneNode(true);
    clone.classList.remove('template');
    setInputsValues(clone, data);
    return clone;
}

function createTemplateItem(parentElement, contentElement, templateName, data) {
    data = data || {};
    let clone = createClone(templateName, data);
    parentElement.querySelector(contentElement).appendChild(clone);
    return clone;
}


function setTimelineN(form, timeline) {
    let lastTimeline = form.querySelector('.recipeForm__timeline:last-child');
    timeline.dataset.n = lastTimeline.previousSibling ? +lastTimeline.previousSibling.dataset.n + 1 : 1;
    timeline.querySelectorAll('input, select, textarea').forEach(input => {
        input.name = input.name.replace(/\{n\}/g, timeline.dataset.n);
    });
}
function setTimelineEventN(timeline, timelineEvent) {
    timelineEvent.querySelectorAll('input, select, textarea').forEach(input => {
        input.name = input.name.replace(/\{n\}/g, timeline.dataset.n);
    });
}


function loadRecipe(form, data) {
    setInputsValues(form, data);
    if (data.recipeIngredients) {
        data.recipeIngredients.forEach(recipeIngredientsData => {
            console.log(recipeIngredientsData);
            createTemplateItem(form, '.recipeForm__ingredientsContent', 'ingredient', recipeIngredientsData);
        });
    }
    if (data.timelines) {
        data.timelines.forEach(timelineData => {
            let timeline = createTemplateItem(form, '.recipeForm__timelinesContent', 'timeline', timelineData);
            setTimelineN(form, timeline);
            if (timelineData.timelineEvents) {
                timelineData.timelineEvents.forEach(timelineEventData => {
                    let timelineEvent = createTemplateItem(timeline, '.recipeForm__timelineEventsContent', 'timelineEvent', timelineEventData);
                    setTimelineEventN(timeline, timelineEvent);
                });
            }
        });
    }
}