// Translation Dictionary
const translations = {
    en: {
        "dashboard": "Dashboard",
        "sales": "Sales",
        "stock": "Stock",
        "reports": "Reports",
        "settings": "Settings",
        "mini-shop-manager": "Mini Shop Manager",
        "logout": "Logout",
        "admin": "Admin",
        "welcome-back": "WELCOME BACK",
        "sales-transaction": "Sales Transaction",
        "inventory-management": "Inventory Management",
        "sales-reports": "Sales Reports",
        "settings-page": "Settings",
        "english": "English",
        "french": "Français",
        "kinyarwanda": "Kinyarwanda",
        "features": "Features",
        "pricing": "Pricing",
        "login": "Login",
        "manage-shop": "Manage Your Mini Shop with Ease",
        "simplify-stock": "Simplify Stock, Boost Profits, and Track sales Effortlessly. Designed for Rwanda",
        "get-started": "Get Started Now",
        "sign-up": "Sign Up Now",
        "all-features": "All Features",
        "streamlined": "Streamlined Inventory",
        "tracking": "Effortless Tracking",
        "reporting": "Smart Reporting",
        "all-plans": "All Plans",
        "basic-plan": "Basic Plan",
        "pro-plan": "Pro Plan",
        "enterprise-plan": "Enterprise Plan",
        "faq": "FAQ",
        "admin-login": "Admin Login",
        "create-account": "Create Account",
        "simple-pricing": "Simple & Affordable Pricing",
        "choose-plan": "Choose plan that fits your business"
    },
    fr: {
        "dashboard": "Tableau de bord",
        "sales": "Ventes",
        "stock": "Stock",
        "reports": "Rapports",
        "settings": "Paramètres",
        "mini-shop-manager": "Gestionnaire de Mini Boutique",
        "logout": "Déconnexion",
        "admin": "Admin",
        "welcome-back": "BIENVENUE",
        "sales-transaction": "Transaction de Vente",
        "inventory-management": "Gestion des Stocks",
        "sales-reports": "Rapports de Ventes",
        "settings-page": "Paramètres",
        "english": "English",
        "french": "Français",
        "kinyarwanda": "Kinyarwanda",
        "features": "Caractéristiques",
        "pricing": "Tarification",
        "login": "Connexion",
        "manage-shop": "Gérez votre mini-boutique avec facilité",
        "simplify-stock": "Simplifiez les stocks, augmentez les profits et suivez les ventes sans effort. Conçu pour le Rwanda",
        "get-started": "Commencer maintenant",
        "sign-up": "S'inscrire maintenant",
        "all-features": "Toutes les caractéristiques",
        "streamlined": "Inventaire rationalisé",
        "tracking": "Suivi sans effort",
        "reporting": "Rapports intelligents",
        "all-plans": "Tous les plans",
        "basic-plan": "Plan de base",
        "pro-plan": "Plan professionnel",
        "enterprise-plan": "Plan Entreprise",
        "faq": "FAQ",
        "admin-login": "Connexion Admin",
        "create-account": "Créer un compte",
        "simple-pricing": "Tarification simple et abordable",
        "choose-plan": "Choisissez le plan qui convient à votre entreprise"
    },
    rw: {
        "dashboard": "Inyumvire",
        "sales": "Ibicuruzwa",
        "stock": "Igiceri",
        "reports": "Raporo",
        "settings": "Igenamigambi",
        "mini-shop-manager": "Imiyoborere y'Ubwäko Buke",
        "logout": "Kwinjira",
        "admin": "Intebe",
        "welcome-back": "MURAKAZA",
        "sales-transaction": "Ubucuruzo bw'Ibicuruzwa",
        "inventory-management": "Imiyoborere y'Igiceri",
        "sales-reports": "Raporo z'Ibicuruzwa",
        "settings-page": "Igenamigambi",
        "english": "English",
        "french": "Français",
        "kinyarwanda": "Kinyarwanda",
        "features": "Ikintu",
        "pricing": "Imigabire",
        "login": "Kwinjira",
        "manage-shop": "Iyoborera inyumvire y'ubwäko buke neza",
        "simplify-stock": "Koroshya igiceri,ongera inyungu, kandi kwitanga ibisobanuro. Yaremwe kuri Rwanda",
        "get-started": "Tangira",
        "sign-up": "Kwiyandikisha",
        "all-features": "Ikintu cyose",
        "streamlined": "Igiceri cyemewe",
        "tracking": "Kwitanga neza",
        "reporting": "Raporo nziza",
        "all-plans": "Plani zose",
        "basic-plan": "Plani nyinshi",
        "pro-plan": "Plani isobanura",
        "enterprise-plan": "Plani y'umubizihoze",
        "faq": "FAQ",
        "admin-login": "Kwinjira kwa intebe",
        "create-account": "Gukora konti",
        "simple-pricing": "Imigabire yoroshye kandi itangarirwa",
        "choose-plan": "Hitamo plani ijyana n'ubwäko bwawe"
    }
};

// Initialize language
let currentLanguage = localStorage.getItem('selectedLanguage') || 'en';

// Apply language on page load
document.addEventListener('DOMContentLoaded', function() {
    setLanguage(currentLanguage);
    updateLanguageButton();
});

// Translate text
function getTranslation(key) {
    return translations[currentLanguage][key] || translations['en'][key] || key;
}

// Set language
function setLanguage(lang) {
    if (translations[lang]) {
        currentLanguage = lang;
        localStorage.setItem('selectedLanguage', lang);
        applyTranslations();
        updateLanguageButton();
    }
}

// Apply translations to all elements with data-translate attribute
function applyTranslations() {
    document.querySelectorAll('[data-translate]').forEach(element => {
        const key = element.getAttribute('data-translate');
        element.textContent = getTranslation(key);
    });
    
    // Update page title
    const pageTitle = document.querySelector('title');
    if (pageTitle) {
        const titleKey = pageTitle.getAttribute('data-translate-title');
        if (titleKey) {
            pageTitle.textContent = getTranslation(titleKey) + ' - ' + getTranslation('mini-shop-manager');
        }
    }
    
    // Update html lang attribute
    document.documentElement.lang = currentLanguage;
}

// Update language button display
function updateLanguageButton() {
    const langButton = document.getElementById('languageBtn');
    if (langButton) {
        const langNames = {
            'en': 'English',
            'fr': 'Français',
            'rw': 'Kinyarwanda'
        };
        // Update the span text while keeping the icon
        const spanElement = langButton.querySelector('span');
        if (spanElement) {
            spanElement.textContent = langNames[currentLanguage] || 'Language';
        }
    }
    
    // Update active class on dropdown buttons
    document.querySelectorAll('#languageDropdown button').forEach(btn => {
        btn.classList.remove('active');
    });
    const activeBtn = document.querySelector(`#languageDropdown button[data-lang="${currentLanguage}"]`);
    if (activeBtn) {
        activeBtn.classList.add('active');
    }
}

// Toggle language dropdown
function toggleLanguageDropdown() {
    const dropdown = document.getElementById('languageDropdown');
    if (dropdown) {
        dropdown.classList.toggle('show');
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const langSelector = document.getElementById('languageSelector');
    if (langSelector && !langSelector.contains(event.target)) {
        const dropdown = document.getElementById('languageDropdown');
        if (dropdown) {
            dropdown.classList.remove('show');
        }
    }
});
