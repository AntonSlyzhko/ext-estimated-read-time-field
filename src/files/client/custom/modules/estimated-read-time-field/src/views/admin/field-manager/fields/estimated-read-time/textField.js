import EnumFieldView from 'views/fields/enum';

export default class extends EnumFieldView {

    setupOptions() {
        const entityType = this.options.scope;

        this.params.translation = `${entityType}.fields`;

        const fieldList = this.getFieldManager().getEntityTypeFieldList(entityType, {typeList: ['text']});

        this.setOptionList(['', ...fieldList]);
    }
}
