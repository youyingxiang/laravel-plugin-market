export default {
    methods: {
        /**
         * Show an error message.
         */
        alertError(message) {
            this.$root.alert.type = 'error';
            this.$root.alert.autoClose = false;
            this.$root.alert.message = message;
            this.$root.alert.time = new Date().getTime()
        },

        alertSuccess(message, autoClose) {
            this.$root.alert.type = 'success';
            this.$root.alert.autoClose = autoClose;
            this.$root.alert.message = message;
            this.$root.alert.time = new Date().getTime()
        },
    }
}