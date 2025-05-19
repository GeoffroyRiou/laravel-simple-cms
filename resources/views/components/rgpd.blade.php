@props([
    'matomoId' => null,
    'matomoJs' => null,
    'matomoTrackingScript' => null,
    'gaId' => null,
    'gtmId' => null,
])

@if ($matomoId && $matomoJs && $matomoTrackingScript)
    <!-- Matomo -->
    <script>
        var _paq = window._paq = window._paq || [];
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        _paq.push(['requireCookieConsent']);
        (function() {
            _paq.push(['setTrackerUrl', '{{ $matomoTrackingScript }}']);
            _paq.push(['setSiteId', {{ $matomoId }}]);
            var d = document,
                g = d.createElement('script'),
                s = d.getElementsByTagName('script')[0];
            g.async = true;
            g.src = '{{ $matomoJs }}';
            s.parentNode.insertBefore(g, s);
        })();
    </script>
    <!-- End Matomo Code -->
    <script data-category="analytics" type="text/plain" data-service="Matomo - Envoi des données utilisateur">
    _paq.push(['rememberCookieConsentGiven']);
    </script>
@endif

@if ($gaId || $gtmId)
    <!-- GA & GTM -->
    @if (!empty($gaId))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
    @endif
    @if (!empty($gtmId))
        <script async src="https://www.googletagmanager.com/gtm.js?id={{ $gtmId }}"></script>
    @endif
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        // Paramètres par défaut, aucun consentement
        gtag('consent', 'default', {
            'ad_storage': 'denied',
            'ad_user_data': 'denied',
            'ad_personalization': 'denied',
            'analytics_storage': 'denied',
            'wait_for_update': 500,
        });

        // Google Analytics
        @if(!empty($gaId))
            gtag('js', new Date());
            gtag('config', '<?= $gaId ?>');
        @endif

        // Google Tag Manager
        @if(!empty($gtmId))
            dataLayer.push({
                'gtm.start': new Date().getTime(),
                'event': 'gtm.js'
            });
        @endif
    </script>
    <script data-category="analytics" type="text/plain" data-service="Google Analytics - Stockage lié à l'analyse (visites, durée...)">
    gtag('consent', 'update', {
            'analytics_storage': 'granted'
        });
    </script>
    <script data-category="analytics" type="text/plain" data-service="Google Analytics - Stockage lié à la publicité">
    gtag('consent', 'update', {
            'ad_storage': 'granted',
        });
    </script>
    <script data-category="analytics" type="text/plain" data-service="Google Analytics - Envoi des données utilisateur">
    gtag('consent', 'update', {
            'ad_user_data': 'granted',
        });
    </script>
    <script data-category="analytics" type="text/plain" data-service="Google Analytics - Publicité personnalisée">
    gtag('consent', 'update', {
            'ad_personalization': 'granted',
        });
    </script>

    @if (!empty($gtmId))
        <script data-category="analytics" type="text/plain" data-service="Google Tag Manager - Active le stockage compatible avec les fonctionnalités du site Web ou de l'application, comme les paramètres linguistiques.">
    gtag('consent', 'update', {
            'functionality_storage': 'granted',
            });
        </script>
        <script data-category="analytics" type="text/plain" data-service="Google Tag Manager - Active le stockage lié à la personnalisation (recommandations de vidéos, par exemple).">
    gtag('consent', 'update', {
            'personalization_storage': 'granted',
            });
        </script>
        <script data-category="analytics" type="text/plain" data-service="Google Tag Manager - Permet le stockage lié à la sécurité, comme la fonctionnalité d'authentification, la prévention des fraudes et d'autres mécanismes de protection des utilisateurs.">
    gtag('consent', 'update', {
            'security_storage': 'granted',
            });
        </script>
    @endif
@endif
