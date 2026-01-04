// Bilingual Language Switching System
// Based on welcome.blade.php implementation

const LANG_STORAGE_KEY = 'gym_lang_pref';

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    const savedLang = localStorage.getItem(LANG_STORAGE_KEY) || 'en';
    applyLanguage(savedLang);

    // Bind toggle button if exists
    const toggleBtn = document.getElementById('lang-toggle-btn');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', toggleLanguage);
    }
});

// Toggle between English and Arabic
function toggleLanguage() {
    const currentLang = document.documentElement.getAttribute('lang');
    const newLang = currentLang === 'en' ? 'ar' : 'en';
    applyLanguage(newLang);
}

// Apply language to entire page
function applyLanguage(lang) {
    // Update HTML attributes
    document.documentElement.setAttribute('lang', lang);
    document.documentElement.setAttribute('dir', lang === 'ar' ? 'rtl' : 'ltr');

    // Update all bilingual text elements
    document.querySelectorAll('[data-en]').forEach(el => {
        const text = el.getAttribute(`data-${lang}`);
        if (text) {
            // Use innerHTML to support nested HTML if needed
            el.innerHTML = text;
        }
    });

    // Update language toggle button text
    const btnText = document.getElementById('lang-text');
    if (btnText) {
        btnText.textContent = lang === 'en' ? 'العربية' : 'English';
    }

    // Update page title
    const titleEl = document.querySelector('title[data-en]');
    if (titleEl) {
        titleEl.textContent = titleEl.getAttribute(`data-${lang}`);
    }

    // Save preference
    localStorage.setItem(LANG_STORAGE_KEY, lang);

    // Dispatch custom event for other scripts to listen
    document.dispatchEvent(new CustomEvent('languageChanged', { detail: { lang } }));
}

// Export for use in other scripts if needed
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { toggleLanguage, applyLanguage };
}
