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
                if (typeof  this.options.feedback_url != 'undefined') {
                    alert({
                        content: $t('Feedback url not specified.')
                    });
                }
                this.valid = true;
                this.elems().forEach(this.validate, this);

                if (this.valid) {
                    this.sendFeedback(this.options.feedback_url);
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
                            alert({content: status.message});
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