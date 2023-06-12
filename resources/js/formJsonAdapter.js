class FormJson {
    constructor (json) {
        this.json = json;
    }

    getSteps() {
        let steps = this.json.steps;
        // console.log(steps);
        steps.sort((a, b) => {
            if (a.order > b.order) return 1;
            if (a.order == b.order) return 0;
            if (a.order < b.order) return -1;
        });

        return steps;
    }

    addStep(step) {
        this.json.steps.push(step);
    }

    getElementsNames(elements=this.json.steps) {
        let names = [];

        elements.forEach(el => {
            if (el.element_name) {
                if (names.indexOf(el.element_name) == -1) {
                    names.push(el.element_name);
                }
            }

            if (el.elements) {
                let els = this.getElementsNames(el.elements);
                names.push(...els);
            }
        });

        names = names.filter((item, pos) => names.indexOf(item) == pos);
        return names;
    }
}

export default FormJson;