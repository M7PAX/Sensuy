import { createI18n } from 'vue-i18n';

import en from './langs/en.json';
import lv from './langs/lv.json';
import ru from './langs/ru.json';

export const i18n = createI18n({
    locale: 'en',
    fallbackLocale: 'en',
    messages: {
        en,
        lv,
        ru,
    },
});
