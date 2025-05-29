import { createI18n } from 'vue-i18n';

import EN from '../lang/EN.json';
import LV from '../lang/LV.json';
import RU from '../lang/RU.json';

export const i18n = createI18n({
    locale: 'EN',
    fallbackLocale: 'EN',
    messages: {
        EN,
        LV,
        RU,
    },
});

export function setI18nLanguage(i18n, locale) {
    if (i18n.mode === 'legacy') {
        i18n.global.locale = locale
    } else {
        i18n.global.locale.value = locale
    }
    /**
     * NOTE:
     * If you need to specify the language setting for headers, such as the `fetch` API, set it here.
     * The following is an example for axios.
     *
     * axios.defaults.headers.common['Accept-Language'] = locale
     */
    document.querySelector('html').setAttribute('lang', locale)
}
