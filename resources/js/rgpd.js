import * as CookieConsent from "vanilla-cookieconsent";

const initRGPD = () => {

    CookieConsent.run({

        categories: {
            necessary: {
                enabled: true,  // this category is enabled by default
                readOnly: true  // this category cannot be disabled
            },
            analytics: {},
            marketing: {},
        },

        language: {
            default: 'fr',
            autoDetect: 'document',
            translations: {
                fr: {
                    consentModal: {
                        title: 'Nous utilisons des cookies',
                        description: '',
                        acceptAllBtn: 'Tout accepter',
                        acceptNecessaryBtn: 'Tout rejeter',
                        showPreferencesBtn: 'Gérer les préférences individuelles'
                    },
                    preferencesModal: {
                        title: 'Gérer les préférences en matière de cookies',
                        acceptAllBtn: 'Tout accepter',
                        acceptNecessaryBtn: 'Tout rejeter',
                        savePreferencesBtn: 'Accepter la sélection actuelle',
                        closeIconLabel: 'Fermer la modale',
                        sections: [
                            {
                                title: 'Quelqu\'un a dit... des cookies ?',
                                description: 'J\'en veux un !'
                            },
                            {
                                title: 'Cookies strictement nécessaires',
                                description: 'Ces cookies sont indispensables au bon fonctionnement du site Internet et ne peuvent être désactivés.',

                                //this field will generate a toggle linked to the 'necessary' category
                                linkedCategory: 'necessary'
                            },
                            {
                                title: 'Performances et analyses',
                                description: 'Ces cookies collectent des informations sur la façon dont vous utilisez notre site Web. Toutes les données sont anonymisées et ne peuvent pas être utilisées pour vous identifier.',
                                linkedCategory: 'analytics'
                            },
                            {
                                title: 'Les cookies marketing',
                                description: 'Ces cookies sont utilisés pour effectuer le suivi des visiteurs au travers des sites web. Le but est d\'afficher des publicités qui sont pertinentes et intéressantes pour l\'utilisateur individuel et donc plus précieuses pour les éditeurs et annonceurs tiers.',
                                linkedCategory: 'marketing'
                            },
                            {
                                title: 'Plus d\'informations',
                                description: 'Pour toute question relative à la politique en matière de cookies et à vos choix, veuillez <a href="/politique-de-confidentialite" target="_blank">consulter notre politique de confidentialité</a>'
                            }
                        ]
                    }
                },
                en: {
                    "consentModal": {
                        "title": 'We use cookies',
                        "description": '',
                        "acceptAllBtn": 'Accept all',
                        "acceptNecessaryBtn": 'Reject all',
                        "showPreferencesBtn": 'Manage individual preferences'
                    },
                    "preferencesModal": {
                        "title": 'Manage cookie preferences',
                        "acceptAllBtn": 'Accept all',
                        "acceptNecessaryBtn": 'Reject all',
                        "savePreferencesBtn": 'Accept current selection',
                        "closeIconLabel": 'Close modal',
                        "sections": [
                            {
                                "title": 'Someone said... cookies?',
                                "description": 'I want one!'
                            },
                            {
                                "title": 'Strictly necessary cookies',
                                "description": 'These cookies are essential for the proper functioning of the website and cannot be disabled.',
                                "linkedCategory": 'necessary'
                            },
                            {
                                "title": 'Performance and analytics',
                                "description": 'These cookies collect information about how you use our website. All data is anonymized and cannot be used to identify you.',
                                "linkedCategory": 'analytics'
                            },
                            {
                                "title": 'Marketing cookies',
                                "description": 'These cookies are used to track visitors across websites. The aim is to display advertisements that are relevant and engaging for the individual user and therefore more valuable for third-party publishers and advertisers.',
                                "linkedCategory": 'marketing'
                            },
                            {
                                "title": 'More information',
                                "description": 'For any questions regarding the cookie policy and your choices, please <a href="/privacy-policy" target="_blank">consult our privacy policy</a>'
                            }
                        ]
                    }
                }

            }
        }
    });
}

export { initRGPD };