export function debounce(func, ms) {
    let timeout;
    return function() {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, arguments), ms);
    };
}

export function decline(n, options = []) {
    n = Math.abs(n) % 100;
    let n1 = n % 10;

    if (n > 10 && n < 20) {
        if (options[0] !== undefined) return options[0];
        return '';
    }
    if (n1 === 1) {
        if (options[1] !== undefined) return options[1];
        return '';
    }
    if (n1 > 1 && n1 < 5) {
        if (options[2] !== undefined) return options[2];
        return '';
    }

    if (options[0] !== undefined) return options[0];
    return '';
}
