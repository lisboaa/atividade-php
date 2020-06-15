function formatarData(data, formato) {
    switch (formato) {
        case 'BR':
            return data.split('-').reverse().join('/');
            break;

        case 'US':
            return date.split('/').reverse().join('-');
    }
    return '';
}