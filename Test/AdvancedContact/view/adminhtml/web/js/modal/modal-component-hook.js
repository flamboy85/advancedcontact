define([
    'Magento_Ui/js/lib/view/utils/async',
    'Magento_Ui/js/modal/alert',
    'mage/translate'
], function ($, alert, $t) {
    'use strict';

    return function (Component) {
        return Component.extend({
            /**
             * Add custom action
             */
            actionSendFeedback: function () {
                var url = this.options.feedback_url;
                if (!url.length) {
                    alert({
                        content: $t('Feedback url not specified.')
                    });
                }
                this.valid = true;
                this.elems().forEach(this.validate, this);

                if (this.valid) {
                    this.sendFeedback(url);
                    // this.closeModal();
                }
            },
            /**
             * Send feedback
             * @param url
             */
            sendFeedback: function (url) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: this.source.data,
                    showLoader: true,
                    complete: function (response) {
                        var status = JSON.parse(response.responseText);
                        if (typeof status.error != 'undefined') {
                            alert({content: message});
                        }
                        else {
                            window.location.reload();
                        }
                    }
                });
            }
        });
    }
});