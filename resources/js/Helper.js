export default class Helper {
    static imageSrc(image) {
        return image ? image.origin + image.name : '';
    }

    static locale() {
        return navigator.languages && navigator.languages.length
            ? navigator.languages[0]
            : navigator.language;
    }

    static localeCurrencyString(number) {
        return number.toLocaleString(
            this.locale(),
            {
                style: 'currency',
                currency: 'PLN',
                minimumFractionDigits: 2
            }
        );
    }

    static localeDateString(date) {
        const that = date instanceof Date ? date : new Date(date);
        return that.toLocaleDateString(this.locale());
    }

    static capitalize(string) {
        return string
            .split(/\s+/)
            .map(word => word[0].toUpperCase() + word.substring(1))
            .join(' ');
    }

    static unflatten(object) {
        return Object.keys(object).reduce((accumulator, key) => {
            if (key.indexOf('.') + 1) {
                const keys = key.split('.');
                Object.assign(
                    accumulator,
                    JSON.parse(
                        '{' +
                        keys.map(
                            (value, index) => (
                                index !== keys.length -1
                                ? `"${value}":{`
                                : `"${value}":`
                            )).join('') + object[key]
                        + '}'.repeat(keys.length)
                    )
                );
            } else {
                accumulator[key] = object[key];
            }
        }, {});
    }
}
