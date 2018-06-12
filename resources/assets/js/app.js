import './bootstrap.js';

import Echo from 'laravel-echo';
import Vue from 'vue';

import CurrentTime from './components/CurrentTime';
import SocialMedia from './components/SocialSharing';
import GoogleCalendar from './components/GoogleCalendar';
import GoogleAnalytics from './components/GoogleAnalytics';
import InternetConnection from './components/InternetConnection';
import LastFm from './components/LastFm';
import RainForecast from './components/RainForecast';
import Twitter from './components/Twitter';
import Pipedrive from './components/Pipedrive';
import Newsletter from './components/Newsletter';
import GoogleTrends from './components/GoogleTrends';

new Vue({

    el: '#dashboard',

    components: {
        CurrentTime,
        SocialMedia,
        GoogleCalendar,
        GoogleAnalytics,
        InternetConnection,
        LastFm,
        RainForecast,
        Twitter,
        Pipedrive,
        Newsletter,
        GoogleTrends
    },

    created() {
        this.echo = new Echo({
            broadcaster: 'pusher',
            key: window.dashboard.pusherKey,
        });
    },
});
