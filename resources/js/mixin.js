export const myMixin = {
    data() {
        return {
            loadingSpinner: document.getElementById('loadingSpinner')
        }
    },
    methods: {

        showLoadingSpinner() {
            console.log('showLoadingSpinner');
            this.loadingSpinner.style.display = 'block';
        },


        hideLoadingSpinner() {
            this.loadingSpinner.style.display = 'none';
        }
    }
};