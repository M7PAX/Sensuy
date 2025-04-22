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
