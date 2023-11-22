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

    static fullName(user) {
        return `${user.first_name} ${user.last_name}`;
    }
}
