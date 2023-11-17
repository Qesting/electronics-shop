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

    static capitalize(string) {
        return string
            .split(/\s+/)
            .map(word => word[0].toUpperCase() + word.substring(1))
            .join(' ');
    }
}
