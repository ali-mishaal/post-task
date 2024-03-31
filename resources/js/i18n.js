import { createI18n } from 'vue-i18n';
import arJson from './../lang/ar.json'
import enJson from './../lang/en.json'
import {ref} from "vue";

const messages = {
    en: enJson,
    ar: arJson
};

const selectedLocale = localStorage.getItem('locale') || 'en';

const i18n = createI18n({
    locale: selectedLocale,
    messages
});

export default i18n;
