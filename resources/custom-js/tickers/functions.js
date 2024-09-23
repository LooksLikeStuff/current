export function createOptions(tickers) {
    // if (tickers.length == 0) return createNotFoundErrorElement();
    let options = '<div class="list" id="ticker__options">';
    $(tickers).each((index, ticker) => {
        options += `<div class="ticker__option" data-value="${ticker.id}" data-text="${ticker.name + ' (' + ticker.company.name + ')'}">
                            <div class="company__name">${ticker.company.name}</div>
                            <div class="ticker__name">${ticker.name}</div>
                    </div>`
    });

    options += '</div>';
    return options;
}

export function createOptionsForSell(tickers) {
    // if (tickers.length == 0) return createNotFoundErrorElement();
    let options = '<div class="list" id="sell_ticker__options">';
    $(tickers).each((index, ticker) => {
        options += `<div class="ticker__option" data-value="${ticker.id}" data-text="${ticker.name + ' (' + ticker.company.name + ')'}">
                            <div class="company__name">${ticker.company.name}</div>
                            <div class="ticker__name">${ticker.name}</div>
                    </div>`
    });

    options += '</div>';
    return options;
}

export function createNotFoundErrorElement()
{
    return `<div class="list text-center" id="ticker__options">
                           Пока что ничего не найдено, начните вводить тикер или название компании...</div>`;
}
export function createErrorsElement(messages) {
    let options = `<div class="alert alert-danger p-1 mt-1 mb-3"><ul id="errors">`;
    $(messages).each((index, message) => {
        options += `<li class="error">${message}</li>`;
    });

    options += '</ul></div>';
    return options;
}
