import VarcharFieldView from 'views/fields/varchar';

class EstimatedReadTimeFieldView extends VarcharFieldView {

    getValueForDisplay() {
        return this.stringifySeconds(this.model.get(this.name));
    }

    /**
     * @private
     * @param {number} totalSeconds
     * @return {?string}
     */
    stringifySeconds(totalSeconds) {
        if (!totalSeconds) {
            return null;
        }

        let d = totalSeconds;
        const days = Math.floor(d / 86400);
        d = d % 86400;
        const hours = Math.floor(d / 3600);
        d = d % 3600;
        const minutes = Math.floor(d / 60);
        const seconds = d % 60;

        const parts = [];

        if (days) {
            parts.push(days + '' + this.getLanguage().translate('d', 'durationUnits'));
        }

        if (hours) {
            parts.push(hours + '' + this.getLanguage().translate('h', 'durationUnits'));
        }

        if (minutes) {
            parts.push(minutes + '' + this.getLanguage().translate('m', 'durationUnits'));
        }

        if (seconds) {
            parts.push(seconds + '' + this.getLanguage().translate('s', 'durationUnits'));
        }

        return parts.join(' ');
    }
}

export default EstimatedReadTimeFieldView;
