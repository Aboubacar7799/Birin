import './bootstrap';

import { createApp } from 'vue/dist/vue.esm-bundler.js';
import FollowButton from './components/FollowButton.vue';
import DeleteAccount from './components/DeleteAccount.vue';



const siExiste = document.getElementById('app')
if (siExiste) {
    const app = createApp({
        components: {
            FollowButton,
            DeleteAccount,
        },
    });
    app.component('followbutton', FollowButton);
    app.component('deleteaccount', DeleteAccount);
    app.mount("#app");

    require('./like.js');
}