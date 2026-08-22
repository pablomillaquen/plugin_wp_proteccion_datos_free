/**
 * Chilean Data Protection - Frontend JavaScript
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        ChileanDPFrontend.init();
    });

    var ChileanDPFrontend = {
        init: function() {
            this.initCookieBanner();
            this.initRightsForms();
            this.initComplianceBadge();
        },

        initCookieBanner: function() {
            // Check if user has already dismissed (FREE version - only informational)
            var bannerDismissed = localStorage.getItem('chilean_dp_cookie_dismissed');
            
            if (!bannerDismissed && chilean_dp_frontend.show_cookie_banner) {
                this.showCookieBanner();
            }

            // Handle accept button
            $(document).on('click', '.chilean-dp-cookie-accept', function(e) {
                e.preventDefault();
                ChileanDPFrontend.acceptCookies();
            });

            // Handle settings button
            $(document).on('click', '.chilean-dp-cookie-settings', function(e) {
                e.preventDefault();
                ChileanDPFrontend.openCookieSettings();
            });
        },

        showCookieBanner: function() {
            var html = '<div class="chilean-dp-cookie-banner" id="chilean-dp-cookie-banner" role="dialog" aria-label="Aviso de cookies">' +
                '<div class="chilean-dp-cookie-banner-content">' +
                    '<div class="chilean-dp-cookie-banner-text">' +
                        '<h3>' + chilean_dp_frontend.i18n.cookie_title + '</h3>' +
                        '<p>' + chilean_dp_frontend.i18n.cookie_message + ' ' +
                        '<a href="' + chilean_dp_frontend.cookie_policy_url + '" target="_blank" rel="noopener">' + chilean_dp_frontend.i18n.cookie_policy + '</a>.' +
                        '</p>' +
                    '</div>' +
                    '<div class="chilean-dp-cookie-banner-actions">' +
                        '<button type="button" class="chilean-dp-btn chilean-dp-btn-primary chilean-dp-cookie-accept">' + chilean_dp_frontend.i18n.accept + '</button>' +
                        '<button type="button" class="chilean-dp-btn chilean-dp-btn-secondary chilean-dp-cookie-settings">' + chilean_dp_frontend.i18n.settings + '</button>' +
                    '</div>' +
                '</div>' +
            '</div>';

            $('body').append(html);
            
            // Animate in
            setTimeout(function() {
                $('#chilean-dp-cookie-banner').addClass('chilean-dp-visible');
            }, 100);
        },

        acceptCookies: function() {
            localStorage.setItem('chilean_dp_cookie_dismissed', 'true');
            localStorage.setItem('chilean_dp_cookie_date', Date.now().toString());
            
            $('#chilean-dp-cookie-banner').removeClass('chilean-dp-visible');
            setTimeout(function() {
                $('#chilean-dp-cookie-banner').remove();
            }, 300);
        },

        openCookieSettings: function() {
            // In FREE version, just link to policy page
            window.open(chilean_dp_frontend.cookie_policy_url, '_blank');
        },

        initRightsForms: function() {
            // Handle data subject rights forms
            $('.chilean-dp-rights-form').on('submit', function(e) {
                e.preventDefault();
                var $form = $(this);
                var $submit = $form.find('button[type="submit"]');
                var originalText = $submit.text();

                $submit.prop('disabled', true).text(chilean_dp_frontend.i18n.submitting);

                // Simulate form submission (FREE version - only informational)
                setTimeout(function() {
                    $form.find('.chilean-dp-form-message').remove();
                    $form.prepend('<div class="chilean-dp-info-notice success">' + chilean_dp_frontend.i18n.form_success + '</div>');
                    $submit.prop('disabled', false).text(originalText);
                    $form[0].reset();
                }, 1000);
            });
        },

        initComplianceBadge: function() {
            // Add hover effect to compliance badges
            $('.chilean-dp-compliance-badge').on('mouseenter', function() {
                $(this).addClass('chilean-dp-badge-hover');
            }).on('mouseleave', function() {
                $(this).removeClass('chilean-dp-badge-hover');
            });
        }
    };

    // Make available globally
    window.ChileanDPFrontend = ChileanDPFrontend;

})(jQuery);