/**
 * Chilean Data Protection - Admin JavaScript
 */
(function($) {
    'use strict';

    // Document ready
    $(document).ready(function() {
        // Initialize admin functionality
        ChileanDPAdmin.init();
    });

    var ChileanDPAdmin = {
        init: function() {
            this.initTabs();
            this.initTooltips();
            this.initValidation();
        },

        initTabs: function() {
            $('.chilean-dp-tabs').each(function() {
                var $tabs = $(this);
                $tabs.find('.chilean-dp-tab').on('click', function(e) {
                    e.preventDefault();
                    var $tab = $(this);
                    var target = $tab.data('tab');

                    $tabs.find('.chilean-dp-tab').removeClass('active');
                    $tab.addClass('active');

                    $tabs.find('.chilean-dp-tab-panel').hide();
                    $('#' + target).show();
                });
            });
        },

        initTooltips: function() {
            $('[data-tooltip]').each(function() {
                var $el = $(this);
                var tooltip = $el.data('tooltip');

                $el.on('mouseenter', function() {
                    var $tooltip = $('<div class="chilean-dp-tooltip">' + tooltip + '</div>');
                    $('body').append($tooltip);

                    var offset = $el.offset();
                    $tooltip.css({
                        top: offset.top - $tooltip.outerHeight() - 8,
                        left: offset.left + ($el.outerWidth() / 2) - ($tooltip.outerWidth() / 2)
                    }).fadeIn(200);
                }).on('mouseleave', function() {
                    $('.chilean-dp-tooltip').remove();
                });
            });
        },

        initValidation: function() {
            // RUT validation for Chilean companies
            $('input[name="chilean_dp_settings[company_rut]"]').on('blur', function() {
                var $input = $(this);
                var rut = $input.val().replace(/[.\-]/g, '');

                if (rut && !ChileanDPAdmin.validateRUT(rut)) {
                    $input.addClass('chilean-dp-error');
                    if (!$input.next('.chilean-dp-error-msg').length) {
                        $input.after('<p class="chilean-dp-error-msg" style="color:#dc3232;font-size:12px;margin-top:4px;">' + chilean_dp_admin.i18n.invalid_rut + '</p>');
                    }
                } else {
                    $input.removeClass('chilean-dp-error');
                    $input.next('.chilean-dp-error-msg').remove();
                }
            });

            // Email validation
            $('input[type="email"]').on('blur', function() {
                var $input = $(this);
                var email = $input.val();
                var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (email && !regex.test(email)) {
                    $input.addClass('chilean-dp-error');
                } else {
                    $input.removeClass('chilean-dp-error');
                }
            });

            // URL validation
            $('input[type="url"]').on('blur', function() {
                var $input = $(this);
                var url = $input.val();

                if (url && !ChileanDPAdmin.validateURL(url)) {
                    $input.addClass('chilean-dp-error');
                } else {
                    $input.removeClass('chilean-dp-error');
                }
            });
        },

        validateRUT: function(rut) {
            // Basic Chilean RUT validation (without verification digit for simplicity)
            // Format: XX.XXX.XXX-X
            var cleanRut = rut.replace(/[^0-9kK]/g, '');
            if (cleanRut.length < 8 || cleanRut.length > 9) {
                return false;
            }
            return true;
        },

        validateURL: function(url) {
            try {
                new URL(url);
                return true;
            } catch (e) {
                return false;
            }
        }
    };

    // Make available globally
    window.ChileanDPAdmin = ChileanDPAdmin;

})(jQuery);